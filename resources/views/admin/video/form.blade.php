@extends('layouts.admin')

@section('title', isset($video) ? 'Edit Video' : 'Tambah Video')
@section('breadcrumb')
    <a href="{{ route('admin.video.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Video</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($video) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">{{ isset($video) ? 'Edit Video' : 'Tambah Video Baru' }}</h1>
            <p class="text-sm text-neutral-500 mt-0.5">{{ isset($video) ? 'Perbarui informasi video' : 'Tambahkan video ceramah, kajian, atau dokumentasi' }}</p>
        </div>
        <a href="{{ route('admin.video.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($video) ? route('admin.video.update', $video) : route('admin.video.store') }}"
          method="POST" enctype="multipart/form-data" x-data="videoForm()">
        @csrf
        @if(isset($video)) @method('PUT') @endif

        <div class="space-y-5">

            {{-- Info utama --}}
            <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
                <h3 class="font-semibold text-neutral-900 text-sm">Informasi Video</h3>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Judul Video <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $video->judul ?? '') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                        placeholder="Contoh: Kajian Subuh - Mempersiapkan Diri Menyambut Ramadhan">
                    @error('judul')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Kategori</label>
                    <select name="kategori_id" class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Tanpa kategori</option>
                        @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_id', $video->kategori_id ?? '') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all resize-none"
                        placeholder="Deskripsi singkat video...">{{ old('deskripsi', $video->deskripsi ?? '') }}</textarea>
                </div>
            </div>

            {{-- URL YouTube --}}
            <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
                <h3 class="font-semibold text-neutral-900 text-sm">Sumber Video</h3>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                        URL YouTube
                        <span class="font-normal text-neutral-400 ml-1">(opsional)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </div>
                        <input type="url" name="url_youtube"
                            value="{{ old('url_youtube', $video->url_youtube ?? '') }}"
                            @input="updateYoutubePreview($event.target.value)"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                            placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    @error('url_youtube')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

                    {{-- YouTube preview --}}
                    <div x-show="youtubeId" x-cloak class="mt-3 rounded-xl overflow-hidden aspect-video bg-neutral-100">
                        <iframe x-bind:src="'https://www.youtube.com/embed/' + youtubeId"
                            class="w-full h-full" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                    @if(isset($video) && $video->url_youtube)
                    @php
                        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video->url_youtube, $m);
                        $ytId = $m[1] ?? null;
                    @endphp
                    @if($ytId)
                    <div class="mt-3 rounded-xl overflow-hidden aspect-video bg-neutral-100" x-show="!youtubeId">
                        <iframe src="https://www.youtube.com/embed/{{ $ytId }}"
                            class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                    </div>
                    @endif
                    @endif
                </div>

                {{-- Thumbnail custom --}}
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Thumbnail Custom
                        <span class="font-normal text-neutral-400 ml-1">(opsional, otomatis dari YouTube jika kosong)</span>
                    </label>
                    @if(isset($video) && $video->thumbnail)
                    <div class="mb-2 rounded-xl overflow-hidden">
                        <img src="{{ Storage::url($video->thumbnail) }}" class="w-full h-32 object-cover" alt="Thumbnail">
                    </div>
                    @endif
                    <label class="block cursor-pointer">
                        <div class="border-2 border-dashed border-neutral-300 rounded-xl p-4 text-center hover:border-primary-400 hover:bg-primary-50 transition-colors">
                            <svg class="w-7 h-7 text-neutral-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-xs text-neutral-500">Klik untuk unggah thumbnail</p>
                            <p class="text-xs text-neutral-400 mt-0.5">JPG, PNG · maks. 2MB</p>
                        </div>
                        <input type="file" name="thumbnail" accept="image/*" class="hidden">
                    </label>
                    @error('thumbnail')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Pengaturan --}}
            <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                <h3 class="font-semibold text-neutral-900 text-sm mb-4">Pengaturan</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $video->is_active ?? true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                        <div>
                            <span class="text-sm text-neutral-700 font-medium">Video aktif</span>
                            <p class="text-xs text-neutral-400">Tampilkan di halaman publik</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured', $video->is_featured ?? false) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                        <div>
                            <span class="text-sm text-neutral-700 font-medium">Video unggulan</span>
                            <p class="text-xs text-neutral-400">Tampil di bagian utama halaman video</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    {{ isset($video) ? 'Simpan Perubahan' : 'Tambah Video' }}
                </button>
                <a href="{{ route('admin.video.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700 px-4 py-2.5 transition-colors">Batal</a>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
function videoForm() {
    return {
        youtubeId: '',
        updateYoutubePreview(url) {
            const match = url.match(/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
            this.youtubeId = match ? match[1] : '';
        }
    }
}
</script>
@endpush

@endsection
