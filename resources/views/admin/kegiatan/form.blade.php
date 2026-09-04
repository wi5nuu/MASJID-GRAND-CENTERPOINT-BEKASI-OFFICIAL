@extends('layouts.admin')

@section('title', isset($kegiatan) ? 'Edit Kegiatan' : 'Tambah Kegiatan')
@section('breadcrumb')
    <a href="{{ route('admin.kegiatan.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Kegiatan</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($kegiatan) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')

<div class="max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">{{ isset($kegiatan) ? 'Edit Kegiatan' : 'Tambah Kegiatan Baru' }}</h1>
        <a href="{{ route('admin.kegiatan.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($kegiatan) ? route('admin.kegiatan.update', $kegiatan) : route('admin.kegiatan.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($kegiatan)) @method('PUT') @endif

        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
                <h3 class="font-semibold text-neutral-800 text-sm">Informasi Kegiatan</h3>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $kegiatan->judul ?? '') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('judul')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', isset($kegiatan) ? $kegiatan->tanggal?->format('Y-m-d') : '') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Kategori</label>
                        <select name="kategori_id" class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris ?? [] as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $kegiatan->kategori_id ?? '') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $kegiatan->waktu_mulai ?? '') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $kegiatan->waktu_selesai ?? '') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        placeholder="Contoh: Lantai 1 Masjid Grand Centerpoint">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Narasumber / Pengisi</label>
                    <input type="text" name="narasumber" value="{{ old('narasumber', $kegiatan->narasumber ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        placeholder="Nama ustadz / narasumber">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                        placeholder="Deskripsi kegiatan...">{{ old('deskripsi', $kegiatan->deskripsi ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*"
                        class="w-full text-sm text-neutral-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700 file:font-medium hover:file:bg-primary-100">
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active', $kegiatan->is_active ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                    <label for="is_active" class="text-sm text-neutral-700">Aktif / Tampilkan ke publik</label>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    {{ isset($kegiatan) ? 'Simpan Perubahan' : 'Tambah Kegiatan' }}
                </button>
                <a href="{{ route('admin.kegiatan.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700 transition-colors px-4 py-2.5">Batal</a>
            </div>

        </div>
    </form>
</div>

@endsection
