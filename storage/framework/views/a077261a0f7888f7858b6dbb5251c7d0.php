<?php $__env->startSection('title', 'Tanggal Diblok (Reguler)'); ?>
<?php $__env->startSection('subtitle', 'Kelola hari nonaktif (full-day) per ruangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
  <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-300 text-green-800 px-5 py-3 rounded-xl"><?php echo e(session('success')); ?></div>
  <?php endif; ?>
  <?php if($errors->any()): ?>
    <div class="bg-red-100 border border-red-300 text-red-800 px-5 py-3 rounded-xl">
      <ul class="list-disc ml-5 text-sm">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($err); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>
  <!-- Header: pindahkan ke dalam blok gradient agar teks putih terbaca dan struktur rapi -->
  <div class="bg-gradient-to-r from-orange-600 to-amber-500 rounded-2xl p-6 shadow-lg flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div class="flex items-start gap-4">
      <div class="p-3 bg-white/20 rounded-xl"><i class="fas fa-calendar-check text-2xl text-white"></i></div>
      <div>
  <h2 class="text-3xl font-bold mb-1 text-white">Hari Nonaktif (Reguler) — Full Day</h2>
  <p class="text-white/90 text-sm md:text-base">Menonaktifkan ruangan sepanjang hari (00:00–23:59) pada rentang tanggal tertentu. Pengajuan yang bertabrakan otomatis ditolak.</p>
      </div>
    </div>
    <a href="<?php echo e(route('jadwal-reguler.create')); ?>" class="inline-flex items-center gap-2 px-5 py-3 bg-white text-orange-600 font-semibold rounded-xl shadow hover:shadow-md hover:bg-orange-50 transition" title="Tambah hari nonaktif untuk ruangan">
      <i class="fas fa-plus"></i>
      <span>Tambah Hari Nonaktif</span>
    </a>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
    <form method="GET" class="flex flex-wrap gap-6 items-end">
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Filter Ruangan</label>
        <select name="room" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
          <option value="">Semua Ruangan</option>
          <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($r->id_room); ?>" <?php if(($roomId ?? '')==$r->id_room): echo 'selected'; endif; ?>><?php echo e($r->nama_room); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Pencarian</label>
        <input type="text" name="q" value="<?php echo e($q ?? ''); ?>" placeholder="Nama atau keterangan" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Mulai (From)</label>
        <input type="date" name="from" value="<?php echo e($from ?? ''); ?>" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Sampai (To)</label>
        <input type="date" name="to" value="<?php echo e($to ?? ''); ?>" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
      </div>
      <div class="flex gap-2 items-center">
        <button class="px-5 py-2.5 bg-orange-600 text-white rounded-lg shadow hover:bg-orange-700"><i class="fas fa-filter mr-1"></i> Terapkan</button>
        <?php if(request()->query()): ?>
          <a href="<?php echo e(route('jadwal-reguler.index')); ?>" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"><i class="fas fa-undo mr-1"></i> Reset</a>
        <?php endif; ?>
      </div>
    </form>

    <div class="overflow-x-auto rounded-xl ring-1 ring-orange-100">
      <table class="min-w-full divide-y divide-orange-100">
        <thead class="bg-orange-50/80 backdrop-blur sticky top-0 z-10">
          <tr class="text-left text-xs font-semibold text-amber-700 uppercase tracking-wider">
            <th class="px-5 py-3">Nama Blok</th>
            <th class="px-5 py-3">Ruangan</th>
            <th class="px-5 py-3">Rentang Tanggal</th>
            <th class="px-5 py-3">Dibuat Oleh</th>
            <th class="px-5 py-3">Keterangan</th>
            <th class="px-5 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-orange-50">
          <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php ($today = now()->toDateString()); ?>
            <?php ($active = ($today >= \Carbon\Carbon::parse($item->tanggal_mulai)->toDateString() && $today <= \Carbon\Carbon::parse($item->tanggal_selesai)->toDateString())); ?>
            <tr class="hover:bg-orange-50/60 transition <?php if($active): ?> bg-emerald-50/60 ring-1 ring-emerald-200 <?php endif; ?>">
              <td class="px-5 py-4">
                <div class="font-semibold text-gray-900 flex items-center gap-2 flex-wrap">
                  <?php echo e($item->nama_reguler); ?>

                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-purple-100 text-purple-700 ring-1 ring-purple-200" title="Blok penuh seharian">
                    <i class="fas fa-lock"></i> Blok Penuh
                  </span>
                  <?php if($active): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200">
                      <i class="fas fa-circle text-[6px]"></i>Aktif Hari Ini
                    </span>
                  <?php endif; ?>
                </div>
              </td>
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm bg-orange-50 text-amber-700 ring-1 ring-orange-200">
                  <i class="fas fa-door-open"></i><?php echo e($item->room->nama_room ?? '—'); ?>

                </span>
              </td>
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                  <i class="fas fa-calendar-day"></i>
                  <?php echo e(\Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y')); ?>

                  <span class="opacity-60">—</span>
                  <?php echo e(\Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y')); ?>

                </span>
                <div class="mt-1 text-[11px] text-gray-500">
                  <a href="<?php echo e(route('schedule.index', ['room' => $item->id_room, 'date' => \Carbon\Carbon::parse($item->tanggal_mulai)->toDateString()])); ?>" class="inline-flex items-center gap-1 text-orange-600 hover:text-orange-700">
                    <i class="fas fa-calendar-alt"></i> Lihat di Kalender
                  </a>
                </div>
              </td>
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm bg-sky-50 text-sky-700 ring-1 ring-sky-200">
                  <i class="fas fa-user"></i><?php echo e(optional($item->user)->nama ?? optional($item->user)->username ?? '—'); ?>

                </span>
              </td>
              <td class="px-5 py-4 text-gray-700 text-sm"><?php echo e($item->keterangan ?: '-'); ?></td>
              <td class="px-5 py-4">
                <div class="flex gap-2">
                  <a href="<?php echo e(route('jadwal-reguler.edit', $item->id_reguler)); ?>" title="Edit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-500/90 text-white hover:bg-amber-600 shadow">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form method="POST" action="<?php echo e(route('jadwal-reguler.destroy', $item->id_reguler)); ?>" onsubmit="return confirm('Hapus jadwal reguler ini?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button title="Hapus" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-500/90 text-white hover:bg-red-600 shadow">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" class="px-5 py-10 text-center">
                <div class="flex flex-col items-center gap-3 text-gray-600">
                  <i class="fas fa-calendar-times text-2xl"></i>
                  <p>Belum ada jadwal reguler.</p>
                  <a href="<?php echo e(route('jadwal-reguler.create')); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                    <i class="fas fa-plus"></i> Tambah Jadwal
                  </a>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?php if(isset($items) && is_object($items) && method_exists($items, 'links')): ?>
      <div class="mt-4">
        <?php echo e($items->links()); ?>

      </div>
    <?php endif; ?>

  <div class="bg-white rounded-2xl p-6 shadow">
    <h3 class="font-bold text-gray-800 mb-2">Apa itu Jadwal Reguler (Hari Nonaktif)?</h3>
    <ul class="text-sm text-gray-600 leading-relaxed list-disc pl-5 space-y-1">
      <li>Membuat ruangan nonaktif sepanjang hari pada rentang tanggal tertentu (full-day).</li>
      <li>Setiap pengajuan peminjaman yang bertabrakan dengan rentang ini akan otomatis ditolak.</li>
      <li>Gunakan untuk perawatan, ujian, atau event internal yang memakai ruangan seharian.</li>
    </ul>
  </div>
</div>
<?php $__env->stopSection(); ?>
 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/jadwal-reguler/index.blade.php ENDPATH**/ ?>