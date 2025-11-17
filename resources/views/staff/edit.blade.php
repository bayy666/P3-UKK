@extends('layouts.admin')

@section('title','Ubah Petugas')
@section('page-title','Ubah Petugas')
@section('page-subtitle','Perbarui data akun petugas')

@section('content')
<div class="max-w-3xl">
  <div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-bold mb-4 flex items-center"><i class="fas fa-user-cog mr-2"></i>Edit Data Petugas</h2>
    @if($errors->any())
      <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3 rounded">
        <p class="text-red-700 font-medium">Periksa kembali input Anda:</p>
        <ul class="list-disc ml-5 text-sm text-red-600 mt-1">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif
    <form method="POST" action="{{ route('staff.update', $petugas->id_petugas) }}" class="space-y-6">
      @csrf
      @method('PUT')
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Petugas</label>
          <input type="text" name="nama_petugas" value="{{ old('nama_petugas', $petugas->nama_petugas) }}" class="mt-1 w-full border rounded px-3 py-2" autocomplete="off" required>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" value="{{ old('username', $petugas->user->username ?? '') }}" class="mt-1 w-full border rounded px-3 py-2" autocomplete="off" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Email (opsional)</label>
            <input type="email" name="email" value="{{ old('email', $petugas->user->email ?? '') }}" class="mt-1 w-full border rounded px-3 py-2" autocomplete="off">
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Password Baru (opsional)</label>
            <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="mt-1 w-full border rounded px-3 py-2">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">No. HP</label>
          <input type="text" name="no_hp" value="{{ old('no_hp', $petugas->no_hp) }}" class="mt-1 w-full border rounded px-3 py-2" autocomplete="off" required>
        </div>
      </div>
      <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('staff.index') }}" class="px-4 py-2 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">Batal</a>
        <button type="submit" class="px-5 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection
