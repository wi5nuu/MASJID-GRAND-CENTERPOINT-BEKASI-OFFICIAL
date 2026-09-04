@extends('layouts.admin')

@section('title', isset($galeri) ? 'Edit Foto' : 'Tambah Foto')
@section('breadcrumb')
    <a href="{{ route('admin.galeri.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Galeri</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($galeri) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">{{ isset($galeri) ? 'Edit Foto' : 'Tambah Foto Baru' }}</h1>
        <a href="{{ route('admin.galeri.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($galeri) ? route('admin.galeri.update', $galeri) : route('admin.galeri.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($galeri)) @method('PUT') @endif

        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Judul Foto <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $galeri->judul ?? '') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Judul foto...">
                @error('judul')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Album</label>
                <input type="text" name="album" value="{{ old('album', $galeri->album ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Nama album (opsional)">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                    placeholder="Keterangan foto...">{{ old('keterangan', $galeri->keterangan ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">File Foto {{ isset($galeri) ? '' : '*' }}</label>
                @if(isset($galeri) && $galeri->file)
                <div class="mb-3">
                    <img src="{{ Storage::url($galeri->file) }}" class="w-32 h-32 object-cover rounded-xl">
                    <p class="text-xs text-neutral-400 mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                </div>
                @endif
                <input type="file" name="file" accept="image/*" {{ isset($galeri) ? '' : 'required' }}
                    class="w-full text-sm text-neutral-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700 file:font-medium hover:file:bg-primary-100">
                @error('file')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', $galeri->urutan ?? 0) }}" min="0"
                    class="w-32 px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $galeri->is_active ?? true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                <label for="is_active" class="text-sm text-neutral-700">Tampilkan ke publik</label>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                {{ isset($galeri) ? 'Simpan Perubahan' : 'Upload Foto' }}
            </button>
            <a href="{{ route('admin.galeri.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700 px-4 py-2.5 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
