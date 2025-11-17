<?php

namespace App\Http\Controllers\Web;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    // Daftar user
    public function index()
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        // Admin dapat melihat semua user
        if (Auth::user()->role == 1) {
            $users = User::all();
        } 
        // Petugas hanya dapat melihat user biasa
        else {
            $users = User::where('role', 3)->get();
        }
        
        return view('users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        if ($redirect = $this->authorizeAdmin()) {
            return $redirect;
        }
        
        return view('users.create');
    }

    // Proses tambah user
    public function store(Request $request)
    {
        if ($redirect = $this->authorizeAdmin()) {
            return $redirect;
        }
        
        $request->validate([
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role' => 'required|integer|in:1,2,3',
        ], [
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'nama.required' => 'Nama harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'role.required' => 'Role harus dipilih',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Admin tidak bisa diedit
        if ($user->role == 1) {
            return redirect()->route('users.index')
                ->with('error', 'Admin tidak dapat diedit.');
        }
        
        // Hanya admin yang dapat mengedit petugas
        if (Auth::user()->role != 1 && $user->role == 2) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit petugas.');
        }
        
        $petugas = null;
        if ($user->role == 2) {
            $petugas = Petugas::where('id_user', $user->id)->first();
        }
        
        return view('users.edit', compact('user', 'petugas'));
    }

    // Proses update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Admin tidak bisa diubah
        if ($user->role == 1) {
            return redirect()->route('users.index')
                ->with('error', 'Admin tidak dapat diubah.');
        }

        // Hanya admin yang dapat mengubah petugas
        if (Auth::user()->role != 1 && $user->role == 2) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengubah petugas.');
        }

        $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->id . ',id',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id . ',id',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role' => 'required|integer|in:1,2,3',
        ], [
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'nama.required' => 'Nama harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'role.required' => 'Role harus dipilih',
        ]);

        if ($request->password) {
            $request->validate([
                'password' => 'string|min:6',
            ], [
                'password.min' => 'Password minimal 6 karakter',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Proses hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Mencegah menghapus diri sendiri
    if ($user->id == optional(Auth::user())->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        
        // Hanya admin yang dapat menghapus admin dan petugas
        if (Auth::user()->role != 1 && in_array($user->role, [1, 2])) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus admin atau petugas.');
        }

        // Hapus data petugas jika user adalah petugas
        if ($user->role == 2) {
            $petugas = Petugas::where('id_user', $user->id)->first();
            if ($petugas) {
                $petugas->delete();
            }
        }
        
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
