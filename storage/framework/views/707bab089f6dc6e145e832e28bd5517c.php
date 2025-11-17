<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="gradient-bg rounded-2xl p-4 md:p-6 mb-6 shadow-lg">
  <div class="flex items-center gap-4">
    <div class="w-16 h-16 md:w-20 md:h-20 bg-white/30 rounded-full flex items-center justify-center text-white text-2xl md:text-3xl font-bold border-4 border-white/50 shadow-xl">
      <?php echo e(strtoupper(substr($user->nama ?? $user->username ?? 'U', 0, 1))); ?>

    </div>
    <div>
      <h1 class="text-2xl md:text-3xl font-bold text-white"><?php echo e($user->nama ?? $user->username); ?></h1>
      <p class="text-white text-opacity-90 mt-1">
        <?php $r = $user->role ?? 1; ?>
        <?php echo e($r==1?'Administrator':($r==2?'Petugas':'Pengguna')); ?>

      </p>
    </div>
  </div>
</div>

<?php if(session('success')): ?>
  <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-xl shadow-sm mb-6 flex items-center gap-3">
    <i class="fas fa-check-circle text-xl"></i>
    <span class="font-medium"><?php echo e(session('success')); ?></span>
  </div>
<?php endif; ?>

<?php if(session('error')): ?>
  <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl shadow-sm mb-6 flex items-center gap-3">
    <i class="fas fa-exclamation-circle text-xl"></i>
    <span class="font-medium"><?php echo e(session('error')); ?></span>
  </div>
<?php endif; ?>

<?php if($user->role == 3): ?>
<!-- Card Profil User -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-3xl mx-auto">
  <!-- Header -->
  <div class="gradient-bg px-6 py-5">
    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
      <i class="fas fa-user-cog"></i>
      Pengaturan Profil
    </h2>
    <p class="text-white text-opacity-90 text-sm mt-1">Kelola informasi akun dan keamanan Anda</p>
  </div>

  <div class="p-6 md:p-8">
    <!-- Form Gabungan -->
    <form method="POST" action="<?php echo e(route('profile.update')); ?>" autocomplete="off">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      
      <!-- Informasi Profil -->
      <div class="mb-6">
        <div class="flex items-center gap-3 mb-4 pb-3 border-b-2 border-orange-100">
          <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
            <i class="fas fa-user-circle text-orange-600 text-xl"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900">Informasi Profil</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
              <i class="fas fa-user text-orange-600 mr-2"></i>Nama Lengkap
            </label>
            <input type="text" name="nama" value="" readonly onfocus="this.removeAttribute('readonly');" 
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition" 
                   autocomplete="off" placeholder="Masukkan nama lengkap" required>
          </div>
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
              <i class="fas fa-envelope text-orange-600 mr-2"></i>Email
            </label>
            <input type="email" name="email" value="" readonly onfocus="this.removeAttribute('readonly');" 
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition" 
                   autocomplete="off" placeholder="email@example.com">
          </div>
        </div>
      </div>

      <!-- Divider -->
      <div class="border-t-2 border-gray-100 my-6"></div>

      <!-- Ubah Password (Opsional) -->
      <div class="mb-6">
        <div class="flex items-center gap-3 mb-4 pb-3 border-b-2 border-amber-100">
          <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
            <i class="fas fa-key text-amber-600 text-xl"></i>
          </div>
          <div>
            <h3 class="text-lg font-bold text-gray-900">Ubah Password</h3>
            <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
              <i class="fas fa-lock text-amber-600 mr-2"></i>Password Saat Ini
            </label>
            <input type="password" name="current_password" readonly onfocus="this.removeAttribute('readonly');" 
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 transition" 
                   autocomplete="off">
          </div>
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
              <i class="fas fa-lock text-amber-600 mr-2"></i>Password Baru
            </label>
            <input type="password" name="new_password" readonly onfocus="this.removeAttribute('readonly');" 
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 transition" 
                   autocomplete="off">
          </div>
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
              <i class="fas fa-check-circle text-amber-600 mr-2"></i>Konfirmasi Password
            </label>
            <input type="password" name="new_password_confirmation" readonly onfocus="this.removeAttribute('readonly');" 
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 transition" 
                   autocomplete="off">
          </div>
        </div>
      </div>

      <!-- Tombol Simpan -->
      <button type="submit" class="w-full gradient-bg text-white font-bold py-4 rounded-xl hover:shadow-lg transition flex items-center justify-center gap-2">
        <i class="fas fa-save"></i>
        Simpan Semua Perubahan
      </button>
    </form>
  </div>
</div>
<?php else: ?>
<!-- Pesan untuk Admin/Petugas -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-2xl mx-auto">
  <div class="gradient-bg px-6 py-5">
    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
      <i class="fas fa-info-circle"></i>
      Informasi
    </h2>
  </div>
  <div class="p-8 text-center">
    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
      <i class="fas fa-user-shield text-orange-600 text-3xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">Fitur Edit Profil</h3>
    <p class="text-gray-600 mb-4">Fitur edit profil hanya tersedia untuk pengguna biasa.</p>
    <p class="text-sm text-gray-500">Anda login sebagai: <span class="font-bold"><?php echo e($user->role == 1 ? 'Administrator' : 'Petugas'); ?></span></p>
  </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/profile/index.blade.php ENDPATH**/ ?>