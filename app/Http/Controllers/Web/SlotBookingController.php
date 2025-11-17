<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Dompdf\Dompdf;

class SlotBookingController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $counts = ['proses'=>0,'diterima'=>0,'ditolak'=>0];
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $agg = Booking::selectRaw('status, COUNT(*) as total')
                ->where('id_user', $userId)
                ->groupBy('status')->pluck('total','status');
            foreach ($counts as $k=>$_) { $counts[$k] = (int)($agg[$k] ?? 0); }
        }
        return view('user.slot-booking.index', compact('rooms','counts'));
    }

    public function store(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $request->validate([
            'id_room' => 'required|exists:room,id_room',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'team_name' => 'required|string|max:255',
            'keterangan' => 'required|string|max:500',
        ]);

        $room = Room::findOrFail($request->id_room);
        
        $tanggalMulai = Carbon::parse($request->tanggal . ' ' . $request->jam_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal . ' ' . $request->jam_selesai);
        
        // Hitung durasi dalam jam
        $durasi = $tanggalMulai->diffInHours($tanggalSelesai);
        
        if ($durasi <= 0) {
            return back()->with('error', 'Jam selesai harus lebih dari jam mulai!');
        }

        // Cek ketersediaan
        if (!$room->isAvailable($tanggalMulai, $tanggalSelesai)) {
            return back()->with('error', 'Ruangan sudah dibooking untuk waktu tersebut!');
        }

    // Gratis: tidak ada biaya peminjaman
    $harga = 0;

        // Auto-assign petugas
        $petugas = \App\Models\Petugas::first();
        if (!$petugas) {
            $petugasUser = \App\Models\User::where('role', 2)->orWhere('role', 1)->first();
            if ($petugasUser) {
                $petugas = \App\Models\Petugas::create([
                    'nama_petugas' => $petugasUser->username,
                    'id_user' => $petugasUser->id,
                ]);
            }
        }

        // Dapatkan ID user yang sedang login
        $userId = Auth::user()->id;

        $booking = Booking::create([
            'id_user' => $userId,
            'id_room' => $request->id_room,
            'id_petugas' => $petugas->id_petugas,
            'tipe_booking' => 'hourly',
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'harga' => $harga,
            'durasi' => $durasi,
            // Gabungkan nama penyewa dan keterangan
            'keterangan' => 'Penyewa: ' . $request->team_name . ' | ' . $request->keterangan,
            'status' => 'proses',
        ]);

        // Arahkan ke halaman konfirmasi agar user dapat menyimpan bukti + nomor WA
        return redirect()->route('user.slot-booking.confirm', $booking->id_booking)
            ->with('success', 'Booking berhasil! Silakan simpan bukti dan hubungi WA jika diperlukan.');
    }

    // Harga kini dihitung melalui Room::priceForRange

    /**
     * Step 2: Form Booking setelah user memilih slot waktu.
     * Query string: id_room, tanggal, jam_mulai, jam_selesai
     */
    public function form(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'id_room' => 'required|exists:room,id_room',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $room = Room::findOrFail($request->id_room);
        $mulai = Carbon::parse($request->tanggal.' '.$request->jam_mulai);
        $selesai = Carbon::parse($request->tanggal.' '.$request->jam_selesai);

        if ($selesai->lessThanOrEqualTo($mulai)) {
            return redirect()->route('user.slot-booking.show', $room->id_room)
                ->with('error', 'Jam selesai harus lebih dari jam mulai.');
        }

    $durasi = $mulai->diffInHours($selesai);
    // Gratis: selalu 0
    $harga = 0;

        return view('user.slot-booking.form', [
            'room' => $room,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'durasi' => $durasi,
            'harga' => $harga,
        ]);
    }

    /**
     * Halaman detail pemilihan slot (mirip konsep carousel tanggal & grid jam).
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);
        // Tanggal awal = hari ini; build 14 hari ke depan
        $days = [];
        $start = Carbon::today();
        for ($i=0; $i<14; $i++) {
            $d = $start->copy()->addDays($i);
            $days[] = [
                'date' => $d->toDateString(),
                'label' => $d->isoFormat('ddd DD MMM'),
                'dow' => $d->isoFormat('ddd'),
                'day' => $d->format('d'),
                'mon' => $d->isoFormat('MMM'),
                'is_today' => $d->isToday(),
            ];
        }
        return view('user.slot-booking.show', compact('room','days'));
    }

    /**
     * Mengembalikan slot waktu yang masih tersedia (interval bebas) untuk ruangan & tanggal tertentu.
     * Format respon: { date: 'YYYY-MM-DD', room_id: int, free: [ { start: 'HH:MM', end: 'HH:MM', duration: jam }, ... ], occupied: [ { start: 'HH:MM', end: 'HH:MM', status: 'proses|diterima', by: 'user' } ], blocked: true|false }
     */
    public function available(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Terima alias parameter agar lebih toleran dari sisi front-end
        // id_room | room_id | id  dan tanggal | date
        $idRoom = $request->input('id_room') ?? $request->input('room_id') ?? $request->input('id');
        $tanggal = $request->input('tanggal') ?? $request->input('date');

        // Gabungkan kembali ke request untuk memudahkan validasi dan penggunaan selanjutnya
        $request->merge(['id_room' => $idRoom, 'tanggal' => $tanggal]);

        $request->validate([
            'id_room' => 'required|exists:room,id_room',
            'tanggal' => 'required|date',
        ]);

    $room = Room::findOrFail($request->id_room);
    $date = Carbon::parse($request->tanggal)->toDateString();

        // Cek apakah tanggal diblok oleh Jadwal Reguler (rentang meliputi hari tersebut)
        // NOTE: relasi pada model bernama `jadwalRegulers()`
        $blocked = $room->jadwalRegulers()
            ->whereDate('tanggal_mulai', '<=', $date)
            ->whereDate('tanggal_selesai', '>=', $date)
            ->exists();

        // Rentang operasional (asumsi 06:00 - 24:00) - bisa dipindah ke konfigurasi jika perlu
        $open = Carbon::parse($date.' 06:00');
        $close = Carbon::parse($date.' 24:00');

        // Ambil booking yang statusnya proses atau diterima dan OVERLAP dengan hari tersebut
        // (bukan hanya yang mulai pada tanggal itu)
        $bookings = $room->bookings()
            ->whereIn('status', ['proses', 'diterima'])
            ->where(function($q) use ($open, $close) {
                $q->where('tanggal_mulai', '<', $close)
                  ->where('tanggal_selesai', '>', $open);
            })
            ->orderBy('tanggal_mulai')
            ->get(['tanggal_mulai','tanggal_selesai','status']);

        $occupiedIntervals = [];
        foreach ($bookings as $b) {
            $occupiedIntervals[] = [
                'start' => Carbon::parse($b->tanggal_mulai)->format('H:i'),
                'end' => Carbon::parse($b->tanggal_selesai)->format('H:i'),
                'status' => $b->status,
            ];
        }

        // Jika diblok penuh
        if ($blocked) {
            return response()->json([
                'date' => $date,
                'room_id' => $room->id_room,
                'free' => [],
                'occupied' => $occupiedIntervals,
                'blocked' => true,
            ]);
        }

        // Gabungkan dan cari celah kosong
        $cursor = $open->copy();
        $free = [];
        foreach ($bookings as $b) {
            $start = Carbon::parse($b->tanggal_mulai);
            if ($start->greaterThan($cursor)) {
                $free[] = [
                    'start' => $cursor->format('H:i'),
                    'end' => $start->format('H:i'),
                    'duration' => $cursor->diffInHours($start),
                ];
            }
            $end = Carbon::parse($b->tanggal_selesai);
            if ($end->greaterThan($cursor)) {
                $cursor = $end->copy();
            }
        }
        if ($cursor->lessThan($close)) {
            $free[] = [
                'start' => $cursor->format('H:i'),
                'end' => $close->format('H:i'),
                'duration' => $cursor->diffInHours($close),
            ];
        }

        return response()->json([
            'date' => $date,
            'room_id' => $room->id_room,
            'free' => $free,
            'occupied' => $occupiedIntervals,
            'blocked' => false,
        ]);
    }

    /**
     * Halaman konfirmasi setelah berhasil booking.
     */
    public function confirm($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $booking = Booking::with('room')->findOrFail($id);

        // Hanya pemilik booking (role user) yang boleh melihat, kecuali admin/petugas
        $user = Auth::user();
        if (in_array($user->role, [3])) { // 3 = user biasa (asumsi)
            if ($booking->id_user !== $user->id) {
                abort(404);
            }
        }

        $wa = config('app.whatsapp_number');
        $message = rawurlencode(
            "Halo Admin, saya ingin konfirmasi bukti booking.\n".
            "ID Booking: #{$booking->id_booking}\n".
            "Ruangan: {$booking->room->nama_room}\n".
            "Tanggal: ".$booking->tanggal_mulai->translatedFormat('l, d M Y')."\n".
            "Waktu: ".$booking->tanggal_mulai->format('H:i')." - ".$booking->tanggal_selesai->format('H:i')."\n".
            "Status: {$booking->status}"
        );
        $waLink = $wa ? "https://wa.me/{$wa}?text={$message}" : null;

        return view('user.slot-booking.confirm', compact('booking', 'wa', 'waLink'));
    }

    /**
     * Download bukti booking sebagai PDF.
     */
    public function confirmPdf($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $booking = Booking::with('room')->findOrFail($id);
        $user = Auth::user();
        if (in_array($user->role, [3])) {
            if ($booking->id_user !== $user->id) {
                abort(404);
            }
        }

        // Render Blade into HTML
        $html = view('user.slot-booking.confirm-pdf', [
            'booking' => $booking,
            'appName' => config('app.name', 'RoomBook'),
        ])->render();

        // Use Dompdf directly (no Laravel wrapper needed)
        $dompdf = new Dompdf();
        // Ensure relative asset paths resolve from public/
        try { $dompdf->setBasePath(public_path()); } catch (\Throwable $e) { /* ignore */ }
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'bukti-booking-#'.$booking->id_booking.'.pdf';
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
