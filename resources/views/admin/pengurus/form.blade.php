@extends('layouts.admin')

@section('title', isset($pengurus) ? 'Edit Pengurus' : 'Tambah Pengurus')
@section('breadcrumb')
    <a href="{{ route('admin.pengurus.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Pengurus</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($pengurus) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">{{ isset($pengurus) ? 'Edit Pengurus' : 'Tambah Pengurus' }}</h1>
        <a href="{{ route('admin.pengurus.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($pengurus) ? route('admin.pengurus.update', $pengurus) : route('admin.pengurus.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($pengurus)) @method('PUT') @endif

        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $pengurus->nama ?? '') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $pengurus->jabatan ?? '') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Contoh: Ketua DKM">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Bidang</label>
                    <input type="text" name="bidang" value="{{ old('bidang', $pengurus->bidang ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        placeholder="Bidang tugas">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Periode</label>
                    <input type="text" name="periode" value="{{ old('periode', $pengurus->periode ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        placeholder="2024-2027">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">No. Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $pengurus->telepon ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Urutan Tampil</label>
                <input type="number" name="urutan" value="{{ old('urutan', $pengurus->urutan ?? 0) }}" min="0"
                    class="w-32 px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Foto</label>
                @if(isset($pengurus) && isset($pengurus->foto) && $pengurus->foto)
                <img src="{{ Storage::url($pengurus->foto) }}" class="w-20 h-20 rounded-full object-cover mb-2">
                @endif
                <input type="file" name="foto" accept="image/*"
                    class="w-full text-sm text-neutral-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700 file:font-medium hover:file:bg-primary-100">
            </div>
            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $pengurus->is_active ?? true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                <label for="is_active" class="text-sm text-neutral-700">Aktif / Tampilkan ke publik</label>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                {{ isset($pengurus) ? 'Simpan Perubahan' : 'Tambah Pengurus' }}
            </button>
            <a href="{{ route('admin.pengurus.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700 px-4 py-2.5 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
