<?php $__env->startSection('title', 'Edit Jadwal Reguler'); ?>
<?php $__env->startSection('subtitle', 'Perbarui blok tanggal penuh untuk ruangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto space-y-8">
  <div class="bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3"><i class="fas fa-calendar-check text-orange-600 text-xl"></i> Edit Jadwal Reguler</h2>
    <?php if($errors->any()): ?>
      <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-4">
        <ul class="list-disc ml-5 text-sm">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($err); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('jadwal-reguler.update', $item->id_reguler)); ?>" class="space-y-6">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Jadwal</label>
          <input type="text" name="nama_reguler" value="<?php echo e(old('nama_reguler', $item->nama_reguler)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Ruangan</label>
          <select name="id_room" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($r->id_room); ?>" <?php if(old('id_room', $item->id_room)==$r->id_room): echo 'selected'; endif; ?>><?php echo e($r->nama_room); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" value="<?php echo e(old('tanggal_mulai', $item->tanggal_mulai)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai</label>
          <input type="date" name="tanggal_selesai" value="<?php echo e(old('tanggal_selesai', $item->tanggal_selesai)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-gray-700 mb-1">Keterangan (opsional)</label>
          <textarea name="keterangan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none"><?php echo e(old('keterangan', $item->keterangan)); ?></textarea>
        </div>
      </div>
      <div class="flex gap-3">
        <button class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg shadow-md transition"><i class="fas fa-save mr-2"></i> Simpan Perubahan</button>
        <a href="<?php echo e(route('jadwal-reguler.index')); ?>" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/jadwal-reguler/edit.blade.php ENDPATH**/ ?>