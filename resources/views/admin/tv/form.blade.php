@extends('layouts.admin')

@section('title', isset($tv) ? 'Edit TV Display' : 'Tambah TV Display')
@section('breadcrumb')
    <a href="{{ route('admin.tv.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">TV Display</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($tv) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">{{ isset($tv) ? 'Edit Konten TV' : 'Tambah Konten TV' }}</h1>
        <a href="{{ route('admin.tv.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($tv) ? route('admin.tv.update', $tv) : route('admin.tv.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($tv)) @method('PUT') @endif

        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Tipe Konten <span class="text-red-500">*</span></label>
                <select name="tipe" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">Pilih Tipe</option>
                    <option value="running_text" {{ old('tipe', $tv->tipe ?? '') === 'running_text' ? 'selected' : '' }}>Running Text (Teks Berjalan)</option>
                    <option value="popup" {{ old('tipe', $tv->tipe ?? '') === 'popup' ? 'selected' : '' }}>Popup Pengumuman</option>
                    <option value="pengumuman" {{ old('tipe', $tv->tipe ?? '') === 'pengumuman' ? 'selected' : '' }}>Pengumuman Layar TV</option>
                </select>
                @error('tipe')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $tv->judul ?? '') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Judul konten...">
                @error('judul')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Konten / Teks <span class="text-red-500">*</span></label>
                <textarea name="konten" rows="4" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                    placeholder="Isi teks konten...">{{ old('konten', $tv->konten ?? '') }}</textarea>
                @error('konten')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Gambar / Poster (untuk Popup)</label>
                @if(isset($tv) && $tv->file)
                <div class="mb-2">
                    <img src="{{ Storage::url($tv->file) }}" class="w-48 rounded-xl border border-neutral-200">
                    <p class="text-xs text-neutral-400 mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
                </div>
                @endif
                <input type="file" name="file" accept="image/*"
                    class="w-full text-sm text-neutral-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700 file:font-medium hover:file:bg-primary-100">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Durasi (detik)</label>
                    <input type="number" name="durasi" value="{{ old('durasi', $tv->durasi ?? 10) }}" min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Urutan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $tv->urutan ?? 0) }}" min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $tv->is_active ?? true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                <label for="is_active" class="text-sm text-neutral-700">Aktif / Tampilkan</label>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                {{ isset($tv) ? 'Simpan Perubahan' : 'Tambah Konten' }}
            </button>
            <a href="{{ route('admin.tv.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700 px-4 py-2.5 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
