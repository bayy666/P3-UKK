<?php $__env->startSection('title', 'Peminjaman Ruangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
  <!-- Page Header -->
  <div class="bg-gray-700 rounded-2xl p-8 shadow-lg">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-4">
        <div class="p-4 bg-white/20 text-white rounded-xl">
          <i class="fas fa-calendar-plus text-3xl"></i>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-white">Ajukan Peminjaman Baru</h1>
          <p class="text-gray-300 text-lg">Isi form untuk mengajukan peminjaman ruangan</p>
        </div>
      </div>
      
    </div>
  </div>

  <?php if(session('success')): ?>
    <div id="successAlert" tabindex="-1" class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-lg shadow-sm">
      <div class="flex items-center">
        <i class="fas fa-check-circle text-xl mr-3"></i>
        <span class="font-semibold text-base"><?php echo e(session('success')); ?></span>
      </div>
      
    </div>
    <script>
      // Setelah render, fokus & scroll ke alert agar terlihat jelas
      window.requestAnimationFrame(function(){
        var el = document.getElementById('successAlert');
        if(el){
          el.focus();
          el.scrollIntoView({behavior:'smooth', block:'start'});
        }
      });
    </script>
  <?php endif; ?>
  <?php if(session('error')): ?>
    <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-6 py-4 rounded-lg shadow-sm">
      <div class="flex items-center">
        <i class="fas fa-exclamation-circle text-xl mr-3"></i>
        <span class="font-semibold text-base"><?php echo e(session('error')); ?></span>
      </div>
    </div>
  <?php endif; ?>

  <!-- Form Buat Peminjaman -->
  <div class="bg-white rounded-xl shadow-md p-8 border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 flex items-center">
      <i class="fas fa-plus-circle mr-3 text-gray-700"></i>
      Ajukan Peminjaman Baru
    </h2>
    <form method="POST" action="<?php echo e(route('user.bookings.store')); ?>" class="space-y-6" id="bookingForm">
      <?php echo csrf_field(); ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
          <label class="block text-base font-semibold text-gray-700 mb-2">
            <i class="fas fa-door-open text-gray-600 mr-2"></i>Pilih Ruangan
          </label>
          <select name="id_room" id="roomSelect" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" required>
            <option value="">-- Pilih Ruangan --</option>
            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($room->id_room); ?>">
                <?php echo e($room->nama_room); ?> - <?php echo e($room->lokasi); ?> (Kapasitas: <?php echo e($room->kapasitas); ?> orang)
              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div class="md:col-span-2">
          <label class="block text-base font-semibold text-gray-700 mb-3">
            <i class="fas fa-clock text-gray-600 mr-2"></i>Tipe Booking
          </label>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
              <input type="radio" name="tipe_booking" value="hourly" class="mr-3 w-5 h-5 text-blue-600" checked onchange="updateBookingType()">
              <div class="flex-1">
                <div class="font-bold text-gray-900">Per Jam</div>
                <div class="text-sm text-gray-600">Booking berdasarkan jam</div>
              </div>
            </label>
            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
              <input type="radio" name="tipe_booking" value="daily" class="mr-3 w-5 h-5 text-blue-600" onchange="updateBookingType()">
              <div class="flex-1">
                <div class="font-bold text-gray-900">Per Hari</div>
                <div class="text-sm text-gray-600">Booking berdasarkan hari</div>
              </div>
            </label>
          </div>
        </div>

        <div id="hourlyFields">
          <label class="block text-base font-semibold text-gray-700 mb-2">
            <i class="fas fa-calendar text-gray-600 mr-2"></i>Tanggal
          </label>
          <input type="date" name="tanggal" id="tanggalHourly" min="<?php echo e(date('Y-m-d')); ?>" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" />
        </div>

        <div id="hourlyTimeFields">
          <label class="block text-base font-semibold text-gray-700 mb-2">
            <i class="fas fa-clock text-gray-600 mr-2"></i>Waktu Mulai
          </label>
          <input type="time" name="jam_mulai" id="jamMulai" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" />
        </div>

        <div id="hourlyDurationField">
          <label class="block text-base font-semibold text-gray-700 mb-2">
            <i class="fas fa-hourglass-half text-gray-600 mr-2"></i>Durasi (Jam)
          </label>
          <input type="number" name="durasi_jam" id="durasiJam" min="1" max="12" value="1" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" />
        </div>

        <div id="dailyFieldsStart" style="display:none;">
          <label class="block text-base font-semibold text-gray-700 mb-2">
            <i class="fas fa-calendar text-gray-600 mr-2"></i>Tanggal Mulai
          </label>
          <input type="date" name="tanggal_mulai_daily" id="tanggalMulaiDaily" min="<?php echo e(date('Y-m-d')); ?>" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" />
        </div>
        
        <div id="dailyFieldsEnd" style="display:none;">
          <label class="block text-base font-semibold text-gray-700 mb-2">
            <i class="fas fa-calendar-check text-gray-600 mr-2"></i>Tanggal Selesai
          </label>
          <input type="date" name="tanggal_selesai_daily" id="tanggalSelesaiDaily" min="<?php echo e(date('Y-m-d')); ?>" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" />
        </div>
      </div>
      
      
      <div>
        <label class="block text-base font-semibold text-gray-700 mb-2">
          <i class="fas fa-file-alt text-gray-600 mr-2"></i>Keperluan/Keterangan
        </label>
        <textarea name="keterangan" rows="4" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="Jelaskan keperluan peminjaman ruangan..." required></textarea>
      </div>

      <div>
        <button type="submit" class="px-8 py-3 gradient-bg text-white rounded-xl hover:shadow-xl font-bold shadow-lg transition-all text-base transform hover:scale-105 duration-300">
          <i class="fas fa-paper-plane mr-2"></i> Ajukan Peminjaman
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function updateBookingType() {
  const tipeBooking = document.querySelector('input[name="tipe_booking"]:checked').value;
  const hourlyFields = document.getElementById('hourlyFields');
  const hourlyTimeFields = document.getElementById('hourlyTimeFields');
  const hourlyDurationField = document.getElementById('hourlyDurationField');
  const dailyFieldsStart = document.getElementById('dailyFieldsStart');
  const dailyFieldsEnd = document.getElementById('dailyFieldsEnd');

  if (tipeBooking === 'hourly') {
    hourlyFields.style.display = 'block';
    hourlyTimeFields.style.display = 'block';
    hourlyDurationField.style.display = 'block';
    dailyFieldsStart.style.display = 'none';
    dailyFieldsEnd.style.display = 'none';
    
    document.getElementById('tanggalHourly').required = true;
    document.getElementById('jamMulai').required = true;
    document.getElementById('durasiJam').required = true;
    document.getElementById('tanggalMulaiDaily').required = false;
    document.getElementById('tanggalSelesaiDaily').required = false;
  } else {
    hourlyFields.style.display = 'none';
    hourlyTimeFields.style.display = 'none';
    hourlyDurationField.style.display = 'none';
    dailyFieldsStart.style.display = 'block';
    dailyFieldsEnd.style.display = 'block';
    
    document.getElementById('tanggalHourly').required = false;
    document.getElementById('jamMulai').required = false;
    document.getElementById('durasiJam').required = false;
    document.getElementById('tanggalMulaiDaily').required = true;
    document.getElementById('tanggalSelesaiDaily').required = true;
  }
}
// Tidak ada perhitungan biaya. Fungsi ini hanya mengatur tampilan field berdasarkan tipe booking.
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\user\bookings\index.blade.php ENDPATH**/ ?>