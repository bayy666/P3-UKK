<?php

namespace App\Http\Controllers\Web;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $staff = Petugas::with('user')->get();
        return view('staff.index', compact('staff'));
    }

    /**
     * Display the form for creating a new resource.
     */
    public function create()
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
    return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $validatedData = $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'no_hp' => 'required|string|max:20',
        ]);

        // Buat user baru dengan role = 2 (petugas)
        $user = User::create([
            'username'    => $validatedData['username'],
            'nama'        => $validatedData['nama_petugas'],
            'email'       => $validatedData['email'] ?? null,
            'password'    => Hash::make($validatedData['password']),
            'role'        => 2, // Petugas
            'no_telepon'  => $validatedData['no_hp'],
        ]);

        // Buat data petugas
        Petugas::create([
            'id_user'      => $user->id,
            'nama_petugas' => $validatedData['nama_petugas'],
            'no_hp'        => $validatedData['no_hp'],
        ]);

        return redirect()->route('staff.index')->with('success', 'Petugas berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $petugas = Petugas::with('user')->findOrFail($id);
        return view('staff.edit', compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $petugas = Petugas::findOrFail($id);
        $user = User::findOrFail($petugas->id_user);
        
        $validatedData = $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'no_hp' => 'required|string|max:20',
        ]);

        // Update data user
        $user->username = $validatedData['username'];
        $user->nama     = $validatedData['nama_petugas'];
        $user->email    = $validatedData['email'] ?? null;
        $user->no_telepon = $validatedData['no_hp'];
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        // Update data petugas
        $petugas->nama_petugas = $validatedData['nama_petugas'];
        $petugas->no_hp        = $validatedData['no_hp'];
        $petugas->save();

        return redirect()->route('staff.index')->with('success', 'Petugas berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $petugas = Petugas::with(['user', 'bookings.user', 'bookings.room'])->findOrFail($id);
        return view('staff.show', compact('petugas'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($redirect = $this->authorizeRoles([1])) {
            return $redirect;
        }
        
        $petugas = Petugas::findOrFail($id);
        $user = User::findOrFail($petugas->id_user);
        
        // Cek apakah petugas memiliki peminjaman yang ditangani
        $hasBookings = $petugas->bookings()->exists();
        
        if ($hasBookings) {
            return redirect()->route('staff.index')
                ->with('error', 'Petugas tidak dapat dihapus karena masih memiliki peminjaman yang ditangani.');
        }
        
        // Hapus data petugas dan user
        $petugas->delete();
        $user->delete();
        
        return redirect()->route('staff.index')->with('success', 'Petugas berhasil dihapus!');
    }
}
