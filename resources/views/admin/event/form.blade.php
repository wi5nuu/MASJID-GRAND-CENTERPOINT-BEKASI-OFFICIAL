@extends('layouts.admin')

@section('title', isset($event) ? 'Edit Event' : 'Tambah Event')
@section('breadcrumb')
    <a href="{{ route('admin.event.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Event</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($event) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">{{ isset($event) ? 'Edit Event' : 'Tambah Event Baru' }}</h1>
            <p class="text-sm text-neutral-500 mt-0.5">{{ isset($event) ? 'Perbarui informasi event' : 'Buat event, seminar, atau acara khusus baru' }}</p>
        </div>
        <a href="{{ route('admin.event.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l-7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($event) ? route('admin.event.update', $event) : route('admin.event.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($event)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Kolom kiri --}}
            <div class="lg:col-span-2 space-y-5">

                <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Judul Event <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $event->judul ?? '') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                            placeholder="Contoh: Bazaar Ramadhan 1447H">
                        @error('judul')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all resize-none"
                            placeholder="Deskripsi singkat event...">{{ old('deskripsi', $event->deskripsi ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Konten Lengkap</label>
                        <textarea name="konten" rows="6"
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all resize-none"
                            placeholder="Detail lengkap event, rundown acara, informasi pendaftaran, dll...">{{ old('konten', $event->konten ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Waktu & Lokasi --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h3 class="font-semibold text-neutral-900 text-sm mb-4">Waktu & Lokasi</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_mulai" required
                                value="{{ old('tanggal_mulai', isset($event) ? \Carbon\Carbon::parse($event->tanggal_mulai)->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('tanggal_mulai')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai"
                                value="{{ old('tanggal_selesai', isset($event) && $event->tanggal_selesai ? \Carbon\Carbon::parse($event->tanggal_selesai)->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai"
                                value="{{ old('waktu_mulai', $event->waktu_mulai ?? '') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Kuota Peserta</label>
                            <input type="number" name="kuota" min="0"
                                value="{{ old('kuota', $event->kuota ?? '') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="0 = tidak terbatas">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Lokasi</label>
                            <input type="text" name="lokasi"
                                value="{{ old('lokasi', $event->lokasi ?? '') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="Contoh: Aula Masjid Grand Centerpoint Lt. 2">
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar kanan --}}
            <div class="space-y-5">
                {{-- Publish --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5 sticky top-5">
                    <h3 class="font-semibold text-neutral-900 text-sm mb-4">Pengaturan</h3>
                    <div class="space-y-3 mb-5">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $event->is_active ?? true) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                            <div>
                                <span class="text-sm text-neutral-700 font-medium">Event aktif</span>
                                <p class="text-xs text-neutral-400">Tampil di halaman publik</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured', $event->is_featured ?? false) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                            <div>
                                <span class="text-sm text-neutral-700 font-medium">Event unggulan</span>
                                <p class="text-xs text-neutral-400">Tampil di hero section</p>
                            </div>
                        </label>
                    </div>
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                            {{ isset($event) ? 'Simpan Perubahan' : 'Tambah Event' }}
                        </button>
                        <a href="{{ route('admin.event.index') }}" class="w-full text-center py-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">Batal</a>
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h3 class="font-semibold text-neutral-900 text-sm mb-3">Thumbnail</h3>
                    @if(isset($event) && $event->thumbnail)
                    <div class="mb-3 rounded-xl overflow-hidden">
                        <img src="{{ Storage::url($event->thumbnail) }}" class="w-full h-32 object-cover" alt="">
                    </div>
                    @endif
                    <label class="block cursor-pointer">
                        <div class="border-2 border-dashed border-neutral-300 rounded-xl p-4 text-center hover:border-primary-400 hover:bg-primary-50 transition-colors">
                            <svg class="w-7 h-7 text-neutral-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-xs text-neutral-500">Klik untuk unggah</p>
                            <p class="text-xs text-neutral-400 mt-0.5">JPG, PNG · maks. 2MB</p>
                        </div>
                        <input type="file" name="thumbnail" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
