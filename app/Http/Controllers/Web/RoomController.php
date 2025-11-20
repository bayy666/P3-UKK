<?php

namespace App\Http\Controllers\Web;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends BaseController
{
    
    public function index()
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    
    public function create()
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        return view('rooms.create');
    }

    
    public function store(Request $request)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $request->validate([
            'nama_room' => 'required|string',
            'lokasi' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
        ]);

        Room::create([
            'nama_room' => $request->nama_room,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('rooms.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    
    public function edit($id)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

        public function update(Request $request, $id)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $room = Room::findOrFail($id);
        
        $request->validate([
            'nama_room' => 'required|string',
            'lokasi' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
        ]);

        $room->nama_room = $request->nama_room;
        $room->lokasi = $request->lokasi;
        $room->kapasitas = $request->kapasitas;
    $room->deskripsi = $request->deskripsi;
        $room->save();

        return redirect()->route('rooms.index')
            ->with('success', 'Ruangan berhasil diperbarui.');
    }

    
    public function destroy($id)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $room = Room::findOrFail($id);

        
        $bookingsCount = $room->bookings()->count();
        $regulerCount = $room->jadwalRegulers()->count();

        try {
            $room->delete();
        } catch (\Throwable $e) {
            return redirect()->route('rooms.index')
                ->with('error', 'Ruangan gagal dihapus: '.$e->getMessage());
        }

        $info = [];
        if ($bookingsCount > 0) { $info[] = $bookingsCount.' booking'; }
        if ($regulerCount > 0) { $info[] = $regulerCount.' jadwal reguler'; }
        $suffix = count($info) ? ' (otomatis menghapus '.implode(' & ', $info).')' : '';

        return redirect()->route('rooms.index')
            ->with('success', 'Ruangan berhasil dihapus'.$suffix.'.');
    }
}
