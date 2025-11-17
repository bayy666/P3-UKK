@csrf
<div class="space-y-4">
  <div>
    <label class="block text-sm font-medium text-gray-700">Nama Petugas</label>
    <input type="text" name="nama_petugas" value="" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" class="mt-1 w-full border rounded px-3 py-2" required>
    @error('nama_petugas')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Username</label>
      <input type="text" name="username" value="" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" class="mt-1 w-full border rounded px-3 py-2" required>
      @error('username')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Email (opsional)</label>
      <input type="email" name="email" value="" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" class="mt-1 w-full border rounded px-3 py-2">
      @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Password</label>
      <input type="password" name="password" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" class="mt-1 w-full border rounded px-3 py-2" required>
      @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700">No. HP</label>
    <input type="text" name="no_hp" value="" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" class="mt-1 w-full border rounded px-3 py-2" required>
    @error('no_hp')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
  </div>
</div>
