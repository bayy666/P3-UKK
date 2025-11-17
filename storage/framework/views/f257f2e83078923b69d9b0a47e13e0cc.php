

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Banner Selamat Datang -->
<div class="gradient-bg rounded-2xl p-4 md:p-8 mb-6 shadow-lg">
  <h2 class="text-2xl md:text-3xl font-bold text-white">Halo, <?php echo e(Auth::user()->username); ?> 👋</h2>
  <p class="text-white text-opacity-90 mt-2 text-sm md:text-base">Selamat datang kembali di sistem peminjaman ruangan</p>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
  <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border-l-4 border-orange-500 hover:shadow-xl transition-shadow">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-amber-700 text-xs md:text-sm font-semibold">Total Ruangan</p>
        <p class="text-2xl md:text-3xl font-bold text-amber-900 mt-1"><?php echo e($roomsCount ?? 0); ?></p>
      </div>
      <div class="bg-orange-100 p-2 md:p-3 rounded-lg">
        <i class="fas fa-door-open text-xl md:text-2xl text-orange-600"></i>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border-l-4 border-emerald-500 hover:shadow-xl transition-shadow">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-amber-700 text-xs md:text-sm font-semibold">Total Pengguna</p>
        <p class="text-2xl md:text-3xl font-bold text-amber-900 mt-1"><?php echo e($usersCount ?? 0); ?></p>
      </div>
      <div class="bg-emerald-100 p-2 md:p-3 rounded-lg">
        <i class="fas fa-users text-xl md:text-2xl text-emerald-600"></i>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border-l-4 border-amber-500 hover:shadow-xl transition-shadow">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-amber-700 text-xs md:text-sm font-semibold">Peminjaman Hari Ini</p>
        <p class="text-2xl md:text-3xl font-bold text-amber-900 mt-1"><?php echo e($todayBookings ?? 0); ?></p>
      </div>
      <div class="bg-amber-100 p-2 md:p-3 rounded-lg">
        <i class="fas fa-calendar-day text-xl md:text-2xl text-amber-600"></i>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border-l-4 border-rose-500 hover:shadow-xl transition-shadow">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-amber-700 text-xs md:text-sm font-semibold">Total Peminjaman</p>
        <p class="text-2xl md:text-3xl font-bold text-amber-900 mt-1"><?php echo e($totalBookings ?? 0); ?></p>
      </div>
      <div class="bg-rose-100 p-2 md:p-3 rounded-lg">
        <i class="fas fa-list text-xl md:text-2xl text-rose-600"></i>
      </div>
    </div>
  </div>
</div>

<!-- Menu Cepat -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
  <a href="<?php echo e(route('rooms.index')); ?>" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center group">
    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-600 transition">
      <i class="fas fa-door-open text-2xl text-indigo-600 group-hover:text-white"></i>
    </div>
    <p class="font-bold text-gray-900">Kelola Ruangan</p>
    <p class="text-sm text-gray-500 mt-1">Tambah & edit ruangan</p>
  </a>

  <a href="<?php echo e(route('users.index')); ?>" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center group">
    <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-emerald-600 transition">
      <i class="fas fa-users text-2xl text-emerald-600 group-hover:text-white"></i>
    </div>
    <p class="font-bold text-gray-900">Kelola Pengguna</p>
    <p class="text-sm text-gray-500 mt-1">Manajemen user</p>
  </a>

  <a href="<?php echo e(route('bookings.index')); ?>" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center group">
    <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-amber-600 transition">
      <i class="fas fa-clipboard-check text-2xl text-amber-600 group-hover:text-white"></i>
    </div>
    <p class="font-bold text-gray-900">Kelola Peminjaman</p>
    <p class="text-sm text-gray-500 mt-1">Review & approve</p>
  </a>

  <a href="<?php echo e(route('reports.index')); ?>" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center group">
    <div class="bg-rose-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-rose-600 transition">
      <i class="fas fa-chart-bar text-2xl text-rose-600 group-hover:text-white"></i>
    </div>
    <p class="font-bold text-gray-900">Laporan</p>
    <p class="text-sm text-gray-500 mt-1">Lihat statistik</p>
  </a>
</div>

<!-- Aktivitas Terbaru -->
<div class="bg-white rounded-xl p-6 shadow-md">
  <h3 class="font-bold text-xl mb-4 flex items-center">
    <i class="fas fa-clock text-gray-600 mr-2"></i>
    Aktivitas Terbaru
  </h3>
  <div class="space-y-3">
    <?php $__empty_1 = true; $__currentLoopData = ($latestActivities ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="flex items-start gap-3 pb-3 border-b last:border-0">
        <div class="bg-gray-100 p-2 rounded-lg mt-1">
          <i class="fas fa-circle text-xs text-gray-400"></i>
        </div>
        <p class="text-gray-700 flex-1"><?php echo e($item); ?></p>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p class="text-gray-500 text-center py-4">Belum ada aktivitas</p>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/dashboard/index.blade.php ENDPATH**/ ?>