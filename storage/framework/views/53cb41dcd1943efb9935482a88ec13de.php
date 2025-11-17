<?php $__env->startSection('title','Ubah Petugas'); ?>
<?php $__env->startSection('page-title','Ubah Petugas'); ?>
<?php $__env->startSection('page-subtitle','Perbarui data akun petugas'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl">
  <div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-bold mb-4 flex items-center"><i class="fas fa-user-cog mr-2"></i>Edit Data Petugas</h2>
    <?php if($errors->any()): ?>
      <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3 rounded">
        <p class="text-red-700 font-medium">Periksa kembali input Anda:</p>
        <ul class="list-disc ml-5 text-sm text-red-600 mt-1">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('staff.update', $petugas->id_petugas)); ?>" class="space-y-6">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Petugas</label>
          <input type="text" name="nama_petugas" value="<?php echo e(old('nama_petugas', $petugas->nama_petugas)); ?>" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" value="<?php echo e(old('username', $petugas->user->username ?? '')); ?>" class="mt-1 w-full border rounded px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Email (opsional)</label>
            <input type="email" name="email" value="<?php echo e(old('email', $petugas->user->email ?? '')); ?>" class="mt-1 w-full border rounded px-3 py-2">
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Password Baru (opsional)</label>
            <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="mt-1 w-full border rounded px-3 py-2">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">No. HP</label>
          <input type="text" name="no_hp" value="<?php echo e(old('no_hp', $petugas->no_hp)); ?>" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
      </div>
      <div class="flex justify-end gap-3 pt-4">
        <a href="<?php echo e(route('staff.index')); ?>" class="px-4 py-2 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">Batal</a>
        <button type="submit" class="px-5 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\staff\edit.blade.php ENDPATH**/ ?>