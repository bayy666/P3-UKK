@extends('layouts.admin')

@section('title', 'Ubah Pengguna')

@section('page-icon')
    <i class="fas fa-user-edit text-orange-700 mr-3"></i>
@endsection

@section('page-title', 'Ubah Pengguna')

@section('page-subtitle', 'Perbarui informasi pengguna')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Kepala -->
        <div class="p-6 border-b border-orange-100 bg-orange-50">
            <h3 class="text-xl font-semibold text-orange-900 flex items-center">
                <i class="fas fa-pen mr-3 text-orange-600"></i>
                Form Ubah Pengguna
            </h3>
        </div>

    <!-- Isi -->
        <div class="p-8">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user text-gray-600 mr-2"></i>
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all @error('nama') border-red-500 @enderror" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama', $user->username) }}" 
                               placeholder="Masukkan nama lengkap"
                               autocomplete="off"
                               required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope text-gray-600 mr-2"></i>
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all @error('email') border-red-500 @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               placeholder="nama@email.com"
                               autocomplete="off"
                               required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nama Pengguna -->
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user-tag text-gray-600 mr-2"></i>
                            Nama Pengguna <span class="text-red-500">*</span>
                        </label>
               <input type="text" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all @error('username') border-red-500 @enderror" 
                               id="username" 
                               name="username" 
                               value="{{ old('username', $user->username) }}" 
             placeholder="nama pengguna"
                               autocomplete="off"
                               required>
                        @error('username')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- No Telepon -->
                    <div class="mb-4">
                        <label for="no_telepon" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-phone text-gray-600 mr-2"></i>
                            No. Telepon
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all @error('no_telepon') border-red-500 @enderror" 
                               id="no_telepon" 
                               name="no_telepon" 
                               value="{{ old('no_telepon', $user->no_telepon) }}" 
                               placeholder="08xxxxxxxxxx"
                               autocomplete="off">
                        @error('no_telepon')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label for="role" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-shield-alt text-gray-600 mr-2"></i>
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all @error('role') border-red-500 @enderror" 
                                id="role" 
                                name="role" 
                                required>
                            <option value="">Pilih Role</option>
                            <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Petugas</option>
                            <option value="3" {{ old('role', $user->role) == 3 ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-lock text-gray-600 mr-2"></i>
                            Password Baru
                        </label>
                        <input type="password" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all @error('password') border-red-500 @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Kosongkan jika tidak diubah">
                        <p class="text-gray-500 text-sm mt-1">
                            <i class="fas fa-info-circle mr-1"></i>Kosongkan jika tidak ingin mengubah password
                        </p>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat (Full Width) -->
                <div class="mb-8">
                    <label for="alamat" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-map-marker-alt text-gray-600 mr-2"></i>
                        Alamat
                    </label>
                    <textarea class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all @error('alamat') border-red-500 @enderror" 
                              id="alamat" 
                              name="alamat" 
                              rows="3" 
                              placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tindakan -->
                <div class="flex gap-4">
                    <a href="{{ route('users.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i> Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white rounded-lg transition-all duration-200">
                        <i class="fas fa-save mr-2"></i> Perbarui Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
