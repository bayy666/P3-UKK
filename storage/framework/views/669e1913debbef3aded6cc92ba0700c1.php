<?php $__env->startSection('title', 'Konfirmasi Booking'); ?>
<?php $__env->startSection('content'); ?>
<style>
@media print {
  /* Sembunyikan semua elemen default layout (sidebar, navbar, dll) */
  body * { visibility: hidden !important; }
  /* Tampilkan hanya area bukti */
  #print-area, #print-area * { visibility: visible !important; }
  /* Rapikan tata letak saat cetak */
  #print-area { position: absolute; left: 0; top: 0; width: 100%; max-width: 100%; padding: 0; box-shadow: none !important; }
  .no-print, aside, nav, header, footer { display: none !important; }
  a[href]:after { content: '' !important; }
}
</style>
<div id="print-area" class="max-w-3xl mx-auto space-y-4 md:space-y-6 px-4 md:px-0">
  <div class="text-center space-y-2 md:space-y-3">
    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full mx-auto flex items-center justify-center text-white text-lg md:text-xl shadow" style="background:linear-gradient(135deg,#059669,#10b981)">
      <i class="fas fa-check"></i>
    </div>
    <h1 class="text-2xl md:text-3xl font-bold text-emerald-700">Booking Berhasil Dibuat</h1>
    <p class="text-xs md:text-sm text-gray-600 px-4">Silakan simpan halaman ini sebagai bukti atau hubungi admin melalui WhatsApp bila perlu.</p>
    <?php if(session('success')): ?>
      <div class="px-4 py-2 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm inline-block"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
  </div>

  <div class="bg-white rounded-xl shadow p-4 md:p-5 space-y-3 md:space-y-4">
    <h2 class="font-semibold text-gray-800 flex items-center gap-2 text-sm md:text-base"><i class="fas fa-file-alt text-emerald-600"></i> Detail Booking</h2>
    <div class="text-xs md:text-sm grid grid-cols-1 md:grid-cols-2 gap-y-2">
      <div class="text-gray-600">ID Booking:</div><div class="font-semibold">#<?php echo e($booking->id_booking); ?></div>
      <div class="text-gray-600">Ruangan:</div><div class="font-semibold"><?php echo e($booking->room->nama_room); ?></div>
      <div class="text-gray-600">Tanggal:</div><div class="font-semibold"><?php echo e($booking->tanggal_mulai->translatedFormat('l, d M Y')); ?></div>
      <div class="text-gray-600">Waktu:</div><div class="font-semibold"><?php echo e($booking->tanggal_mulai->format('H:i')); ?> - <?php echo e($booking->tanggal_selesai->format('H:i')); ?></div>
  <div class="text-gray-600">Durasi:</div><div class="font-semibold"><?php echo e($booking->durasi); ?> jam</div>
  <div class="text-gray-600">Status:</div><div class="font-semibold capitalize"><?php echo e($booking->status); ?></div>
      <div class="text-gray-600">Keterangan:</div><div class="font-medium col-span-1 md:col-span-1"><?php echo e($booking->keterangan); ?></div>
    </div>
  </div>

  <div class="bg-white rounded-xl shadow p-4 md:p-5 space-y-3 md:space-y-4">
    <h2 class="font-semibold text-gray-800 flex items-center gap-2 text-sm md:text-base"><i class="fab fa-whatsapp text-green-600"></i> Kontak WhatsApp</h2>
    <?php if($wa): ?>
      <p class="text-xs md:text-sm text-gray-600">Nomor WA Admin: <span class="font-semibold"><?php echo e($wa); ?></span></p>
      <a href="<?php echo e($waLink); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white text-xs md:text-sm font-semibold shadow hover:brightness-110">
        <i class="fab fa-whatsapp"></i> Kirim Konfirmasi via WhatsApp
      </a>
      <p class="text-[10px] md:text-[11px] text-gray-500">Pesan otomatis berisi ID booking, ruangan, tanggal, waktu, dan status.</p>
    <?php else: ?>
      <div class="text-xs md:text-sm text-gray-600">Nomor WhatsApp belum dikonfigurasi. Tambahkan <code>WHATSAPP_NUMBER</code> ke file <code>.env</code>.</div>
    <?php endif; ?>
  </div>

  <div class="flex flex-col sm:flex-row gap-3 justify-between no-print">
    <a href="<?php echo e(route('user.slot-booking.index')); ?>" class="px-4 md:px-5 py-2 rounded-lg bg-gray-200 text-gray-700 text-xs md:text-sm font-medium hover:bg-gray-300 transition text-center">&larr; Kembali ke Daftar Ruangan</a>
    <a href="<?php echo e(route('user.slot-booking.confirm.pdf', $booking->id_booking)); ?>" class="px-4 md:px-5 py-2 rounded-lg bg-red-600 text-white text-xs md:text-sm font-semibold hover:bg-red-700 shadow-sm flex items-center justify-center gap-2"><i class="fas fa-file-pdf"></i> Download PDF</a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/user/slot-booking/confirm.blade.php ENDPATH**/ ?>