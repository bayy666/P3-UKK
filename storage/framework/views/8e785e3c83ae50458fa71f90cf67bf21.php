<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <style>
    *{ box-sizing:border-box; }
    body{ font-family: DejaVu Sans, sans-serif; color:#1f2937; margin:20px; }
    .title{ font-size:20px; font-weight:700; color:#065f46; margin-bottom:6px; }
    .subtitle{ font-size:12px; color:#6b7280; margin-bottom:16px; }
    .badge{ display:inline-block; padding:6px 10px; border:1px solid #a7f3d0; background:#ecfdf5; color:#065f46; border-radius:8px; font-size:12px; }
    .card{ border:1px solid #e5e7eb; border-radius:12px; padding:16px; margin-top:16px; }
    .row{ display:flex; justify-content:space-between; margin:6px 0; font-size:12px; }
    .label{ color:#6b7280; }
    .value{ font-weight:600; }
    .footer{ margin-top:24px; font-size:11px; color:#6b7280; }
  </style>
</head>
<body>
  <div>
    <div class="title">Bukti Booking</div>
    <div class="subtitle"><?php echo e($appName); ?> &mdash; Sistem Peminjaman Ruangan</div>
    <div class="badge">Booking berhasil dibuat</div>

    <div class="card">
      <div class="row"><div class="label">ID Booking</div><div class="value">#<?php echo e($booking->id_booking); ?></div></div>
      <div class="row"><div class="label">Ruangan</div><div class="value"><?php echo e($booking->room->nama_room); ?></div></div>
      <div class="row"><div class="label">Tanggal</div><div class="value"><?php echo e($booking->tanggal_mulai->translatedFormat('l, d M Y')); ?></div></div>
      <div class="row"><div class="label">Waktu</div><div class="value"><?php echo e($booking->tanggal_mulai->format('H:i')); ?> - <?php echo e($booking->tanggal_selesai->format('H:i')); ?></div></div>
  <div class="row"><div class="label">Durasi</div><div class="value"><?php echo e($booking->durasi); ?> jam</div></div>
  <div class="row"><div class="label">Status</div><div class="value" style="text-transform:capitalize;"><?php echo e($booking->status); ?></div></div>
      <?php if($booking->keterangan): ?>
      <div class="row"><div class="label">Keterangan</div><div class="value"><?php echo e($booking->keterangan); ?></div></div>
      <?php endif; ?>
    </div>

    <div class="footer">Simpan dokumen ini sebagai bukti reservasi. Tunjukkan saat diminta oleh petugas.</div>
  </div>
</body>
</html>
<?php /**PATH C:\Users\M S I\P3-UKK\resources\views/user/slot-booking/confirm-pdf.blade.php ENDPATH**/ ?>