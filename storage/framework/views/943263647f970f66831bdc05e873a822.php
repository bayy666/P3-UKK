<?php $__env->startSection('title', 'Kelola Petugas'); ?>

<?php $__env->startSection('page-icon'); ?>
    <i class="fas fa-user-tie text-indigo-700 mr-3"></i>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-title', 'Kelola Petugas'); ?>

<?php $__env->startSection('page-subtitle', 'Daftar petugas yang mengelola sistem peminjaman ruangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl">
    <!-- Alert Success -->
    <?php if(session('success')): ?>
    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-emerald-500 text-xl mr-3"></i>
            <p class="text-emerald-800 font-medium"><?php echo e(session('success')); ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Card Container -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-users mr-3"></i>
                        Daftar Petugas
                    </h3>
                    <p class="text-gray-300 mt-1">Total: <?php echo e($staff->count()); ?> petugas terdaftar</p>
                </div>
                <?php if(Route::has('staff.create')): ?>
                <a href="<?php echo e(route('staff.create')); ?>" 
                   class="bg-white text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 shadow-md flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Petugas
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Petugas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $petugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            <?php echo e($index + 1); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-12 w-12 flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold text-lg">
                                        <?php echo e(strtoupper(substr($petugas->nama_petugas ?? 'P', 0, 1))); ?>

                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-800">
                                        <?php echo e($petugas->nama_petugas ?? '-'); ?>

                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Petugas
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">
                                <?php echo e($petugas->user->username ?? '-'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">
                                <?php echo e($petugas->user->email ?? '-'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">
                                <?php echo e($petugas->no_hp ?? '-'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs font-medium rounded bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <?php if(Route::has('staff.edit')): ?>
                                <a href="<?php echo e(route('staff.edit', $petugas->id_petugas)); ?>" 
                                   class="inline-flex items-center px-4 py-2 gradient-bg hover:shadow-xl text-white rounded-xl transition-all duration-300 font-bold transform hover:scale-105">
                                    <i class="fas fa-edit mr-1"></i>
                                    Ubah
                                </a>
                                <?php endif; ?>
                                
                                <?php if(Route::has('staff.destroy')): ?>
                                <form action="<?php echo e(route('staff.destroy', $petugas->id_petugas)); ?>" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus petugas ini?')" 
                                      class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded transition-all duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Hapus
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-user-slash text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium">Belum ada data petugas</p>
                                <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Petugas" untuk menambahkan</p>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\staff\index.blade.php ENDPATH**/ ?>