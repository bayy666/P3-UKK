<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        
        if ($user->role == 3) {
            $myBookings = \App\Models\Booking::where('id_user', $user->id)->count();
            $pendingBookings = \App\Models\Booking::where('id_user', $user->id)->where('status', 'proses')->count();
            $approvedBookings = \App\Models\Booking::where('id_user', $user->id)->where('status', 'diterima')->count();
            $totalRooms = \App\Models\Room::count();
            
            return view('dashboard.user', compact('myBookings', 'pendingBookings', 'approvedBookings', 'totalRooms'));
        }
        
        
        if ($user->role == 2) {
            $petugas = \App\Models\Petugas::where('id_user', $user->id)->first();
            $assignedId = $petugas->id_petugas ?? null;

            $pendingBookings = $assignedId ? \App\Models\Booking::where('id_petugas', $assignedId)->where('status', 'proses')->count() : 0;
            $approvedBookings = $assignedId ? \App\Models\Booking::where('id_petugas', $assignedId)->where('status', 'diterima')->count() : 0;
            $rejectedBookings = $assignedId ? \App\Models\Booking::where('id_petugas', $assignedId)->where('status', 'ditolak')->count() : 0;
            $totalRooms = \App\Models\Room::count();

            return view('dashboard.petugas', compact('pendingBookings', 'approvedBookings', 'rejectedBookings', 'totalRooms'));
        }

        
        $totalRuangan = \App\Models\Room::count();
        $totalPengguna = \App\Models\User::where('role', 3)->count();
        $peminjamanHariIni = \App\Models\Booking::whereDate('created_at', today())->count();
        $totalPeminjaman = \App\Models\Booking::count();
        
       
        $roomsCount = $totalRuangan;
        $usersCount = $totalPengguna;
        $todayBookings = $peminjamanHariIni;
        $totalBookings = $totalPeminjaman;
        
        return view('dashboard.index', compact('roomsCount', 'usersCount', 'todayBookings', 'totalBookings'));
    }
}
