<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna
     */
    public function index()
    {
        $user = Auth::user();
        
        // Tampilkan halaman untuk semua role, tapi tampilan berbeda
        // User biasa (role 3) bisa edit, admin/petugas hanya melihat info
        return view('profile.index', compact('user'));
    }

    /**
     * Update informasi profil pengguna (gabungan profil + password)
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Hanya izinkan user biasa (role 3)
        if ($user->role !== 3) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Fitur edit profil hanya untuk pengguna biasa.');
        }
        
        // Validasi dasar
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id_user, 'id_user'),
            ],
        ];
        
        // Validasi password jika diisi
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|string|min:6|confirmed';
        }
        
        $request->validate($rules);
        
        // Update profil
        $user->nama = $request->nama;
        $user->email = $request->email;
        
        // Update password jika diisi
        if ($request->filled('current_password')) {
            // Verifikasi password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Password saat ini tidak sesuai.');
            }
            
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        $message = 'Profil berhasil diperbarui!';
        if ($request->filled('current_password')) {
            $message = 'Profil dan password berhasil diperbarui!';
        }
        
        return redirect()->route('profile.index')->with('success', $message);
    }

    /**
     * Update password pengguna
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Verifikasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak sesuai.');
        }
        
        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Update informasi petugas
     */
    public function updateStaff(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role != 2) {
            return redirect()->route('profile.index')->with('error', 'Anda bukan petugas.');
        }
        
        $request->validate([
            'no_hp' => 'required|string|max:15',
        ]);
        
        $petugas = Petugas::where('id_user', $user->id)->first();
        
        if ($petugas) {
            $petugas->no_hp = $request->no_hp;
            $petugas->save();
            
            return redirect()->route('profile.index')->with('success', 'Informasi petugas berhasil diperbarui!');
        }
        
        return redirect()->route('profile.index')->with('error', 'Data petugas tidak ditemukan.');
    }
}
