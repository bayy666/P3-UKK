<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Banner Selamat Datang -->
<div class="bg-gray-700 rounded-2xl p-8 mb-6 shadow-lg">
  <h2 class="text-3xl font-bold text-white">Selamat Datang, <?php echo e(Auth::user()->nama ?? Auth::user()->username); ?> 👋</h2>
  <p class="text-gray-300 mt-2"><?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?></p>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-3 gap-4 md:gap-6 mb-6">
  <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border-l-4 border-indigo-500">
    <div class="flex flex-col md:flex-row items-center md:justify-between gap-3">
      <div class="text-center md:text-left">
        <p class="text-gray-500 text-xs md:text-sm font-semibold">Total Peminjaman</p>
        <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-1"><?php echo e($myBookings ?? 0); ?></p>
      </div>
      <div class="bg-indigo-100 p-2 md:p-3 rounded-lg">
        <i class="fas fa-list text-lg md:text-2xl text-indigo-600"></i>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border-l-4 border-amber-500">
    <div class="flex flex-col md:flex-row items-center md:justify-between gap-3">
      <div class="text-center md:text-left">
        <p class="text-gray-500 text-xs md:text-sm font-semibold">Menunggu Persetujuan</p>
        <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-1"><?php echo e($pendingBookings ?? 0); ?></p>
      </div>
      <div class="bg-amber-100 p-2 md:p-3 rounded-lg">
        <i class="fas fa-clock text-lg md:text-2xl text-amber-600"></i>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border-l-4 border-emerald-500">
    <div class="flex flex-col md:flex-row items-center md:justify-between gap-3">
      <div class="text-center md:text-left">
        <p class="text-gray-500 text-xs md:text-sm font-semibold">Disetujui</p>
        <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-1"><?php echo e($approvedBookings ?? 0); ?></p>
      </div>
      <div class="bg-emerald-100 p-2 md:p-3 rounded-lg">
        <i class="fas fa-check-circle text-lg md:text-2xl text-emerald-600"></i>
      </div>
    </div>
  </div>
</div>

<!-- Menu Cepat -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <a href="<?php echo e(route('user.slot-booking.index')); ?>" class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition text-center group">
    <div class="bg-gray-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
      <i class="fas fa-calendar-plus text-3xl text-white"></i>
    </div>
    <p class="font-bold text-xl text-gray-900">Ajukan Peminjaman</p>
    <p class="text-gray-500 mt-2">Buat permintaan peminjaman ruangan baru</p>
  </a>

  <a href="<?php echo e(route('user.bookings.history')); ?>" class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition text-center group">
    <div class="bg-gray-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
      <i class="fas fa-history text-3xl text-white"></i>
    </div>
    <p class="font-bold text-xl text-gray-900">Riwayat Peminjaman</p>
    <p class="text-gray-500 mt-2">Pantau status disetujui/ditolak</p>
  </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\dashboard\user.blade.php ENDPATH**/ ?>