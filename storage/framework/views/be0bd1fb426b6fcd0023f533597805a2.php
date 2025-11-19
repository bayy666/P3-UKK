<?php $__env->startSection('title', 'Tambah Ruangan'); ?>

<?php $__env->startSection('page-icon'); ?>
    <i class="fas fa-plus-circle text-gray-700 mr-3"></i>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-title', 'Tambah Ruangan Baru'); ?>

<?php $__env->startSection('page-subtitle', 'Lengkapi form di bawah untuk menambahkan ruangan baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                <i class="fas fa-edit mr-3 text-gray-600"></i>
                Form Tambah Ruangan
            </h3>
        </div>

        <!-- Body -->
        <div class="p-8">
            <form action="<?php echo e(route('rooms.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <!-- Nama Ruangan -->
                <div class="mb-6">
                    <label for="nama_room" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-door-open text-gray-600 mr-2"></i>
                        Nama Ruangan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all <?php $__errorArgs = ['nama_room'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="nama_room" 
                           name="nama_room" 
                           value="<?php echo e(old('nama_room')); ?>" 
                           placeholder="Contoh: Ruang Meeting A"
                           required>
                    <?php $__errorArgs = ['nama_room'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Lokasi -->
                <div class="mb-6">
                    <label for="lokasi" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-map-marker-alt text-gray-600 mr-2"></i>
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all <?php $__errorArgs = ['lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="lokasi" 
                           name="lokasi" 
                           value="<?php echo e(old('lokasi')); ?>" 
                           placeholder="Contoh: Lantai 2, Gedung A"
                           required>
                    <?php $__errorArgs = ['lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Kapasitas -->
                <div class="mb-6">
                    <label for="kapasitas" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-users text-gray-600 mr-2"></i>
                        Kapasitas (Orang) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all <?php $__errorArgs = ['kapasitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="kapasitas" 
                           name="kapasitas" 
                           value="<?php echo e(old('kapasitas')); ?>" 
                           placeholder="Contoh: 20"
                           min="1"
                           required>
                    <?php $__errorArgs = ['kapasitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Info biaya dihapus per permintaan -->

                <!-- Deskripsi -->
                <div class="mb-8">
                    <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                        Deskripsi/Fasilitas <span class="text-red-500">*</span>
                    </label>
                    <textarea class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-gray-500 focus:outline-none transition-all <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="5" 
                              placeholder="Contoh: Dilengkapi proyektor, AC, dan whiteboard"
                              required><?php echo e(old('deskripsi')); ?></textarea>
                    <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    <a href="<?php echo e(route('rooms.index')); ?>" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i> Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 gradient-bg hover:shadow-xl text-white rounded-xl transition-all duration-300 font-bold transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i> Simpan Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/rooms/create.blade.php ENDPATH**/ ?>