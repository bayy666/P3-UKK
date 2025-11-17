<?php $__env->startSection('title','Tambah Petugas'); ?>
<?php $__env->startSection('page-title','Tambah Petugas'); ?>
<?php $__env->startSection('page-subtitle','Form menambahkan akun petugas baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl">
  <div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-bold mb-4 flex items-center"><i class="fas fa-user-plus mr-2"></i>Data Petugas Baru</h2>
    <?php if($errors->any()): ?>
      <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3 rounded">
        <p class="text-red-700 font-medium">Periksa kembali input Anda:</p>
        <ul class="list-disc ml-5 text-sm text-red-600 mt-1">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('staff.store')); ?>" class="space-y-6">
      <?php echo $__env->make('staff.create_form_fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <div class="flex justify-end gap-3 pt-4">
        <a href="<?php echo e(route('staff.index')); ?>" class="px-4 py-2 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">Batal</a>
        <button type="submit" class="px-5 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow">Simpan</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/staff/create.blade.php ENDPATH**/ ?>