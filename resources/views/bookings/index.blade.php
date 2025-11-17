@extends('layouts.admin')

@section('title', 'Peminjaman')
@section('subtitle', 'Daftar peminjaman terbaru')

@section('content')
  <!-- Page Header -->
  <div class="bg-gray-700 rounded-2xl p-4 md:p-8 shadow-lg mb-6">
    <div class="flex items-center gap-3 md:gap-4">
      <div class="p-3 md:p-4 bg-white/20 text-white rounded-xl">
        <i class="fas fa-clipboard-list text-xl md:text-2xl"></i>
      </div>
      <div>
        <h1 class="text-2xl md:text-3xl font-bold text-white">Peminjaman</h1>
        <p class="text-gray-300 text-sm md:text-lg">Daftar peminjaman terbaru</p>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl shadow-sm mb-4 text-base font-medium">
      <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-6 py-4 rounded-xl shadow-sm mb-4 text-base font-medium">
      <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
  @endif

  <div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="px-4 md:px-8 py-4 md:py-5 border-b bg-gray-50">
      <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <h3 class="text-lg md:text-xl font-bold text-gray-900"><i class="fas fa-list mr-2 text-gray-600"></i>Daftar Peminjaman</h3>
        <form method="GET" class="flex flex-wrap gap-2 md:gap-3">
          @php $statusOpt = request('status'); $roomOpt = request('room'); @endphp
          <div class="flex-1 min-w-[120px]">
            <label class="block text-xs font-semibold text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
              <option value="">Semua</option>
              <option value="proses" @selected($statusOpt==='proses')>Proses</option>
              <option value="diterima" @selected($statusOpt==='diterima')>Disetujui</option>
              <option value="ditolak" @selected($statusOpt==='ditolak')>Ditolak</option>
              <option value="selesai" @selected($statusOpt==='selesai')>Selesai</option>
            </select>
          </div>
          <div class="flex-1 min-w-[120px]">
            <label class="block text-xs font-semibold text-gray-700 mb-1">Ruangan</label>
            <select name="room" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
              <option value="">Semua</option>
              @foreach($rooms ?? [] as $r)
                <option value="{{ $r->id_room }}" @selected((string)$roomOpt===(string)$r->id_room)>{{ $r->nama_room }}</option>
              @endforeach
            </select>
          </div>
          <div class="flex gap-2 items-end">
            <button class="px-3 md:px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold whitespace-nowrap"><i class="fas fa-filter mr-1"></i>Terapkan</button>
            @if(request()->has('status') || request()->has('room'))
              <a href="{{ route('bookings.index') }}" class="px-3 md:px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm whitespace-nowrap">Reset</a>
            @endif
          </div>
        </form>
      </div>
    </div>
    <div class="overflow-x-auto table-responsive">
      <table class="min-w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">#</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Pemohon</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Ruangan</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Status</th>
            <th class="px-6 py-4 text-left font-bold text-sm text-gray-700 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @php 
            $items = collect($bookings ?? []);
            $statusQ = request('status');
            $roomQ = request('room');
            if($statusQ!==null && $statusQ!=='') { $items = $items->where('status', $statusQ)->values(); }
            if($roomQ!==null && $roomQ!=='') { $items = $items->where('id_room', (int)$roomQ)->values(); }
          @endphp
          @forelse($items as $i => $b)
            @php 
              $status = data_get($b, 'status', 'menunggu');
              $username = data_get($b, 'user.username', '-');
              $roomName = data_get($b, 'room.nama_room') ?? data_get($b, 'room.name', '-');
              $mulai = data_get($b, 'tanggal_mulai');
              $selesai = data_get($b, 'tanggal_selesai');
              $mulaiStr = $mulai ? \Carbon\Carbon::parse($mulai)->translatedFormat('d M Y') : '-';
              $selesaiStr = $selesai ? \Carbon\Carbon::parse($selesai)->translatedFormat('d M Y') : '-';
              $idBooking = data_get($b, 'id_booking');

              // Peta status ke Bahasa Indonesia
              $statusKey = is_string($status) ? strtolower(trim($status)) : 'menunggu';
              $statusMap = [
                'pending' => 'Menunggu',
                'menunggu' => 'Menunggu',
                'proses' => 'Proses',
                'process' => 'Proses',
                'approved' => 'Disetujui',
                'approve' => 'Disetujui',
                'accepted' => 'Disetujui',
                'diterima' => 'Disetujui',
                'rejected' => 'Ditolak',
                'reject' => 'Ditolak',
                'ditolak' => 'Ditolak',
                'cancelled' => 'Dibatalkan',
                'canceled' => 'Dibatalkan',
                'dibatalkan' => 'Dibatalkan',
              ];
              $statusLabel = $statusMap[$statusKey] ?? ucfirst($statusKey);
              $badgeMap = [
                'proses' => 'bg-amber-100 text-amber-800',
                'diterima' => 'bg-emerald-100 text-emerald-800',
                'ditolak' => 'bg-rose-100 text-rose-800',
                'selesai' => 'bg-slate-100 text-slate-800',
              ];
              $badgeClass = $badgeMap[$statusKey] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4 text-base font-semibold text-gray-900">{{ $i+1 }}</td>
              <td class="px-6 py-4 text-base font-medium text-gray-900">{{ $username }}</td>
              <td class="px-6 py-4 text-base font-medium text-gray-900">{{ $roomName }}</td>
              <td class="px-6 py-4 text-base text-gray-900">
                {{ $mulaiStr }} - {{ $selesaiStr }}
              </td>
              <td class="px-6 py-4">
                <span class="px-3 py-1.5 text-sm font-semibold rounded-full {{ $badgeClass }}">{{ $statusLabel }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @php $role = Auth::user()->role ?? 1; @endphp
                @if(in_array($role, [1,2]) && ($status === 'menunggu' || $status === 'proses'))
                  <form method="POST" action="{{ route('bookings.approve', $idBooking) }}" class="inline">
                    @csrf
                    @method('PUT')
                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm hover:shadow transition-all" onclick="return confirm('Setujui peminjaman ini?')">
                      <i class="fas fa-check mr-1"></i>Setujui
                    </button>
                  </form>
                  <form method="POST" action="{{ route('bookings.reject', $idBooking) }}" class="inline ml-2" onsubmit="if(!this.alasan_tolak.value){var x=prompt('Alasan penolakan:'); if(x===null) return false; this.alasan_tolak.value=x;} return confirm('Tolak peminjaman ini?');">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="alasan_tolak">
                    <button class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-semibold shadow-sm hover:shadow transition-all">
                      <i class="fas fa-times mr-1"></i>Tolak
                    </button>
                  </form>
                @else
                  <span class="text-gray-400 text-sm">-</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-base">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-2 block"></i>
                Belum ada data peminjaman.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
