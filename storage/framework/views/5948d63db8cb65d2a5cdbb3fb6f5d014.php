<?php $__env->startSection('title', 'Kelola Jadwal Ruangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
  <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl p-8 shadow-lg">
    <div class="flex items-center gap-4">
      <div class="p-4 bg-white/20 text-white rounded-xl">
        <i class="fas fa-calendar-alt text-3xl"></i>
      </div>
      <div>
        <h2 class="text-3xl font-bold text-white">Kelola Jadwal Ruangan</h2>
        <p class="text-white/90 text-lg">Lihat jadwal peminjaman dan jadwal reguler dalam tampilan kalender</p>
      </div>
    </div>
  </div>

  <!-- Penjelasan singkat agar tidak ambigu -->
  <div class="bg-amber-50 border border-amber-200 text-amber-900 rounded-xl p-4">
    <div class="flex gap-3 items-start">
      <i class="fas fa-info-circle mt-0.5"></i>
      <div class="text-sm leading-relaxed">
        <p class="font-semibold">Apa bedanya Jadwal Ruangan?</p>
        <ul class="list-disc ml-5 mt-1 space-y-1">
          <li><span class="font-medium">Peminjaman</span> adalah booking pengguna. Warnanya menunjukkan status: <span class="font-semibold">Proses</span> (kuning), <span class="font-semibold">Disetujui</span> (hijau), atau <span class="font-semibold">Ditolak</span> (merah).</li>
          <li><span class="font-medium">Jadwal Reguler</span> (ungu) adalah blok rutin yang menutup ruangan pada rentang waktu tertentu.</li>
          <li>Hanya waktu yang <span class="font-medium">tidak tertutup</span> oleh dua hal di atas yang tersedia untuk dibooking.</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Filter by Room & Type -->
  <div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex items-center gap-6 flex-wrap">
      <div class="flex items-center gap-3">
        <label class="font-semibold text-gray-700">Filter Ruangan:</label>
        <select id="roomFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
          <option value="">Semua Ruangan</option>
          <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($room->id_room); ?>"><?php echo e($room->nama_room); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="flex items-center gap-4">
        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
          <input type="checkbox" id="toggleBookings" class="rounded" checked>
          Peminjaman
        </label>
        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
          <input type="checkbox" id="toggleRegular" class="rounded" checked>
          Jadwal Reguler
        </label>
      </div>
      <div class="flex items-center gap-3">
        <label class="font-semibold text-gray-700">Loncat Tanggal:</label>
        <input type="date" id="jumpDate" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
      </div>
      <div class="flex items-center gap-2">
        <span class="text-sm font-semibold text-gray-700">Mode:</span>
        <div class="inline-flex rounded-lg overflow-hidden border border-gray-200">
          <button type="button" id="modeCalendar" class="px-3 py-1.5 text-sm font-semibold bg-orange-600 text-white">Kalender</button>
          <button type="button" id="modeWeekGrid" class="px-3 py-1.5 text-sm font-semibold bg-white text-gray-700 hover:bg-gray-50">Grid Mingguan</button>
        </div>
      </div>
    </div>
    <div id="roomChips" class="mt-4 flex flex-wrap gap-2"></div>
  </div>

  <!-- Calendar Container -->
  <div class="bg-white rounded-xl shadow-lg p-6" id="calendarWrap">
    <div id="calendar"></div>
  </div>

  <div class="bg-white rounded-xl shadow-lg p-6 hidden" id="weekGridWrap">
    <div id="weekGrid"></div>
  </div>

  <!-- Legend -->
  <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4 z-10">
    <h3 class="font-bold text-gray-800 mb-4">Keterangan Status:</h3>
    <div class="flex flex-wrap gap-4">
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 rounded" style="background-color: #fbbf24;"></div>
        <span class="text-sm text-gray-700">Menunggu Persetujuan</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 rounded" style="background-color: #10b981;"></div>
        <span class="text-sm text-gray-700">Disetujui</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 rounded" style="background-color: #ef4444;"></div>
        <span class="text-sm text-gray-700">Ditolak</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 rounded" style="background-color: #9333ea;"></div>
        <span class="text-sm text-gray-700">Jadwal Reguler</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="tag tag-reguler">Reguler</span>
        <span class="tag tag-proses">Proses</span>
        <span class="tag tag-diterima">Disetujui</span>
        <span class="tag tag-ditolak">Ditolak</span>
      </div>
    </div>
  </div>
</div>

<!-- Event Detail Modal -->
<div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
    <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
      <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold text-white">Detail Jadwal</h3>
        <button onclick="closeModal()" class="text-white hover:text-gray-200 transition">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>
    </div>
    <div class="p-6 space-y-4">
      <div>
        <label class="text-sm font-semibold text-gray-600">Ruangan</label>
        <p id="modalRoom" class="text-gray-800 font-medium"></p>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-semibold text-gray-600">Mulai</label>
          <p id="modalStart" class="text-gray-800"></p>
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-600">Selesai</label>
          <p id="modalEnd" class="text-gray-800"></p>
        </div>
      </div>
      <div>
        <label class="text-sm font-semibold text-gray-600">Keterangan</label>
        <p id="modalDesc" class="text-gray-800"></p>
      </div>
      <div>
        <label class="text-sm font-semibold text-gray-600">Jenis / Status</label>
        <div id="modalStatus"></div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<style>
  #calendar { max-width: 100%; }
  .fc .fc-button-primary { background-color: #f97316; border-color: #f97316; }
  .fc .fc-button-primary:hover { background-color: #ea580c; border-color: #ea580c; }
  .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #c2410c; border-color: #c2410c; }
  .fc-event { cursor: pointer; }
  .fc-daygrid-event { white-space: normal !important; align-items: start !important; }
  .fc .fc-daygrid-day-frame { min-height: 140px; padding-bottom: 8px; }
  @media (min-width: 768px) { .fc .fc-daygrid-day-frame { min-height: 180px; } }
  .fc .fc-daygrid-day-number { font-size: 1rem; font-weight: 700; padding: 6px 8px; }
  /* Today highlight */
  .fc .fc-day-today .fc-daygrid-day-frame { background: #FFF7ED; outline: 2px solid #FDBA74; outline-offset: -2px; }
  /* For day summaries */
  .fc .fc-daygrid-day-frame { position: relative; }
  .day-summary { position:absolute; top:6px; right:6px; display:flex; gap:6px; }
  .badge-day { font-size: .65rem; padding: 1px 6px; border-radius: 9999px; line-height: 1rem; border: 1px solid transparent; }
  .badge-day-book { background: #FFF7ED; color: #9A3412; border-color: #FED7AA; }
  .badge-day-reg { background: #F5F3FF; color: #5B21B6; border-color: #DDD6FE; }
  .badge { padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
  .badge-proses { background: #FEF3C7; color: #92400E; }
  .badge-diterima { background: #D1FAE5; color: #065F46; }
  .badge-ditolak { background: #FEE2E2; color: #991B1B; }
  .badge-reguler { background: #EDE9FE; color: #5B21B6; }
  /* Mini label di event agar jelas */
  .tag { display:inline-block; padding:0.05rem .4rem; margin-left:.4rem; border-radius:.4rem; font-size:.65rem; font-weight:700; border:1px solid transparent; white-space:nowrap; }
  .tag-proses { background:#FEF3C7; color:#92400E; border-color:#FDE68A; }
  .tag-diterima { background:#D1FAE5; color:#065F46; border-color:#A7F3D0; }
  .tag-ditolak { background:#FEE2E2; color:#991B1B; border-color:#FECACA; }
  .tag-reguler { background:#EDE9FE; color:#5B21B6; border-color:#DDD6FE; }
  /* Room chips */
  .chip { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .6rem; border-radius:9999px; border:1px solid #e5e7eb; background:#f9fafb; font-size:.8rem; font-weight:600; color:#374151; }
  .chip.active { background:#fff7ed; color:#9a3412; border-color:#fed7aa; }
  /* Week grid */
  .wg-table { width: 100%; border-collapse: collapse; }
  .wg-table th, .wg-table td { border: 1px solid #f3f4f6; padding: .6rem; font-size: .9rem; vertical-align: top; }
  .wg-head { background: #f9fafb; color: #374151; position: sticky; top: 0; z-index: 1; }
  .wg-room { white-space: nowrap; font-weight: 600; color:#111827; }
  .wg-cell { min-height: 56px; }
  .wg-today { background: #FFF7ED; }
  .wg-badge { display:inline-flex; align-items:center; gap:.35rem; padding:.15rem .45rem; border-radius:9999px; font-size:.7rem; font-weight:700; border:1px solid transparent; }
  .wg-reg { background:#F5F3FF; color:#5B21B6; border-color:#DDD6FE; }
  .wg-ok { background:#ECFDF5; color:#065F46; border-color:#A7F3D0; }
  .wg-warn { background:#FEF3C7; color:#92400E; border-color:#FDE68A; }
  .wg-busy { background:#FEE2E2; color:#991B1B; border-color:#FECACA; }
</style>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/id.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Build events arrays from Blade
    const bookingsEvents = [
      <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $room->bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if(in_array($booking->status, ['proses','diterima','ditolak'])): ?>
          {
            id: <?php echo e($booking->id_booking); ?>,
            title: '<?php echo e(addslashes($room->nama_room)); ?>',
            start: '<?php echo e($booking->tanggal_mulai); ?>',
            end: '<?php echo e(\Carbon\Carbon::parse($booking->tanggal_selesai)->addDay()->format('Y-m-d')); ?>',
            backgroundColor: <?php if($booking->status === 'proses'): ?> '#fbbf24' <?php elseif($booking->status === 'diterima'): ?> '#10b981' <?php else: ?> '#ef4444' <?php endif; ?>,
            borderColor: <?php if($booking->status === 'proses'): ?> '#f59e0b' <?php elseif($booking->status === 'diterima'): ?> '#059669' <?php else: ?> '#dc2626' <?php endif; ?>,
            extendedProps: {
              jenis: 'booking',
              status: '<?php echo e($booking->status); ?>',
              roomId: <?php echo e($room->id_room); ?>,
              roomName: '<?php echo e(addslashes($room->nama_room)); ?>',
              description: '<?php echo e(addslashes($booking->keterangan ?? '-')); ?>',
              endDate: '<?php echo e($booking->tanggal_selesai); ?>'
            }
          },
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ];

    const regularEvents = [
      <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $room->jadwalRegulers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          {
            id: 'R<?php echo e($reg->id_reguler); ?>',
            title: '<?php echo e(addslashes($room->nama_room)); ?> (Reguler)',
            start: '<?php echo e($reg->tanggal_mulai); ?>',
            end: '<?php echo e(\Carbon\Carbon::parse($reg->tanggal_selesai)->addDay()->format('Y-m-d')); ?>',
            backgroundColor: '#9333ea',
            borderColor: '#7e22ce',
            extendedProps: {
              jenis: 'jadwal_reguler',
              roomId: <?php echo e($room->id_room); ?>,
              roomName: '<?php echo e(addslashes($room->nama_room)); ?>',
              description: '<?php echo e(addslashes($reg->keterangan ?: 'Jadwal Reguler')); ?>',
              endDate: '<?php echo e($reg->tanggal_selesai); ?>'
            }
          },
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ];

  const roomFilterEl = document.getElementById('roomFilter');
    const toggleBookingsEl = document.getElementById('toggleBookings');
    const toggleRegularEl = document.getElementById('toggleRegular');
  const jumpDateEl = document.getElementById('jumpDate');
  const roomChipsEl = document.getElementById('roomChips');

    function buildFilteredEvents() {
      let list = [];
      if (toggleBookingsEl.checked) list = list.concat(bookingsEvents);
      if (toggleRegularEl.checked) list = list.concat(regularEvents);
      const roomId = roomFilterEl.value;
      if (roomId) list = list.filter(e => String(e.extendedProps.roomId) === String(roomId));
      return list;
    }

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'id',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      buttonText: { today: 'Hari Ini', month: 'Bulan', week: 'Minggu', day: 'Hari', list: 'List' },
      events: buildFilteredEvents(),
      nowIndicator: true,
      expandRows: true,
      eventContent: function(arg) {
        const props = arg.event.extendedProps || {};
        const jenis = props.jenis;
        let dot = '<span style="display:inline-block;width:.6rem;height:.6rem;border-radius:9999px;margin-right:.35rem;background:#6b7280"></span>';
        if (jenis === 'jadwal_reguler') dot = '<span style="display:inline-block;width:.6rem;height:.6rem;border-radius:9999px;margin-right:.35rem;background:#9333ea"></span>';
        else if (props.status === 'proses') dot = '<span style="display:inline-block;width:.6rem;height:.6rem;border-radius:9999px;margin-right:.35rem;background:#f59e0b"></span>';
        else if (props.status === 'diterima') dot = '<span style="display:inline-block;width:.6rem;height:.6rem;border-radius:9999px;margin-right:.35rem;background:#10b981"></span>';
        else if (props.status === 'ditolak') dot = '<span style="display:inline-block;width:.6rem;height:.6rem;border-radius:9999px;margin-right:.35rem;background:#ef4444"></span>';
        const title = arg.event.title;
        let label = '';
        if (jenis === 'jadwal_reguler') label = '<span class="tag tag-reguler">Reguler</span>';
        else if (props.status === 'proses') label = '<span class="tag tag-proses">Proses</span>';
        else if (props.status === 'diterima') label = '<span class="tag tag-diterima">Disetujui</span>';
        else if (props.status === 'ditolak') label = '<span class="tag tag-ditolak">Ditolak</span>';
        return { html: dot + '<span>'+title+'</span>' + label };
      },
      eventClick: function(info) { showEventModal(info.event); },
      eventDidMount: function(info) {
        const props = info.event.extendedProps;
        let tip = props.roomName + '\n' + (props.description || '-') + '\nMulai: ' + info.event.start.toLocaleDateString('id-ID');
        if (props.endDate) tip += ' - ' + new Date(props.endDate).toLocaleDateString('id-ID');
        info.el.setAttribute('title', tip);
      },
      datesSet: function() { updateDaySummaries(); updateRoomChips(); if (isWeekGrid()) buildWeekGrid(); },
      height: 'auto'
    });

    calendar.render();

    // Apply initial filters from query string (?room=ID&date=YYYY-MM-DD)
    const params = new URLSearchParams(window.location.search);
    const qsRoom = params.get('room');
    const qsDate = params.get('date');
    if (qsRoom) {
      roomFilterEl.value = qsRoom;
    }
    if (qsDate) {
      jumpDateEl.value = qsDate;
      calendar.gotoDate(qsDate);
    }
    refreshCalendar();
    updateRoomChipsActive();

    function refreshCalendar() {
      const events = buildFilteredEvents();
      calendar.removeAllEvents();
      events.forEach(e => calendar.addEvent(e));
      updateDaySummaries();
    }

    roomFilterEl.addEventListener('change', function(){
      refreshCalendar();
      updateRoomChipsActive();
      if (isWeekGrid()) buildWeekGrid();
    });
    toggleBookingsEl.addEventListener('change', function(){
      refreshCalendar();
      if (isWeekGrid()) buildWeekGrid();
    });
    toggleRegularEl.addEventListener('change', function(){
      refreshCalendar();
      if (isWeekGrid()) buildWeekGrid();
    });
    jumpDateEl.addEventListener('change', function(){
      if (this.value) {
        calendar.gotoDate(this.value);
        if (isWeekGrid()) buildWeekGrid();
      }
    });

    window.showEventModal = function(event) {
      document.getElementById('modalRoom').textContent = event.extendedProps.roomName;
      document.getElementById('modalStart').textContent = new Date(event.start).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
      document.getElementById('modalEnd').textContent = new Date(event.extendedProps.endDate).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
      document.getElementById('modalDesc').textContent = event.extendedProps.description;
      const jenis = event.extendedProps.jenis;
      let statusBadge = '';
      if (jenis === 'jadwal_reguler') {
        statusBadge = '<span class="badge badge-reguler">Jadwal Reguler</span>';
      } else {
        const status = event.extendedProps.status;
        if (status === 'proses') {
          statusBadge = '<span class="badge badge-proses">Menunggu Persetujuan</span>';
        } else if (status === 'diterima') {
          statusBadge = '<span class="badge badge-diterima">Disetujui</span>';
        } else {
          statusBadge = '<span class="badge badge-ditolak">Ditolak</span>';
        }
      }
      document.getElementById('modalStatus').innerHTML = statusBadge;
      document.getElementById('eventModal').classList.remove('hidden');
      document.getElementById('eventModal').classList.add('flex');
    };

    window.closeModal = function() {
      document.getElementById('eventModal').classList.add('hidden');
      document.getElementById('eventModal').classList.remove('flex');
    };

    document.getElementById('eventModal').addEventListener('click', function(e) {
      if (e.target === this) closeModal();
    });

    // --- Day summary badges per date (Bookings total + Reguler total) ---
    function ymd(date) { return date.toISOString().slice(0,10); }

    function buildDailyCounts(events) {
      const counts = new Map();
      for (const ev of events) {
        const start = new Date(ev.start);
        const end = new Date(ev.end || ev.extendedProps.endDate); // exclusive end
        // iterate from start to end-1 day
        for (let d = new Date(start); d < end; d.setDate(d.getDate()+1)) {
          const key = ymd(d);
          if (!counts.has(key)) counts.set(key, {book:0, reg:0});
          const c = counts.get(key);
          if (ev.extendedProps && ev.extendedProps.jenis === 'jadwal_reguler') c.reg++;
          else c.book++;
        }
      }
      return counts;
    }

    function updateDaySummaries() {
      // clear old badges
      document.querySelectorAll('.day-summary').forEach(el => el.remove());
      const counts = buildDailyCounts(buildFilteredEvents());
      counts.forEach((val, key) => {
        const cell = document.querySelector(`.fc-daygrid-day[data-date="${key}"] .fc-daygrid-day-frame`);
        if (cell && (val.book > 0 || val.reg > 0)) {
          const wrap = document.createElement('div');
          wrap.className = 'day-summary';
          if (val.book > 0) {
            const b = document.createElement('span');
            b.className = 'badge-day badge-day-book';
            b.textContent = `Bk ${val.book}`;
            wrap.appendChild(b);
          }
          if (val.reg > 0) {
            const r = document.createElement('span');
            r.className = 'badge-day badge-day-reg';
            r.textContent = `Rg ${val.reg}`;
            wrap.appendChild(r);
          }
          cell.appendChild(wrap);
        }
      });
    }
    // initial summaries
    updateDaySummaries();

    // --- Room chips with counts in current range ---
    function viewRange() {
      const v = calendar.view;
      return { start: v.currentStart, end: v.currentEnd };
    }
    function overlaps(aStart, aEnd, bStart, bEnd) {
      return aStart < bEnd && aEnd > bStart;
    }
    function updateRoomChips() {
      const { start, end } = viewRange();
      const events = buildFilteredEvents();
      const counts = {};
      events.forEach(ev => {
        const s = new Date(ev.start);
        const e = new Date(ev.end || ev.extendedProps.endDate);
        if (!overlaps(s,e,start,end)) return;
        const id = String(ev.extendedProps.roomId);
        if (!counts[id]) counts[id] = { total:0, diterima:0, proses:0, reg:0 };
        counts[id].total++;
        if (ev.extendedProps.jenis === 'jadwal_reguler') counts[id].reg++;
        else if (ev.extendedProps.status === 'diterima') counts[id].diterima++;
        else if (ev.extendedProps.status === 'proses') counts[id].proses++;
      });

      // Build chips
      roomChipsEl.innerHTML = '';
      <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        (function(){
          const id = '<?php echo e($room->id_room); ?>';
          const c = counts[id] || { total:0, diterima:0, proses:0, reg:0 };
          const chip = document.createElement('button');
          chip.className = 'chip';
          chip.setAttribute('data-id', id);
          chip.innerHTML = `<span><?php echo e(addslashes($room->nama_room)); ?></span><span class="text-xs text-gray-500">(${c.total})</span>`;
          chip.addEventListener('click', function(){
            const current = roomFilterEl.value;
            roomFilterEl.value = current === id ? '' : id;
            refreshCalendar();
            updateRoomChipsActive();
          });
          roomChipsEl.appendChild(chip);
        })();
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      updateRoomChipsActive();
    }
    function updateRoomChipsActive(){
      const sel = String(roomFilterEl.value || '');
      roomChipsEl.querySelectorAll('.chip').forEach(ch => {
        ch.classList.toggle('active', ch.getAttribute('data-id') === sel);
      });
    }
    updateRoomChips();

    // --- Mode switch (Calendar | Week Grid) ---
    const modeCalendarBtn = document.getElementById('modeCalendar');
    const modeWeekGridBtn = document.getElementById('modeWeekGrid');
    const calendarWrap = document.getElementById('calendarWrap');
    const weekGridWrap = document.getElementById('weekGridWrap');

    function isWeekGrid() { return weekGridWrap && !weekGridWrap.classList.contains('hidden'); }
    function setMode(weekGrid) {
      if (weekGrid) {
        calendarWrap.classList.add('hidden');
        weekGridWrap.classList.remove('hidden');
        modeCalendarBtn.className = 'px-3 py-1.5 text-sm font-semibold bg-white text-gray-700 hover:bg-gray-50';
        modeWeekGridBtn.className = 'px-3 py-1.5 text-sm font-semibold bg-orange-600 text-white';
        buildWeekGrid();
      } else {
        weekGridWrap.classList.add('hidden');
        calendarWrap.classList.remove('hidden');
        modeWeekGridBtn.className = 'px-3 py-1.5 text-sm font-semibold bg-white text-gray-700 hover:bg-gray-50';
        modeCalendarBtn.className = 'px-3 py-1.5 text-sm font-semibold bg-orange-600 text-white';
      }
    }
    modeCalendarBtn.addEventListener('click', () => setMode(false));
    modeWeekGridBtn.addEventListener('click', () => setMode(true));

    function startOfWeek(date){
      const d = new Date(date);
      const day = (d.getDay() + 6) % 7; // Mon=0
      d.setDate(d.getDate() - day);
      d.setHours(0,0,0,0);
      return d;
    }
    function endOfWeek(date){
      const s = startOfWeek(date);
      const e = new Date(s);
      e.setDate(e.getDate()+7);
      return e;
    }
    function dayKey(d){ return d.toISOString().slice(0,10); }
    function inDay(ev, day){
      const s = new Date(ev.start);
      const e = new Date(ev.end || ev.extendedProps.endDate);
      const ds = new Date(day); ds.setHours(0,0,0,0);
      const de = new Date(day); de.setDate(de.getDate()+1); de.setHours(0,0,0,0);
      return s < de && e > ds;
    }

    function buildWeekGrid(){
      const container = document.getElementById('weekGrid');
      const rangeStart = startOfWeek(calendar.getDate());
      const rangeEnd = endOfWeek(calendar.getDate());
      const days = [];
      for (let d=new Date(rangeStart); d<rangeEnd; d.setDate(d.getDate()+1)){
        days.push(new Date(d));
      }
      // Build header
      let html = '<div class="overflow-x-auto"><table class="wg-table"><thead><tr class="wg-head">';
      html += '<th class="wg-room">Ruangan</th>';
      days.forEach(dd => {
        const isToday = dayKey(dd) === dayKey(new Date());
        html += `<th class="${isToday?'wg-today':''}">${dd.toLocaleDateString('id-ID', { weekday:'short', day:'2-digit', month:'short' })}</th>`;
      });
      html += '</tr></thead><tbody>';

      const events = buildFilteredEvents();

      <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        (function(){
          const roomId = '<?php echo e($room->id_room); ?>';
          if (roomFilterEl.value && String(roomFilterEl.value) !== roomId) return; // respect filter
          html += '<tr>';
          html += `<td class="wg-room"><?php echo e(addslashes($room->nama_room)); ?></td>`;
          days.forEach(dd => {
            const inDayEvents = events.filter(ev => String(ev.extendedProps.roomId) === roomId && inDay(ev, dd));
            let reg=false, proses=0, diterima=0, ditolak=0;
            inDayEvents.forEach(ev => {
              if (ev.extendedProps.jenis === 'jadwal_reguler') reg = true;
              else if (ev.extendedProps.status === 'proses') proses++;
              else if (ev.extendedProps.status === 'diterima') diterima++;
              else if (ev.extendedProps.status === 'ditolak') ditolak++;
            });
            let content = '<span class="wg-badge wg-ok">Kosong</span>';
            if (reg) {
              content = '<span class="wg-badge wg-reg">Reguler</span>';
            } else if ((proses+diterima+ditolak) > 0) {
              const pieces=[];
              if (proses>0) pieces.push(`P:${proses}`);
              if (diterima>0) pieces.push(`A:${diterima}`);
              if (ditolak>0) pieces.push(`R:${ditolak}`);
              content = `<div class="flex flex-wrap gap-1">${pieces.map(p=>`<span class=\"wg-badge ${proses>0?'wg-warn':'wg-ok'}\">${p}</span>`).join('')}</div>`;
            }
            const todayCls = dayKey(dd) === dayKey(new Date()) ? ' wg-today' : '';
            html += `<td class="wg-cell${todayCls}"><div>${content}</div><div><button class=\"mt-2 text-xs text-orange-600 hover:text-orange-700 underline\" data-goto="${dayKey(dd)}" data-room="${roomId}">Lihat</button></div></td>`;
          });
          html += '</tr>';
        })();
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      html += '</tbody></table></div>';
      container.innerHTML = html;

      // Bind goto buttons (switch to calendar day view with filters)
      container.querySelectorAll('button[data-goto]').forEach(btn => {
        btn.addEventListener('click', function(){
          const dateStr = this.getAttribute('data-goto');
          const rid = this.getAttribute('data-room');
          jumpDateEl.value = dateStr;
          roomFilterEl.value = rid;
          setMode(false); // back to calendar
          calendar.gotoDate(dateStr);
          calendar.changeView('timeGridDay');
          refreshCalendar();
          updateRoomChipsActive();
        });
      });
    }
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views\schedule\index.blade.php ENDPATH**/ ?>