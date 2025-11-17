<?php $__env->startSection('title', 'Pilih Jadwal Booking'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto space-y-6" x-data="slotPicker()" x-init="init(<?php echo e($room->id_room); ?>)">
  <div class="text-center space-y-4">
    <div class="w-16 h-16 rounded-full mx-auto flex items-center justify-center text-white text-2xl shadow-lg" style="background:linear-gradient(135deg,#c2410c,#ea580c)"><i class="fas fa-calendar-check"></i></div>
    <div class="space-y-1">
      <h1 class="text-4xl font-extrabold tracking-tight text-brown-700">Pilih Jadwal Booking</h1>
      <p class="text-sm text-gray-600 font-medium"><?php echo e($room->nama_room); ?> • Operasional <span class="font-semibold">06:00 - 24:00</span></p>
      <p class="text-xs text-gray-500">Weekend: Jumat, Sabtu, Minggu | Weekday: Senin - Kamis</p>
    </div>
    <!-- Pricing chips removed per request -->
  </div>

  <!-- Carousel Tanggal -->
  <div class="bg-white rounded-xl shadow p-5 space-y-4">
    <h2 class="font-semibold text-brown-700 flex items-center gap-2 text-lg"><i class="fas fa-calendar-alt text-orange-600"></i> Pilih Tanggal <span class="text-[10px] text-gray-400 font-normal">(Geser untuk melihat tanggal lainnya)</span></h2>
    <div class="flex items-center justify-between">
      <button type="button" class="px-3 py-2 text-sm rounded-full bg-gray-100 hover:bg-gray-200 shadow-sm" @click="prevDates()" :disabled="page===0"><i class="fas fa-chevron-left"></i></button>
      <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2" style="scrollbar-width:none">
        <template x-for="d in visibleDates" :key="d.date">
          <button type="button" @click="setDate(d.date)" :class="date===d.date ? 'ring-2 ring-orange-400 bg-orange-50 text-gray-900 shadow-md' : 'bg-white hover:bg-gray-50 text-gray-700'" class="w-20 flex-shrink-0 px-2 py-2 rounded-2xl border border-gray-200 text-center text-[11px] font-medium transition relative shadow-sm">
            <div class="flex flex-col leading-tight">
              <span class="text-[10px] uppercase tracking-wide text-gray-500" x-text="d.dow"></span>
              <span class="text-2xl font-bold" x-text="d.day"></span>
              <span class="text-[10px] text-gray-500" x-text="d.mon"></span>
            </div>
            <div x-show="d.is_today" class="mt-1 text-[9px] font-semibold text-orange-600">Hari ini</div>
          </button>
        </template>
      </div>
      <button type="button" class="px-3 py-2 text-sm rounded-full bg-gray-100 hover:bg-gray-200 shadow-sm" @click="nextDates()" :disabled="(page+1)*7 >= allDates.length"><i class="fas fa-chevron-right"></i></button>
    </div>
    <div class="flex items-center gap-3 text-[11px] text-gray-500 select-none">
      <div class="flex-1 h-0.5 bg-orange-300 rounded"></div>
      <div class="px-2">Geser untuk melihat tanggal lainnya</div>
      <div class="flex-1 h-0.5 bg-orange-300 rounded"></div>
    </div>
  </div>

  <!-- Grid Slot Jam -->
  <div class="bg-white rounded-xl shadow p-5 space-y-4">
  <div class="flex items-center justify-between">
    <h2 class="font-semibold text-brown-700 flex items-center gap-2 text-lg"><i class="fas fa-clock text-orange-600"></i> Pilih Waktu</h2>
    <div class="text-xs text-gray-500" x-show="selStart!=null && selEnd!=null">
      <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg border border-orange-200 bg-orange-50 text-orange-700 font-semibold">
        <i class="fas fa-hourglass-half"></i>
        <span x-text="(selEnd-selStart)+' jam'"></span>
      </span>
    </div>
  </div>
  <div class="text-[11px] text-gray-500">Klik beberapa kotak jam untuk memilih durasi lebih lama.</div>
    <template x-if="errorMsg">
      <div class="text-sm px-3 py-2 rounded-lg bg-red-50 border border-red-200 text-red-700 flex items-start gap-2">
        <i class="fas fa-exclamation-triangle mt-0.5"></i>
        <div>
          <div class="font-semibold">Gagal memuat ketersediaan</div>
          <div x-text="errorMsg"></div>
          <div class="text-[11px] text-red-600 mt-1">Menampilkan jam dasar sebagai cadangan. Anda masih bisa memilih jam tersedia.</div>
        </div>
      </div>
    </template>
    <!-- Durasi dropdown dihapus. User memilih rentang jam langsung di grid. -->
  <div x-show="loading" class="text-sm text-gray-500">Memuat ketersediaan...</div>
    <template x-if="blocked && !loading">
      <div class="text-sm text-red-600 space-y-2">
        <div>Tanggal diblok (Hari Nonaktif).</div>
        <button type="button" @click="autoNextAvailable()" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gradient-to-r from-orange-600 to-amber-500 text-white text-xs font-semibold shadow hover:brightness-110">
          <i class="fas fa-forward"></i> Lompat ke tanggal tersedia berikutnya
        </button>
      </div>
    </template>
    <div x-show="!blocked && !loading && hourSlots.length===0" class="text-sm text-amber-700 flex items-center gap-3">
      <span>Tidak ada slot dikembalikan. Mungkin:</span>
      <ul class="list-disc pl-5 text-[11px] space-y-0 text-gray-600">
        <li>Semua jam terisi (full booking)</li>
        <li>Kegagalan load (coba ulang)</li>
      </ul>
      <button type="button" @click="forceGenerate()" class="px-2 py-1 rounded bg-orange-600 text-white text-xs font-semibold">Tampilkan Jam Dasar</button>
      <button type="button" @click="fetch()" class="px-2 py-1 rounded bg-amber-500 text-white text-xs font-semibold">Reload</button>
    </div>
    <div x-show="!blocked && !loading && hourSlots.length>0" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
      <template x-for="slot in hourSlots" :key="slot.h">
        <button type="button" @click="toggleSelect(slot.h)" :disabled="slot.state!=='free'" :class="btnClass(slot)" class="p-2 rounded-xl text-[11px] flex flex-col gap-1.5 text-left relative group overflow-hidden transition-shadow h-20 justify-between">
          <div class="absolute inset-0 opacity-0 group-hover:opacity-10 bg-gradient-to-br from-orange-400 to-amber-500 transition"></div>
          <div class="flex justify-between items-center mb-0.5 text-gray-700" style="font-variant-numeric: tabular-nums;">
            <span class="font-semibold tracking-tight pr-1" x-text="slot.label"></span>
          </div>
          <div class="flex items-center gap-2 text-[10px] text-gray-500">
            <span class="inline-block w-1.5 h-1.5 rounded-full" :class="slot.state==='free' ? 'bg-emerald-500' : slot.state==='busy' ? 'bg-red-500' : slot.state==='blocked' ? 'bg-gray-500' : 'bg-gray-400'"></span>
            <span x-text="slot.state==='free' ? 'Tersedia' : slot.state==='busy' ? 'Tidak tersedia' : slot.state==='blocked' ? 'Diblok' : 'Tidak cukup'"></span>
          </div>
        </button>
      </template>
    </div>
  </div>

  <!-- Ringkasan (step 1) -->
  <form method="GET" action="<?php echo e(route('user.slot-booking.form')); ?>" class="bg-white rounded-xl shadow p-5 space-y-5">
    <h2 class="font-semibold text-brown-700 flex items-center gap-2"><i class="fas fa-file-alt text-orange-600"></i> Ringkasan Booking</h2>
    <input type="hidden" name="id_room" value="<?php echo e($room->id_room); ?>">
    <input type="hidden" name="tanggal" :value="date">
    <input type="hidden" name="jam_mulai" :value="start">
    <input type="hidden" name="jam_selesai" :value="end">
    <div class="text-sm grid grid-cols-2 gap-3">
      <div>Ruangan:</div><div class="font-semibold"><?php echo e($room->nama_room); ?></div>
      <div>Tanggal:</div><div class="font-semibold" x-text="date ? formatDate(date) : '-'"></div>
      <div>Waktu:</div><div class="font-semibold" x-text="start && end ? start+' - '+end : '-'"></div>
    <div>Durasi:</div><div class="font-semibold" x-text="start && end ? (parseInt(end)-parseInt(start)) + ' jam' : '-' "></div>
    </div>
    <div class="flex justify-between gap-2">
      <a href="<?php echo e(route('user.slot-booking.index')); ?>" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-300 transition">&larr; Kembali</a>
      <button type="submit" class="px-5 py-2 rounded-lg text-white text-sm font-semibold shadow" :disabled="!canSubmit()" :class="canSubmit() ? 'bg-gradient-to-r from-orange-600 to-amber-500 hover:brightness-110' : 'bg-gray-300 cursor-not-allowed'">Lanjutkan ke Form Booking</button>
    </div>
  </form>
</div>

<script>
function slotPicker(){
  return {
    roomId: null,
    allDates: <?php echo json_encode($days, 15, 512) ?>, visibleDates: [], page:0, date:null,
    hourSlots:[], loading:false, blocked:false, errorMsg:null,
    start:null, end:null, // string 'HH:MM'
    selStart:null, selEnd:null, // numeric hours
  init(id){
    this.roomId=id;
    this.allDates = this.allDates.map(d=>d); this.updateVisible();
    // Set date dulu baru fetch manual (hindari race id_room undefined)
    this.date = this.allDates[0]?.date; this.clearSelection();
    // Jalankan fetch setelah nextTick sederhana
    setTimeout(()=>{ this.fetch(); }, 0);
  },
    updateVisible(){ this.visibleDates = this.allDates.slice(this.page*7, this.page*7+7); },
    prevDates(){ if(this.page>0){ this.page--; this.updateVisible(); } },
    nextDates(){ if((this.page+1)*7 < this.allDates.length){ this.page++; this.updateVisible(); } },
  setDate(d){ this.date=d; this.clearSelection(); this.fetch(); },
    fetch(){
      if(!this.roomId || !this.date){ return; }
      this.loading=true; this.errorMsg=null;
      fetch(`<?php echo e(route('user.slot-booking.available')); ?>?id_room=${this.roomId}&tanggal=${this.date}`,
        {credentials:'same-origin', headers:{'Accept':'application/json'}})
      .then(async r=>{
        if(!r.ok){
          let extra='';
          try { const body = await r.json(); if(body && body.errors){
              extra = ' - '+Object.values(body.errors).flat().join('; ');
            } else if(body && body.error){ extra = ' - '+body.error; }
          } catch(_){}
          throw new Error('HTTP '+r.status+extra);
        }
        return r.json();
      })
      .then(j=>{
        this.blocked=j.blocked;
        if(j.blocked){
          // Build a visible disabled slot grid so user can still see times
          this.hourSlots=[];
          for(let h=6; h<24; h++){
            const label = (""+h).padStart(2,'0')+':00 - '+ (""+(h+1)).padStart(2,'0')+':00';
            const priceBadgeClass = h>=6&&h<12 ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : h>=12&&h<18 ? 'text-orange-700 bg-orange-50 border-orange-200' : 'text-indigo-700 bg-indigo-50 border-indigo-200';
            // Always free
            this.hourSlots.push({h, state:'blocked', price:0, label, priceBadgeClass});
          }
        } else {
          this.buildSlots(j);
        }
      }).catch((e)=>{
        // Jika pesan mengandung validasi (422) tampilkan lebih informatif
        this.errorMsg = 'Gagal memuat slot: '+e.message;
        this.forceGenerate();
      })
      .finally(()=>{ this.loading=false; }); },
    buildSlots(data){
      const occ = []; data.occupied.forEach(o=>{ occ.push({s:parseInt(o.start), e:parseInt(o.end)}); });
      const isBusyHour = (h)=> occ.some(o=> h >= o.s && h < o.e );
      this.hourSlots=[];
      for(let h=6; h<24; h++){
        const busy = isBusyHour(h);
        const state = busy ? 'busy' : 'free';
        const label = (""+h).padStart(2,'0')+':00 - '+ (""+(h+1)).padStart(2,'0')+':00';
        const priceBadgeClass = h>=6&&h<12 ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : h>=12&&h<18 ? 'text-orange-700 bg-orange-50 border-orange-200' : 'text-indigo-700 bg-indigo-50 border-indigo-200';
        // Always free
  this.hourSlots.push({h, state, price:0, label, priceBadgeClass});
      }
      if(this.hourSlots.length===0){ this.forceGenerate(); }
    },
    toggleSelect(h){
      // Only free hours can be part of selection
      const slot = this.hourSlots.find(s=>s.h===h);
      if(!slot || slot.state!=='free') return;
      // Jika sudah memilih satu jam yang sama, klik lagi untuk batal
      if(this.selStart!=null && this.selEnd!=null){
        const isSingle = (this.selEnd - this.selStart) === 1;
        const isSame = h === this.selStart;
        if(isSingle && isSame){ this.clearSelection(); return; }
      }
      if(this.selStart===null || this.selStart===undefined){
        this.selStart = h; this.selEnd = h+1; this.syncRangeStrings(); return;
      }
      // Expand or reset
      if(h < this.selStart){
        if(this.rangeFree(h, this.selEnd)) this.selStart = h;
        else { this.selStart = h; this.selEnd = h+1; }
      } else if(h >= this.selEnd){
        if(this.rangeFree(this.selStart, h+1)) this.selEnd = h+1;
        else { this.selStart = h; this.selEnd = h+1; }
      } else {
        // click inside range -> collapse to this hour
        this.selStart = h; this.selEnd = h+1;
      }
      this.syncRangeStrings();
    },
    rangeFree(a,b){
      for(let x=a; x<b; x++){
        const sl = this.hourSlots.find(s=>s.h===x);
        if(!sl || sl.state!=='free') return false;
      }
      return true;
    },
    clearSelection(){ this.selStart=null; this.selEnd=null; this.start=null; this.end=null; },
    syncRangeStrings(){
      if(this.selStart==null || this.selEnd==null){ this.start=null; this.end=null; return; }
      this.start = (""+this.selStart).padStart(2,'0')+':00';
      this.end   = (""+this.selEnd).padStart(2,'0')+':00';
    },
    autoNextAvailable(){
      const idx = this.allDates.findIndex(d=>d.date===this.date);
      for(let i=idx+1; i<this.allDates.length; i++){
        const next = this.allDates[i].date; this.date = next; this.loading=true;
        return fetch(`<?php echo e(route('user.slot-booking.available')); ?>?id_room=${this.roomId}&tanggal=${next}`)
          .then(r=>r.json()).then(j=>{ this.loading=false; this.blocked=j.blocked; if(j.blocked){ return this.autoNextAvailable(); } this.buildSlots(j); })
          .catch(()=>{ this.loading=false; });
      }
    },
    formatDate(d){ const dt=new Date(d+'T00:00:00'); return dt.toLocaleDateString('id-ID',{weekday:'long', day:'numeric', month:'long', year:'numeric'}); },
  // totalStr removed per request
  isWeekend(){ if(!this.date) return false; const d=new Date(this.date+'T00:00:00'); const dow=d.getDay(); return dow===5 || dow===6 || dow===0; },
  rateOfHour(h){ return 0; },
    canSubmit(){ return !!(this.date && this.start && this.end); },
    validateSubmit(){ if(!this.canSubmit()) return false; return true; },
    progressStyle(){
      const totalPages = Math.ceil(this.allDates.length / 7);
      const percent = ((this.page+1)/totalPages)*100;
      return 'width:'+percent+'%';
    },
    btnClass(slot){
      const active = this.selStart!=null && this.selEnd!=null && slot.h>=this.selStart && slot.h<this.selEnd;
      if(slot.state==='busy') return 'bg-red-50 text-red-600 border border-red-200 cursor-not-allowed';
      if(slot.state==='blocked') return 'bg-gray-50 text-gray-500 border border-gray-200 cursor-not-allowed';
      if(slot.state!=='free') return 'bg-gray-50 text-gray-400 border border-gray-200 cursor-not-allowed';
      return active
        ? 'bg-gradient-to-r from-orange-600 to-amber-500 text-white border border-orange-600 shadow'
        : 'bg-white border border-gray-200 text-gray-800 hover:shadow-md hover:border-orange-300 cursor-pointer';
    }
    ,forceGenerate(){
      if(this.hourSlots.length>0) return;
      for(let h=6; h<24; h++){
        const label = (""+h).padStart(2,'0')+':00 - '+ (""+(h+1)).padStart(2,'0')+':00';
        const priceBadgeClass = h>=6&&h<12 ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : h>=12&&h<18 ? 'text-orange-700 bg-orange-50 border-orange-200' : 'text-indigo-700 bg-indigo-50 border-indigo-200';
  this.hourSlots.push({h, state:'free', price:0, label, priceBadgeClass});
      }
    }
  }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\M S I\P3-UKK\resources\views/user/slot-booking/show.blade.php ENDPATH**/ ?>