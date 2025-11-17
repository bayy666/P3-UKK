<?php $__env->startSection('title', 'Kelola Pengguna'); ?>

<?php $__env->startSection('page-icon'); ?>
    <i class="fas fa-users text-purple-700 mr-3"></i>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-title', 'Kelola Pengguna'); ?>

<?php $__env->startSection('page-subtitle', 'Daftar pengguna yang terdaftar dalam sistem'); ?>

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
        <div class="gradient-bg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-users-cog mr-3"></i>
                        Daftar Pengguna
                    </h3>
                    <p class="text-orange-100 mt-1">Total: <?php echo e($users->count()); ?> pengguna terdaftar</p>
                </div>
                <a href="<?php echo e(route('users.create')); ?>" 
                   class="bg-white text-orange-700 px-6 py-3 rounded-xl font-bold hover:bg-orange-50 transition-all duration-300 shadow-lg flex items-center transform hover:scale-105">
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Pengguna
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-orange-200">
                <thead class="bg-orange-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase">Pengguna</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase">Telepon</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-orange-800 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-orange-100">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-orange-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-800">
                            <?php echo e($index + 1); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-700 font-semibold text-sm">
                                        <?php echo e(strtoupper(substr($user->nama ?? $user->username, 0, 1))); ?>

                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-semibold text-orange-900">
                                        <?php echo e($user->nama ?? $user->username); ?>

                                    </div>
                                    <div class="text-xs text-amber-600">
                                        <?php echo e($user->username); ?>

                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-amber-800">
                                <?php echo e($user->email ?? '-'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-amber-800">
                                <?php echo e($user->no_telepon ?? '-'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($user->role === 1): ?>
                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded bg-orange-100 text-orange-800">
                                    Admin
                                </span>
                            <?php elseif($user->role === 2): ?>
                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded bg-indigo-100 text-indigo-800">
                                    Petugas
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded bg-amber-100 text-amber-800">
                                    Peminjam
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                <?php if($user->role != 1): ?>
                                    <!-- Tombol Ubah hanya untuk User dan Petugas -->
                                    <a href="<?php echo e(route('users.edit', $user->id)); ?>" 
                                       class="inline-flex items-center px-4 py-2 gradient-bg hover:shadow-xl text-white rounded-xl transition-all duration-300 font-bold transform hover:scale-105">
                                        <i class="fas fa-edit mr-1"></i>
                                        Ubah
                                    </a>
                                    
                                    <!-- Tombol Hapus hanya untuk User dan Petugas -->
                                    <form action="<?php echo e(route('users.destroy', $user->id)); ?>" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')" 
                                          class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <!-- Label untuk Admin -->
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 rounded-xl text-sm italic">
                                        <i class="fas fa-lock mr-2"></i>
                                        Tidak dapat diubah
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-user-slash text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium">Belum ada data pengguna</p>
                                <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Pengguna" untuk menambahkan</p>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\users\index.blade.php ENDPATH**/ ?>