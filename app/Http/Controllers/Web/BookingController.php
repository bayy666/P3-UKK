<?php

namespace App\Http\Controllers\Web;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Models\Petugas;
use App\Models\JadwalReguler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends BaseController
{
    /**
     * Helper: Ambil data petugas berdasarkan user yang login
     */
    protected function getCurrentPetugas()
    {
        return Petugas::where('id_user', optional(Auth::user())->id)->first();
    }

    // Daftar peminjaman
    public function index()
    {
        if ($redirect = $this->authorizeRoles([1, 2])) {
            return $redirect;
        }
        
        // Admin dan Petugas dapat melihat semua peminjaman
        // Petugas bisa handle booking dari siapa saja (tidak harus yang assigned ke dia)
        $allBookings = Booking::with(['room', 'user', 'petugas.user'])->latest()->get();
        
        // Filter berdasarkan status untuk tabs
        $pendingBookings = $allBookings->where('status', 'proses')->values();
        $approvedBookings = $allBookings->where('status', 'diterima')->values();
        $rejectedBookings = $allBookings->where('status', 'ditolak')->values();
        
        // Hitung jumlah per status
        $pendingCount = $pendingBookings->count();
        $approvedCount = $approvedBookings->count();
        $rejectedCount = $rejectedBookings->count();
        $allCount = $allBookings->count();
        
        // Tampilkan view berbeda untuk admin vs petugas
        if (Auth::user()->role == 1) {
            // Admin melihat tampilan dengan tab dan ringkasan
            return view('bookings.admin', compact(
                'pendingBookings',
                'approvedBookings',
                'rejectedBookings',
                'allBookings',
                'pendingCount',
                'approvedCount',
                'rejectedCount',
                'allCount'
            ));
        } else {
            // Petugas menggunakan tampilan tabel sederhana yang mengharapkan variabel `$bookings`
            // Karena kebijakan: petugas bisa menangani booking siapa saja, kirim semua data
            $bookings = $allBookings;
            $rooms = Room::orderBy('nama_room')->get(); // Semua ruangan untuk filter
            return view('bookings.index', compact('bookings', 'rooms'));
        }
    }

    // Detail peminjaman
    public function show($id)
    {
        $booking = Booking::with(['room', 'user', 'petugas.user'])->findOrFail($id);
        
        // Petugas hanya dapat melihat peminjaman yang dia tangani
        if (Auth::user()->role == 2) {
            $petugas = $this->getCurrentPetugas();
            
            if (!$petugas || $booking->id_petugas != $petugas->id_petugas) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Anda tidak memiliki izin untuk melihat peminjaman ini.');
            }
        }
        
        return view('bookings.show', compact('booking'));
    }

    // Form edit peminjaman
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $rooms = Room::all();
        $users = User::where('role', 3)->get();
        $petugases = Petugas::all();
        
        // Petugas hanya dapat mengubah peminjaman yang dia tangani
        if (Auth::user()->role == 2) {
            $petugas = $this->getCurrentPetugas();
            
            if (!$petugas || $booking->id_petugas != $petugas->id_petugas) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Anda tidak memiliki izin untuk mengubah peminjaman ini.');
            }
        }
        
        return view('bookings.edit', compact('booking', 'rooms', 'users', 'petugases'));
    }

    // Proses update peminjaman
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Petugas hanya dapat mengubah peminjaman yang dia tangani
        if (Auth::user()->role == 2) {
            $petugas = $this->getCurrentPetugas();
            
            if (!$petugas || $booking->id_petugas != $petugas->id_petugas) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Anda tidak memiliki izin untuk mengubah peminjaman ini.');
            }
            
            // Petugas hanya dapat mengubah status dan keterangan
            $request->validate([
                'status' => 'required|string|in:proses,diterima,ditolak,selesai',
                'keterangan' => 'required|string',
            ], [
                'status.required' => 'Status harus dipilih',
                'status.in' => 'Status tidak valid',
                'keterangan.required' => 'Keterangan harus diisi',
            ]);
            
            $booking->status = $request->status;
            $booking->keterangan = $request->keterangan;
        } else {
            // Admin dapat mengubah semua data
            $request->validate([
                'id_user' => 'required|exists:users,id',
                'id_petugas' => 'required|exists:petugas,id_petugas',
                'id_room' => 'required|exists:room,id_room',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'status' => 'required|string|in:proses,diterima,ditolak,selesai',
                'keterangan' => 'required|string',
            ], [
                'id_user.required' => 'Pengguna harus dipilih',
                'id_user.exists' => 'Pengguna tidak ditemukan',
                'id_petugas.required' => 'Petugas harus dipilih',
                'id_petugas.exists' => 'Petugas tidak ditemukan',
                'id_room.required' => 'Ruangan harus dipilih',
                'id_room.exists' => 'Ruangan tidak ditemukan',
                'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
                'tanggal_mulai.date' => 'Tanggal mulai tidak valid',
                'tanggal_selesai.required' => 'Tanggal selesai harus diisi',
                'tanggal_selesai.date' => 'Tanggal selesai tidak valid',
                'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
                'status.required' => 'Status harus dipilih',
                'status.in' => 'Status tidak valid',
                'keterangan.required' => 'Keterangan harus diisi',
            ]);
            
            $booking->id = $request->id;
            $booking->id_petugas = $request->id_petugas;
            $booking->id_room = $request->id_room;
            $booking->tanggal_mulai = $request->tanggal_mulai;
            $booking->tanggal_selesai = $request->tanggal_selesai;
            $booking->status = $request->status;
            $booking->keterangan = $request->keterangan;
        }
        
        $booking->save();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil diperbarui.');
    }

    // Proses hapus peminjaman
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Hanya admin yang dapat menghapus peminjaman
        if (Auth::user()->role != 1) {
            return redirect()->route('bookings.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus peminjaman.');
        }
        
        $booking->delete();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }

    // Approve peminjaman
    public function approve($id)
    {
        // Hanya petugas yang bisa approve
        if ($redirect = $this->authorizeRoles([2])) {
            return $redirect;
        }
        
        $booking = Booking::findOrFail($id);
        $room = Room::find($booking->id_room);

        // Semua petugas bisa approve booking apa saja (tidak perlu cek ownership)
        // Ini lebih fleksibel untuk tim petugas yang bekerja sama
        // Guard ketersediaan: cek terhadap booking lain & jadwal reguler menggunakan helper Room::isAvailable
        if ($room && !$room->isAvailable($booking->tanggal_mulai, $booking->tanggal_selesai, $booking->id_booking)) {
            return redirect()->route('bookings.index')
                ->with('error', 'Tidak dapat menyetujui: waktu bertabrakan dengan booking lain atau Jadwal Reguler ruangan ini.');
        }
        
        $booking->status = 'diterima';
        // Set petugas yang menyetujui bila tersedia
        $petugas = Petugas::where('id_user', optional(Auth::user())->id)->first();
        if ($petugas) {
            $booking->id_petugas = $petugas->id_petugas;
        }
        // Kosongkan alasan tolak jika sebelumnya pernah diisi
        $booking->alasan_tolak = null;
        $booking->save();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil disetujui.');
    }

    // Reject peminjaman
    public function reject(Request $request, $id)
    {
        // Hanya petugas yang bisa menolak
        if ($redirect = $this->authorizeRoles([2])) {
            return $redirect;
        }
        
        $booking = Booking::findOrFail($id);

        // Validasi alasan penolakan jika tersedia di form
        $request->validate([
            'alasan_tolak' => 'required|string',
        ], [
            'alasan_tolak.required' => 'Alasan penolakan wajib diisi.',
        ]);
        
        // Semua petugas bisa reject booking apa saja (tidak perlu cek ownership)
        
        $booking->status = 'ditolak';
        $booking->alasan_tolak = $request->input('alasan_tolak');
        $booking->save();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil ditolak.');
    }

    // Complete peminjaman
    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Petugas hanya dapat menyelesaikan peminjaman yang dia tangani
        if (Auth::user()->role == 2) {
            $petugas = $this->getCurrentPetugas();
            
            if (!$petugas || $booking->id_petugas != $petugas->id_petugas) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Anda tidak memiliki izin untuk menyelesaikan peminjaman ini.');
            }
        }
        
        $booking->status = 'selesai';
        $booking->save();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil diselesaikan.');
    }
}
