<?php $__env->startSection('title', 'Manajemen Ruangan'); ?>

<?php $__env->startSection('page-icon'); ?>
    <i class="fas fa-door-open text-gray-700 mr-3"></i>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-title', 'Manajemen Ruangan'); ?>

<?php $__env->startSection('page-subtitle', 'Kelola semua ruangan yang tersedia untuk peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<!-- Tombol Aksi -->
<div class="mb-6 flex justify-end">
    <a href="<?php echo e(route('rooms.create')); ?>" class="gradient-bg hover:shadow-xl text-white px-6 py-3 rounded-xl font-bold shadow-lg transition-all duration-300 transform hover:scale-105">
        <i class="fas fa-plus-circle mr-2"></i> Tambah Ruangan
    </a>
    </div>

<!-- Daftar Ruangan -->
<?php if($rooms->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-orange-300 transform hover:scale-105">
            <!-- Kepala Kartu dengan Gradient -->
            <div class="p-6 border-b border-orange-200 gradient-bg">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white mb-1"><?php echo e($room->nama_room); ?></h3>
                        <p class="text-orange-100 text-base flex items-center font-medium">
                            <i class="fas fa-map-marker-alt mr-2 text-orange-200"></i>
                            <?php echo e($room->lokasi); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Isi Kartu -->
            <div class="p-6">
                <!-- Kapasitas -->
                <div class="mb-4 flex items-center">
                    <div class="bg-orange-100 rounded-xl p-4 mr-4">
                        <i class="fas fa-users text-orange-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-orange-600 text-sm font-medium uppercase tracking-wide">Kapasitas</p>
                        <p class="text-orange-900 font-bold text-xl"><?php echo e($room->kapasitas); ?> Orang</p>
                    </div>
                </div>

                <!-- Blok biaya disembunyikan per permintaan -->

                <!-- Deskripsi -->
                <div class="mb-6">
                    <p class="text-orange-600 text-sm font-semibold uppercase tracking-wide mb-2">Fasilitas</p>
                    <p class="text-amber-800 text-base font-medium"><?php echo e($room->deskripsi); ?></p>
                </div>

                <!-- Tindakan -->
                <div class="flex gap-3">
                    <a href="<?php echo e(route('rooms.edit', $room->id_room)); ?>" 
                       class="flex-1 gradient-bg hover:shadow-xl text-white py-3 px-5 rounded-xl text-center transition-all duration-300 font-bold shadow-lg transform hover:scale-105">
                        <i class="fas fa-edit mr-1"></i> Ubah
                    </a>
                    <form action="<?php echo e(route('rooms.destroy', $room->id_room)); ?>" 
                          method="POST" 
                          class="flex-1"
                          onsubmit="return confirm('Yakin ingin menghapus ruangan <?php echo e($room->nama_room); ?>?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-5 rounded-xl transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <div class="bg-white rounded-xl shadow-lg p-16 text-center">
        <div class="mb-6">
            <i class="fas fa-door-open text-gray-300 text-8xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Ruangan</h3>
        <p class="text-gray-500 mb-8">Mulai tambahkan ruangan untuk sistem peminjaman</p>
        <a href="<?php echo e(route('rooms.create')); ?>" class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-8 py-4 rounded-lg shadow-md transition-all duration-200">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Ruangan Pertama
        </a>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/rooms/index.blade.php ENDPATH**/ ?>