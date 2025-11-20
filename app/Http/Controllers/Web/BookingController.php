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
    
    protected function getCurrentPetugas()
    {
        return Petugas::where('id_user', optional(Auth::user())->id)->first();
    }

   
    public function index()
    {
        if ($redirect = $this->authorizeRoles([1, 2])) {
            return $redirect;
        }
        
      
        
        $allBookings = Booking::with(['room', 'user', 'petugas.user'])->latest()->get();
        
       
        $pendingBookings = $allBookings->where('status', 'proses')->values();
        $approvedBookings = $allBookings->where('status', 'diterima')->values();
        $rejectedBookings = $allBookings->where('status', 'ditolak')->values();
        
        
        $pendingCount = $pendingBookings->count();
        $approvedCount = $approvedBookings->count();
        $rejectedCount = $rejectedBookings->count();
        $allCount = $allBookings->count();
        
        
        if (Auth::user()->role == 1) {
            
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
            
            $bookings = $allBookings;
            $rooms = Room::orderBy('nama_room')->get(); 
            return view('bookings.index', compact('bookings', 'rooms'));
        }
    }

    // Detail peminjaman
    public function show($id)
    {
        $booking = Booking::with(['room', 'user', 'petugas.user'])->findOrFail($id);
        
        
        if (Auth::user()->role == 2) {
            $petugas = $this->getCurrentPetugas();
            
            if (!$petugas || $booking->id_petugas != $petugas->id_petugas) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Anda tidak memiliki izin untuk melihat peminjaman ini.');
            }
        }
        
        return view('bookings.show', compact('booking'));
    }

   
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $rooms = Room::all();
        $users = User::where('role', 3)->get();
        $petugases = Petugas::all();
        
        
        if (Auth::user()->role == 2) {
            $petugas = $this->getCurrentPetugas();
            
            if (!$petugas || $booking->id_petugas != $petugas->id_petugas) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Anda tidak memiliki izin untuk mengubah peminjaman ini.');
            }
        }
        
        return view('bookings.edit', compact('booking', 'rooms', 'users', 'petugases'));
    }

    
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        
        if (Auth::user()->role == 2) {
            $petugas = $this->getCurrentPetugas();
            
            if (!$petugas || $booking->id_petugas != $petugas->id_petugas) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Anda tidak memiliki izin untuk mengubah peminjaman ini.');
            }
            
            
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

    
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        
       
        if (Auth::user()->role != 1) {
            return redirect()->route('bookings.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus peminjaman.');
        }
        
        $booking->delete();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }

    
    public function approve($id)
    {
        
        if ($redirect = $this->authorizeRoles([2])) {
            return $redirect;
        }
        
        $booking = Booking::findOrFail($id);
        $room = Room::find($booking->id_room);

        
        if ($room && !$room->isAvailable($booking->tanggal_mulai, $booking->tanggal_selesai, $booking->id_booking)) {
            return redirect()->route('bookings.index')
                ->with('error', 'Tidak dapat menyetujui: waktu bertabrakan dengan booking lain atau Jadwal Reguler ruangan ini.');
        }
        
        $booking->status = 'diterima';
       
        $petugas = Petugas::where('id_user', optional(Auth::user())->id)->first();
        if ($petugas) {
            $booking->id_petugas = $petugas->id_petugas;
        }
        
        $booking->alasan_tolak = null;
        $booking->save();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil disetujui.');
    }

    
    public function reject(Request $request, $id)
    {
        
        if ($redirect = $this->authorizeRoles([2])) {
            return $redirect;
        }
        
        $booking = Booking::findOrFail($id);

        
        $request->validate([
            'alasan_tolak' => 'required|string',
        ], [
            'alasan_tolak.required' => 'Alasan penolakan wajib diisi.',
        ]);
        
        
        
        $booking->status = 'ditolak';
        $booking->alasan_tolak = $request->input('alasan_tolak');
        $booking->save();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil ditolak.');
    }

    
    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        
        
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
