<?php $__env->startSection('title', 'Laporan Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
  <!-- Page Header -->
  <div class="bg-gray-700 rounded-2xl p-8 shadow-lg mb-6">
    <div class="flex items-center gap-4">
      <div class="p-4 bg-white/20 text-white rounded-xl">
        <i class="fas fa-chart-bar text-2xl"></i>
      </div>
      <div>
        <h1 class="text-3xl font-bold text-white">Laporan Peminjaman</h1>
        <p class="text-gray-300 text-lg">Filter dan lihat laporan peminjaman ruangan</p>
      </div>
    </div>
  </div>

  <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-900"><i class="fas fa-filter mr-2 text-gray-700"></i>Filter Laporan</h2>
    <form method="GET" action="<?php echo e(route('reports.index')); ?>" class="grid grid-cols-1 md:grid-cols-5 gap-5">
      <!-- Box: Dari Tanggal -->
      <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 h-full flex flex-col justify-between">
        <label class="block text-base font-semibold text-gray-700 mb-2">Dari Tanggal</label>
        <input type="date" name="from" value="<?php echo e($filters['from']); ?>" class="w-full rounded-lg px-3 py-2 text-base bg-white border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
      </div>
      <!-- Box: Sampai Tanggal -->
      <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 h-full flex flex-col justify-between">
        <label class="block text-base font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
        <input type="date" name="to" value="<?php echo e($filters['to']); ?>" class="w-full rounded-lg px-3 py-2 text-base bg-white border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
      </div>
      <!-- Box: Ruangan -->
      <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 h-full flex flex-col justify-between">
        <label class="block text-base font-semibold text-gray-700 mb-2">Ruangan</label>
        <select name="room" class="w-full rounded-lg px-3 py-2 text-base bg-white border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
          <option value="">Semua</option>
          <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($r->id_room); ?>" <?php echo e((string)$filters['room'] === (string)$r->id_room ? 'selected' : ''); ?>><?php echo e($r->nama_room); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <!-- Box: Status -->
      <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 h-full flex flex-col justify-between">
        <label class="block text-base font-semibold text-gray-700 mb-2">Status</label>
        <select name="status" class="w-full rounded-lg px-3 py-2 text-base bg-white border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
          <option value="">Semua</option>
          <option value="proses" <?php echo e($filters['status']==='proses' ? 'selected' : ''); ?>>Proses</option>
          <option value="diterima" <?php echo e($filters['status']==='diterima' ? 'selected' : ''); ?>>Diterima</option>
          <option value="ditolak" <?php echo e($filters['status']==='ditolak' ? 'selected' : ''); ?>>Ditolak</option>
          <option value="selesai" <?php echo e($filters['status']==='selesai' ? 'selected' : ''); ?>>Selesai</option>
        </select>
      </div>
      <!-- Box: Actions -->
      <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 h-full flex items-end justify-between gap-3">
        <a href="<?php echo e(route('reports.export', request()->query())); ?>" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold shadow">Ekspor CSV</a>
        <button type="submit" class="px-5 py-2 gradient-bg text-white rounded-xl hover:shadow-xl font-bold shadow transition-all">
          <i class="fas fa-check mr-2"></i> Terapkan
        </button>
      </div>
    </form>
  </div>

  <div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
      <h3 class="font-semibold text-gray-800">Hasil</h3>
    </div>
    <div class="p-0 overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">ID</th>
            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Tanggal</th>
            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Ruangan</th>
            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Peminjam</th>
            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Petugas</th>
            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Keterangan</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td class="px-4 py-2">#<?php echo e($b->id_booking); ?></td>
            <td class="px-4 py-2">
            <?php echo e(\Carbon\Carbon::parse($b->tanggal_mulai)->translatedFormat('d M Y')); ?> -
            <?php echo e(\Carbon\Carbon::parse($b->tanggal_selesai)->translatedFormat('d M Y')); ?>

            </td>
            <td class="px-4 py-2"><?php echo e($b->room->nama_room ?? '-'); ?></td>
            <td class="px-6 py-4 text-base font-medium text-gray-900"><?php echo e($b->user->username ?? ($b->user->nama ?? '-')); ?></td>
            <td class="px-6 py-4 text-base text-gray-900"><?php echo e($b->petugas->nama_petugas ?? '-'); ?></td>
            <td class="px-6 py-4">
              <?php if($b->status=='proses'): ?>
                <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">Proses</span>
                <?php elseif($b->status=='diterima'): ?>
                  <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">Disetujui</span>
              <?php elseif($b->status=='ditolak'): ?>
                <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">Ditolak</span>
              <?php elseif($b->status=='selesai'): ?>
                <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">Selesai</span>
              <?php else: ?>
                <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo e(ucfirst($b->status)); ?></span>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4 max-w-xs truncate text-base text-gray-700" title="<?php echo e($b->keterangan); ?>"><?php echo e($b->keterangan); ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="7" class="px-6 py-8 text-center text-gray-500 text-base">Tidak ada data.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4 border-t">
      <?php echo e($bookings->links()); ?>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\reports\index.blade.php ENDPATH**/ ?>