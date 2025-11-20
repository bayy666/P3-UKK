<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController;
use App\Models\Booking;
use App\Models\JadwalReguler;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalRegulerController extends BaseController
{
        public function index(Request $request)
    {
        if ($redirect = $this->authorizeRoles([1, 2])) {
            return $redirect;
        }

    $roomId = $request->query('room');
    $q = trim((string) $request->query('q', ''));
    $from = $request->query('from');
    $to = $request->query('to');

        $query = JadwalReguler::with(['room', 'user'])->orderBy('tanggal_mulai', 'desc');

        
        if ($roomId) {
            $query->where('id_room', $roomId);
        }

        
        if ($q !== '') {
            $query->where(function ($qb) use ($q) {
                $qb->where('nama_reguler', 'like', "%" . $q . "%")
                   ->orWhere('keterangan', 'like', "%" . $q . "%");
            });
        }

       
        if ($from && $to) {
            $query->where(function ($qb) use ($from, $to) {
                $qb->whereDate('tanggal_mulai', '<=', $to)
                   ->whereDate('tanggal_selesai', '>=', $from);
            });
        } elseif ($from) {
            $query->whereDate('tanggal_selesai', '>=', $from);
        } elseif ($to) {
            $query->whereDate('tanggal_mulai', '<=', $to);
        }

        $items = $query->paginate(10)->withQueryString();
        $rooms = Room::orderBy('nama_room')->get();

        return view('jadwal-reguler.index', compact('items', 'rooms', 'roomId', 'q', 'from', 'to'));
    }

        public function create()
    {
        if ($redirect = $this->authorizeRoles([1, 2])) {
            return $redirect;
        }

        $rooms = Room::orderBy('nama_room')->get();
        return view('jadwal-reguler.create', compact('rooms'));
    }

        public function store(Request $request)
    {
        if ($redirect = $this->authorizeRoles([1, 2])) {
            return $redirect;
        }

        $validated = $request->validate([
            'nama_reguler' => 'required|string|max:50',
            'id_room' => 'required|exists:room,id_room',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
        ]);

        
        $overlapReguler = JadwalReguler::where('id_room', $validated['id_room'])
            ->where(function ($q) use ($validated) {
                $q->where('tanggal_mulai', '<=', $validated['tanggal_selesai'])
                  ->where('tanggal_selesai', '>=', $validated['tanggal_mulai']);
            })
            ->exists();

        if ($overlapReguler) {
            return back()->withInput()->withErrors(['tanggal_mulai' => 'Rentang tanggal bertabrakan dengan jadwal reguler lain di ruangan ini.']);
        }

       
        $overlapBooking = Booking::where('id_room', $validated['id_room'])
            ->whereIn('status', ['proses', 'diterima'])
            ->where(function ($q) use ($validated) {
                $q->whereDate('tanggal_mulai', '<=', $validated['tanggal_selesai'])
                  ->whereDate('tanggal_selesai', '>=', $validated['tanggal_mulai']);
            })
            ->exists();

        if ($overlapBooking) {
            return back()->withInput()->withErrors(['tanggal_mulai' => 'Rentang tanggal bertabrakan dengan peminjaman yang sudah terjadwal.']);
        }

        JadwalReguler::create([
            'nama_reguler' => $validated['nama_reguler'],
            'id_room' => $validated['id_room'],
            'id_user' => Auth::user()->id,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'keterangan' => $validated['keterangan'] ?? '',
        ]);

        return redirect()->route('jadwal-reguler.index')->with('success', 'Jadwal reguler berhasil dibuat.');
    }

    
    public function edit($id)
    {
        if ($redirect = $this->authorizeRoles([1, 2])) {
            return $redirect;
        }

        $item = JadwalReguler::findOrFail($id);
        $rooms = Room::orderBy('nama_room')->get();
        return view('jadwal-reguler.edit', compact('item', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->authorizeRoles([1, 2])) {
            return $redirect;
        }

        $item = JadwalReguler::findOrFail($id);

        $validated = $request->validate([
            'nama_reguler' => 'required|string|max:50',
            'id_room' => 'required|exists:room,id_room',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
        ]);

        
        $overlapReguler = JadwalReguler::where('id_room', $validated['id_room'])
            ->where('id_reguler', '!=', $item->id_reguler)
            ->where(function ($q) use ($validated) {
                $q->where('tanggal_mulai', '<=', $validated['tanggal_selesai'])
                  ->where('tanggal_selesai', '>=', $validated['tanggal_mulai']);
            })
            ->exists();

        if ($overlapReguler) {
            return back()->withInput()->withErrors(['tanggal_mulai' => 'Rentang tanggal bertabrakan dengan jadwal reguler lain di ruangan ini.']);
        }

        // Cek tabrakan dengan booking yang ada (proses/diterima)
        $overlapBooking = Booking::where('id_room', $validated['id_room'])
            ->whereIn('status', ['proses', 'diterima'])
            ->where(function ($q) use ($validated) {
                $q->whereDate('tanggal_mulai', '<=', $validated['tanggal_selesai'])
                  ->whereDate('tanggal_selesai', '>=', $validated['tanggal_mulai']);
            })
            ->exists();

        if ($overlapBooking) {
            return back()->withInput()->withErrors(['tanggal_mulai' => 'Rentang tanggal bertabrakan dengan peminjaman yang sudah terjadwal.']);
        }

        $item->update([
            'nama_reguler' => $validated['nama_reguler'],
            'id_room' => $validated['id_room'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'keterangan' => $validated['keterangan'] ?? '',
        ]);

        return redirect()->route('jadwal-reguler.index')->with('success', 'Jadwal reguler berhasil diperbarui.');
    }

    
    public function destroy($id)
    {
        if ($redirect = $this->authorizeRoles([1, 2])) {
            return $redirect;
        }

        $item = JadwalReguler::findOrFail($id);
        $item->delete();

        return redirect()->route('jadwal-reguler.index')->with('success', 'Jadwal reguler berhasil dihapus.');
    }
}
