

<?php $__env->startSection('title', 'Peminjaman'); ?>
<?php $__env->startSection('subtitle', 'Daftar peminjaman terbaru'); ?>

<?php $__env->startSection('content'); ?>
  <!-- Page Header -->
  <div class="bg-gray-700 rounded-2xl p-4 md:p-8 shadow-lg mb-6">
    <div class="flex items-center gap-3 md:gap-4">
      <div class="p-3 md:p-4 bg-white/20 text-white rounded-xl">
        <i class="fas fa-clipboard-list text-xl md:text-2xl"></i>
      </div>
      <div>
        <h1 class="text-2xl md:text-3xl font-bold text-white">Peminjaman</h1>
        <p class="text-gray-300 text-sm md:text-lg">Daftar peminjaman terbaru</p>
      </div>
    </div>
  </div>

  <?php if(session('success')): ?>
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl shadow-sm mb-4 text-base font-medium">
      <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>
  <?php if(session('error')): ?>
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-6 py-4 rounded-xl shadow-sm mb-4 text-base font-medium">
      <i class="fas fa-exclamation-circle mr-2"></i><?php echo e(session('error')); ?>

    </div>
  <?php endif; ?>

  <div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="px-4 md:px-8 py-4 md:py-5 border-b bg-gray-50">
      <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <h3 class="text-lg md:text-xl font-bold text-gray-900"><i class="fas fa-list mr-2 text-gray-600"></i>Daftar Peminjaman</h3>
        <form method="GET" class="flex flex-wrap gap-2 md:gap-3">
          <?php $statusOpt = request('status'); $roomOpt = request('room'); ?>
          <div class="flex-1 min-w-[120px]">
            <label class="block text-xs font-semibold text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
              <option value="">Semua</option>
              <option value="proses" <?php if($statusOpt==='proses'): echo 'selected'; endif; ?>>Proses</option>
              <option value="diterima" <?php if($statusOpt==='diterima'): echo 'selected'; endif; ?>>Disetujui</option>
              <option value="ditolak" <?php if($statusOpt==='ditolak'): echo 'selected'; endif; ?>>Ditolak</option>
              <option value="selesai" <?php if($statusOpt==='selesai'): echo 'selected'; endif; ?>>Selesai</option>
            </select>
          </div>
          <div class="flex-1 min-w-[120px]">
            <label class="block text-xs font-semibold text-gray-700 mb-1">Ruangan</label>
            <select name="room" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
              <option value="">Semua</option>
              <?php $__currentLoopData = $rooms ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($r->id_room); ?>" <?php if((string)$roomOpt===(string)$r->id_room): echo 'selected'; endif; ?>><?php echo e($r->nama_room); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div class="flex gap-2 items-end">
            <button class="px-3 md:px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold whitespace-nowrap"><i class="fas fa-filter mr-1"></i>Terapkan</button>
            <?php if(request()->has('status') || request()->has('room')): ?>
              <a href="<?php echo e(route('bookings.index')); ?>" class="px-3 md:px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm whitespace-nowrap">Reset</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
    <div class="overflow-x-auto table-responsive">
      <table class="min-w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">#</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Pemohon</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Ruangan</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Status</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php 
            $items = collect($bookings ?? []);
            $statusQ = request('status');
            $roomQ = request('room');
            if($statusQ!==null && $statusQ!=='') { $items = $items->where('status', $statusQ)->values(); }
            if($roomQ!==null && $roomQ!=='') { $items = $items->where('id_room', (int)$roomQ)->values(); }
          ?>
          <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php 
              $status = data_get($b, 'status', 'menunggu');
              $username = data_get($b, 'user.username', '-');
              $roomName = data_get($b, 'room.nama_room') ?? data_get($b, 'room.name', '-');
              $mulai = data_get($b, 'tanggal_mulai');
              $selesai = data_get($b, 'tanggal_selesai');
              $mulaiStr = $mulai ? \Carbon\Carbon::parse($mulai)->translatedFormat('d M Y') : '-';
              $selesaiStr = $selesai ? \Carbon\Carbon::parse($selesai)->translatedFormat('d M Y') : '-';
              $idBooking = data_get($b, 'id_booking');

              // Peta status ke Bahasa Indonesia
              $statusKey = is_string($status) ? strtolower(trim($status)) : 'menunggu';
              $statusMap = [
                'pending' => 'Menunggu',
                'menunggu' => 'Menunggu',
                'proses' => 'Proses',
                'process' => 'Proses',
                'approved' => 'Disetujui',
                'approve' => 'Disetujui',
                'accepted' => 'Disetujui',
                'diterima' => 'Disetujui',
                'rejected' => 'Ditolak',
                'reject' => 'Ditolak',
                'ditolak' => 'Ditolak',
                'cancelled' => 'Dibatalkan',
                'canceled' => 'Dibatalkan',
                'dibatalkan' => 'Dibatalkan',
              ];
              $statusLabel = $statusMap[$statusKey] ?? ucfirst($statusKey);
              $badgeMap = [
                'proses' => 'bg-amber-100 text-amber-800',
                'diterima' => 'bg-emerald-100 text-emerald-800',
                'ditolak' => 'bg-rose-100 text-rose-800',
                'selesai' => 'bg-slate-100 text-slate-800',
              ];
              $badgeClass = $badgeMap[$statusKey] ?? 'bg-gray-100 text-gray-800';
            ?>
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4 text-base font-semibold text-gray-900"><?php echo e($i+1); ?></td>
              <td class="px-6 py-4 text-base font-medium text-gray-900"><?php echo e($username); ?></td>
              <td class="px-6 py-4 text-base font-medium text-gray-900"><?php echo e($roomName); ?></td>
              <td class="px-6 py-4 text-base text-gray-900">
                <?php echo e($mulaiStr); ?> - <?php echo e($selesaiStr); ?>

              </td>
              <td class="px-6 py-4">
                <span class="px-3 py-1.5 text-sm font-semibold rounded-full <?php echo e($badgeClass); ?>"><?php echo e($statusLabel); ?></span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <?php $role = Auth::user()->role ?? 1; ?>
                <?php if(in_array($role, [1,2]) && ($status === 'menunggu' || $status === 'proses')): ?>
                  <form method="POST" action="<?php echo e(route('bookings.approve', $idBooking)); ?>" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm hover:shadow transition-all" onclick="return confirm('Setujui peminjaman ini?')">
                      <i class="fas fa-check mr-1"></i>Setujui
                    </button>
                  </form>
                  <form method="POST" action="<?php echo e(route('bookings.reject', $idBooking)); ?>" class="inline ml-2" onsubmit="if(!this.alasan_tolak.value){var x=prompt('Alasan penolakan:'); if(x===null) return false; this.alasan_tolak.value=x;} return confirm('Tolak peminjaman ini?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="alasan_tolak">
                    <button class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-semibold shadow-sm hover:shadow transition-all">
                      <i class="fas fa-times mr-1"></i>Tolak
                    </button>
                  </form>
                <?php else: ?>
                  <span class="text-gray-400 text-sm">-</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-base">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-2 block"></i>
                Belum ada data peminjaman.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\bookings\index.blade.php ENDPATH**/ ?>