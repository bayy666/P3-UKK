<?php $__env->startSection('title', 'Riwayat Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
  <!-- Page Header -->
  <div class="bg-gray-700 rounded-2xl p-8 shadow-lg">
    <div class="flex items-center gap-4">
      <div class="p-4 bg-white/20 text-white rounded-xl">
        <i class="fas fa-history text-3xl"></i>
      </div>
      <div>
        <h1 class="text-3xl font-bold text-white">Riwayat Peminjaman</h1>
        <p class="text-gray-300 text-lg">Lihat semua riwayat peminjaman ruangan Anda</p>
      </div>
    </div>
  </div>

  <!-- Stats Summary -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-semibold text-gray-600 uppercase">Total</p>
          <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($bookings->count()); ?></p>
        </div>
        <div class="p-3 bg-indigo-100 rounded-lg">
          <i class="fas fa-list text-2xl text-indigo-600"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-amber-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-semibold text-gray-600 uppercase">Menunggu</p>
          <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($bookings->where('status', 'proses')->count()); ?></p>
        </div>
        <div class="p-3 bg-amber-100 rounded-lg">
          <i class="fas fa-clock text-2xl text-amber-600"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-emerald-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-semibold text-gray-600 uppercase">Disetujui</p>
          <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($bookings->where('status', 'diterima')->count()); ?></p>
        </div>
        <div class="p-3 bg-emerald-100 rounded-lg">
          <i class="fas fa-check-circle text-2xl text-emerald-600"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-rose-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-semibold text-gray-600 uppercase">Ditolak</p>
          <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($bookings->where('status', 'ditolak')->count()); ?></p>
        </div>
        <div class="p-3 bg-rose-100 rounded-lg">
          <i class="fas fa-times-circle text-2xl text-rose-600"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter -->
  <div class="bg-white rounded-xl shadow-md p-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
      <div class="flex-1 min-w-[200px]">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-filter text-indigo-600 mr-2"></i>Filter Status
        </label>
        <select name="status" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
          <option value="">Semua Status</option>
          <option value="proses" <?php echo e(request('status')=='proses' ? 'selected' : ''); ?>>Menunggu</option>
          <option value="diterima" <?php echo e(request('status')=='diterima' ? 'selected' : ''); ?>>Disetujui</option>
          <option value="ditolak" <?php echo e(request('status')=='ditolak' ? 'selected' : ''); ?>>Ditolak</option>
        </select>
      </div>
      <div class="flex-1 min-w-[200px]">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-calendar text-indigo-600 mr-2"></i>Dari Tanggal
        </label>
        <input type="date" name="dari" value="<?php echo e(request('dari')); ?>" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" />
      </div>
      <div class="flex-1 min-w-[200px]">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-calendar-check text-indigo-600 mr-2"></i>Sampai Tanggal
        </label>
        <input type="date" name="sampai" value="<?php echo e(request('sampai')); ?>" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" />
      </div>
      <div>
        <button type="submit" class="px-6 py-2 gradient-bg text-white rounded-xl hover:shadow-xl font-bold shadow-lg transition duration-300 transform hover:scale-105">
          <i class="fas fa-filter mr-2"></i> Filter
        </button>
        <a href="<?php echo e(route('user.bookings.history')); ?>" class="ml-2 px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold shadow-md hover:shadow-lg transition">
          <i class="fas fa-redo mr-2"></i>Reset
        </a>
      </div>
    </form>
  </div>

  <!-- Daftar Peminjaman -->
  <div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-0 overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Ruangan</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Keperluan</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Status</th>
            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php if(request('status') || request('dari') || request('sampai')): ?>
          <tr>
            <td colspan="5" class="px-6 pt-4">
              <div class="flex flex-wrap items-center gap-2 text-sm">
                <span class="text-gray-500">Filter:</span>
                <?php if(request('status')): ?>
                  <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-700">Status: <?php echo e(ucfirst(request('status'))); ?></span>
                <?php endif; ?>
                <?php if(request('dari')): ?>
                  <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-700">Dari: <?php echo e(request('dari')); ?></span>
                <?php endif; ?>
                <?php if(request('sampai')): ?>
                  <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-700">Sampai: <?php echo e(request('sampai')); ?></span>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endif; ?>
          <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4">
              <div class="flex items-center">
                <div class="bg-indigo-50 p-2 rounded-lg mr-3">
                  <i class="fas fa-door-open text-indigo-600"></i>
                </div>
                <span class="text-base font-semibold text-gray-900"><?php echo e($booking->room->nama_room ?? '-'); ?></span>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="text-base text-gray-900">
                <?php ($start=\Carbon\Carbon::parse($booking->tanggal_mulai)); ?>
                <?php ($end=\Carbon\Carbon::parse($booking->tanggal_selesai)); ?>
                <?php if(($booking->tipe_booking ?? 'hourly') === 'hourly'): ?>
                  <div class="font-semibold"><?php echo e($start->translatedFormat('d M Y')); ?></div>
                  <div class="text-sm text-gray-500"><?php echo e($start->format('H:i')); ?> – <?php echo e($end->format('H:i')); ?> (<?php echo e($end->diffInHours($start)); ?> jam)</div>
                <?php else: ?>
                  <div class="font-semibold"><?php echo e($start->translatedFormat('d M Y')); ?> s/d <?php echo e($end->translatedFormat('d M Y')); ?></div>
                  <div class="text-sm text-gray-500">Durasi <?php echo e($end->diffInDays($start)+1); ?> hari</div>
                <?php endif; ?>
              </div>
            </td>
            <td class="px-6 py-4">
              <span class="text-base text-gray-700"><?php echo e(\Illuminate\Support\Str::limit($booking->keterangan, 50)); ?></span>
            </td>
            <td class="px-6 py-4">
              <?php if($booking->status=='proses'): ?>
                <span class="px-4 py-2 text-sm font-bold rounded-full bg-amber-100 text-amber-800 inline-flex items-center">
                  <i class="fas fa-clock mr-2"></i>Menunggu
                </span>
              <?php elseif($booking->status=='diterima'): ?>
                <span class="px-4 py-2 text-sm font-bold rounded-full bg-emerald-100 text-emerald-800 inline-flex items-center">
                  <i class="fas fa-check-circle mr-2"></i>Disetujui
                </span>
              <?php elseif($booking->status=='ditolak'): ?>
                <span class="px-4 py-2 text-sm font-bold rounded-full bg-rose-100 text-rose-800 inline-flex items-center">
                  <i class="fas fa-times-circle mr-2"></i>Ditolak
                </span>
              <?php else: ?>
                <span class="px-4 py-2 text-sm font-bold rounded-full bg-gray-100 text-gray-800"><?php echo e(ucfirst($booking->status)); ?></span>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4 text-center">
              <div class="mb-2 text-sm text-gray-600">Tipe: <?php echo e(($booking->tipe_booking ?? 'hourly')==='daily' ? 'Per Hari' : 'Per Jam'); ?></div>
              <?php if($booking->status=='proses'): ?>
              <form method="POST" action="<?php echo e(route('user.bookings.cancel', $booking->id_booking)); ?>" onsubmit="return confirm('Yakin ingin membatalkan peminjaman ini?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="px-4 py-2 text-sm font-bold bg-rose-500 hover:bg-rose-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                  <i class="fas fa-times mr-2"></i>Batalkan
                </button>
              </form>
              <?php elseif($booking->status=='ditolak' && $booking->alasan_tolak): ?>
              <button onclick="alert('Alasan: <?php echo e($booking->alasan_tolak); ?>')" class="px-4 py-2 text-sm font-bold bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all">
                <i class="fas fa-info-circle mr-2"></i>Info
              </button>
              <?php else: ?>
              <span class="text-sm text-gray-400">-</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" class="px-6 py-12 text-center">
              <div class="flex flex-col items-center justify-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-semibold">Belum ada riwayat peminjaman</p>
                <p class="text-gray-400 text-base mt-1">Silakan ajukan peminjaman ruangan baru</p>
              </div>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\user\bookings\history.blade.php ENDPATH**/ ?>