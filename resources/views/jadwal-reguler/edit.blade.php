@extends('layouts.admin')

@section('title', 'Edit Jadwal Reguler')
@section('subtitle', 'Perbarui blok tanggal penuh untuk ruangan')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
  <div class="bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3"><i class="fas fa-calendar-check text-orange-600 text-xl"></i> Edit Jadwal Reguler</h2>
    @if($errors->any())
      <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-4">
        <ul class="list-disc ml-5 text-sm">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form method="POST" action="{{ route('jadwal-reguler.update', $item->id_reguler) }}" class="space-y-6">
      @csrf
      @method('PUT')
      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Jadwal</label>
          <input type="text" name="nama_reguler" value="{{ old('nama_reguler', $item->nama_reguler) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Ruangan</label>
          <select name="id_room" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
            @foreach($rooms as $r)
              <option value="{{ $r->id_room }}" @selected(old('id_room', $item->id_room)==$r->id_room)>{{ $r->nama_room }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $item->tanggal_mulai) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai</label>
          <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $item->tanggal_selesai) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-gray-700 mb-1">Keterangan (opsional)</label>
          <textarea name="keterangan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">{{ old('keterangan', $item->keterangan) }}</textarea>
        </div>
      </div>
      <div class="flex gap-3">
        <a href="{{ route('jadwal-reguler.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
        <button class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg shadow-md transition"><i class="fas fa-save mr-2"></i> Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection
