<?php echo csrf_field(); ?>
<div class="space-y-4">
  <div>
    <label class="block text-sm font-medium text-gray-700">Nama Petugas</label>
    <input type="text" name="nama_petugas" value="<?php echo e(old('nama_petugas')); ?>" class="mt-1 w-full border rounded px-3 py-2" required>
    <?php $__errorArgs = ['nama_petugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Username</label>
      <input type="text" name="username" value="<?php echo e(old('username')); ?>" class="mt-1 w-full border rounded px-3 py-2" required>
      <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Email (opsional)</label>
      <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="mt-1 w-full border rounded px-3 py-2">
      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Password</label>
      <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2" required>
      <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700">No. HP</label>
    <input type="text" name="no_hp" value="<?php echo e(old('no_hp')); ?>" class="mt-1 w-full border rounded px-3 py-2" required>
    <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
  </div>
</div>
<?php /**PATH C:\Users\M S I\P3-UKK\resources\views/staff/create_form_fields.blade.php ENDPATH**/ ?>