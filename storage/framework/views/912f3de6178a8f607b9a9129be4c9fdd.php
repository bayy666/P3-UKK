<?php $__env->startSection('title','Form Booking'); ?>
<?php $__env->startSection('content'); ?>
<div x-data="bookingForm()" class="max-w-5xl mx-auto space-y-6">
  <div class="text-center space-y-3">
    <div class="w-16 h-16 rounded-full mx-auto flex items-center justify-center text-white text-2xl shadow-lg" style="background:linear-gradient(135deg,#c2410c,#ea580c)"><i class="fas fa-edit"></i></div>
    <h1 class="text-4xl font-extrabold tracking-tight text-brown-700">Form Booking</h1>
    <p class="text-sm text-gray-600">Isi detail booking Anda untuk menyelesaikan reservasi</p>
  </div>

  <?php if(session('error')): ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
      <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span><?php echo e(session('error')); ?></span>
      </div>
    </div>
  <?php endif; ?>

  <?php if($errors->any()): ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
      <div class="font-semibold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi kesalahan:</div>
      <ul class="list-disc pl-5 space-y-1">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- Ringkasan Booking -->
  <div class="bg-white rounded-xl shadow p-6 space-y-4">
    <h2 class="font-semibold text-brown-700 flex items-center gap-2 text-lg"><i class="fas fa-info-circle text-orange-600"></i> Ringkasan Booking</h2>
    <div class="grid md:grid-cols-2 gap-4 text-sm">
      <div class="space-y-2">
  <div class="flex justify-between bg-gray-50 rounded-lg px-3 py-2"><span class="text-gray-600">Jenis:</span><span class="font-semibold">Ruangan</span></div>
  <div class="flex justify-between bg-gray-50 rounded-lg px-3 py-2"><span class="text-gray-600">Ruangan:</span><span class="font-semibold"><?php echo e($room->nama_room); ?></span></div>
        <div class="flex justify-between bg-gray-50 rounded-lg px-3 py-2"><span class="text-gray-600">Tanggal:</span><span class="font-semibold"><?php echo e(\Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y')); ?></span></div>
      </div>
      <div class="space-y-2">
        <div class="flex justify-between bg-gray-50 rounded-lg px-3 py-2"><span class="text-gray-600">Waktu:</span><span class="font-semibold"><?php echo e($jam_mulai); ?> - <?php echo e($jam_selesai); ?></span></div>
        <div class="flex justify-between bg-gray-50 rounded-lg px-3 py-2"><span class="text-gray-600">Durasi:</span><span class="font-semibold"><?php echo e($durasi); ?> jam</span></div>
      </div>
    </div>
  </div>

  <form method="POST" action="<?php echo e(route('user.slot-booking.store')); ?>" class="space-y-6">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id_room" value="<?php echo e($room->id_room); ?>">
    <input type="hidden" name="tanggal" value="<?php echo e($tanggal); ?>">
    <input type="hidden" name="jam_mulai" value="<?php echo e($jam_mulai); ?>">
    <input type="hidden" name="jam_selesai" value="<?php echo e($jam_selesai); ?>">

    <!-- Detail Penyewa -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4">
      <h2 class="font-semibold text-brown-700 flex items-center gap-2 text-lg"><i class="fas fa-users text-orange-600"></i> Detail Penyewa</h2>
      <div class="grid md:grid-cols-2 gap-3 text-sm">
        <div>
          <label class="font-semibold">Nama Penyewa</label>
          <input type="text" name="team_name" class="w-full border rounded-lg px-3 py-2" placeholder="Masukkan nama penyewa" required>
        </div>
        <div>
          <label class="font-semibold">Penanggung Jawab</label>
          <input type="text" class="w-full border rounded-lg px-3 py-2" value="<?php echo e(Auth::user()->nama ?? Auth::user()->username); ?>" readonly>
        </div>
      </div>
      <div>
        <label class="font-semibold">Catatan Tambahan <span class="text-red-500">*</span></label>
        <textarea name="keterangan" rows="3" class="w-full border rounded-lg px-3 py-2" placeholder="Catatan khusus, permintaan, atau informasi tambahan..." required></textarea>
      </div>
    </div>

  <!-- Catatan: Tidak ada fitur pembayaran pada sistem ini -->

    <!-- Syarat & Ketentuan -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4">
      <h2 class="font-semibold text-brown-700 flex items-center gap-2 text-lg"><i class="fas fa-scroll text-orange-600"></i> Syarat & Ketentuan</h2>
      <ul class="text-sm space-y-1 bg-amber-50 p-4 rounded-lg border border-amber-200">
        <template x-for="rule in rules" :key="rule">
          <li class="flex items-start gap-2"><i class="fas fa-check text-emerald-600 mt-0.5"></i><span x-text="rule"></span></li>
        </template>
      </ul>
      <label class="text-sm flex items-center gap-2 mt-2">
        <input type="checkbox" name="agree" required> 
        <span>Saya telah membaca dan menyetujui syarat dan ketentuan</span>
      </label>
    </div>

    <div class="flex justify-between items-center">
      <a href="<?php echo e(route('user.slot-booking.show', $room->id_room)); ?>" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-300 transition flex items-center gap-2"><i class="fas fa-arrow-left"></i> Kembali</a>
      <button type="submit" class="px-5 py-2 rounded-lg text-white text-sm font-semibold shadow bg-gradient-to-r from-orange-600 to-amber-500 hover:brightness-110 flex items-center gap-2"><i class="fas fa-paper-plane"></i> Lanjutkan Booking</button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<script>
function bookingForm(){
  return {
    rules:[
      'Booking berlaku setelah dikonfirmasi oleh admin',
      'Pembatalan maksimal 24 jam sebelum jadwal booking',
      'Keterlambatan lebih dari 30 menit dianggap hangus',
      'Wajib menjaga kebersihan dan ketertiban fasilitas'
    ]
  }
}
</script>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\user\slot-booking\form.blade.php ENDPATH**/ ?>