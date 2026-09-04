@extends('layouts.admin')

@section('title', 'Media Library')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Media Library</span>
@endsection

@section('content')
<div class="space-y-5" x-data="mediaLibrary()">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">Media Library</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Kelola semua file yang diunggah ke sistem</p>
        </div>
        <button @click="showUpload = true"
            class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Unggah File
        </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-neutral-200 px-5 py-3 flex items-center gap-3 flex-wrap">
        <span class="text-sm text-neutral-500 font-medium">Filter:</span>
        @foreach(['' => 'Semua', 'image' => 'Gambar', 'application/pdf' => 'PDF', 'video' => 'Video', 'audio' => 'Audio'] as $val => $label)
        <a href="{{ request()->fullUrlWithQuery(['tipe' => $val]) }}"
            class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
            {{ request('tipe', '') === $val ? 'bg-primary-600 text-white' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
            {{ $label }}
        </a>
        @endforeach
        <span class="ml-auto text-xs text-neutral-400">{{ $files->total() }} file</span>
    </div>

    {{-- Grid --}}
    @if($files->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
        @foreach($files as $file)
        <div class="group bg-white rounded-xl border border-neutral-200 overflow-hidden hover:border-primary-300 hover:shadow-sm transition-all">
            {{-- Preview --}}
            <div class="aspect-square bg-neutral-50 flex items-center justify-center overflow-hidden relative">
                @if(str_starts_with($file->mime_type, 'image/'))
                    <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->nama }}"
                        class="w-full h-full object-cover">
                @elseif($file->mime_type === 'application/pdf')
                    <div class="flex flex-col items-center gap-1">
                        <svg class="w-10 h-10 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8 12h8v1H8v-1zm0 2h8v1H8v-1zm0 2h5v1H8v-1z"/></svg>
                        <span class="text-xs text-red-500 font-semibold">PDF</span>
                    </div>
                @elseif(str_starts_with($file->mime_type, 'video/'))
                    <div class="flex flex-col items-center gap-1">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span class="text-xs text-blue-500 font-semibold">VIDEO</span>
                    </div>
                @elseif(str_starts_with($file->mime_type, 'audio/'))
                    <div class="flex flex-col items-center gap-1">
                        <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        <span class="text-xs text-purple-500 font-semibold">AUDIO</span>
                    </div>
                @else
                    <div class="flex flex-col items-center gap-1">
                        <svg class="w-10 h-10 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="text-xs text-neutral-500 font-semibold uppercase">{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}</span>
                    </div>
                @endif

                {{-- Hover actions --}}
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                    <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                        class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-neutral-700 hover:text-primary-600 transition-colors" title="Lihat">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <button @click="copyUrl('{{ Storage::url($file->file_path) }}')"
                        class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-neutral-700 hover:text-primary-600 transition-colors" title="Salin URL">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                    <form action="{{ route('admin.media.destroy', $file) }}" method="POST"
                        onsubmit="return confirm('Hapus file ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-neutral-700 hover:text-red-600 transition-colors" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Info --}}
            <div class="p-2">
                <p class="text-xs font-medium text-neutral-700 truncate" title="{{ $file->nama }}">{{ $file->nama }}</p>
                <p class="text-xs text-neutral-400 mt-0.5">{{ number_format($file->file_size / 1024, 1) }} KB</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($files->hasPages())
    <div>{{ $files->links() }}</div>
    @endif

    @else
    {{-- Empty state --}}
    <div class="bg-white rounded-2xl border border-neutral-200 py-20 text-center">
        <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <p class="text-sm font-medium text-neutral-500">Belum ada file</p>
        <p class="text-xs text-neutral-400 mt-1 mb-5">Unggah gambar, dokumen, atau file lainnya</p>
        <button @click="showUpload = true"
            class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Unggah Sekarang
        </button>
    </div>
    @endif

    {{-- ── Upload Modal ── --}}
    <div x-show="showUpload" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @keydown.escape.window="showUpload = false">
        <div class="absolute inset-0 bg-black/50" @click="showUpload = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 z-10">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-neutral-900">Unggah File</h2>
                <button @click="showUpload = false" class="p-1 rounded-lg text-neutral-400 hover:bg-neutral-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    {{-- Drop zone --}}
                    <label class="block cursor-pointer"
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="handleDrop($event)">
                        <div :class="dragging ? 'border-primary-500 bg-primary-50' : 'border-neutral-300 hover:border-primary-400 hover:bg-primary-50'"
                            class="border-2 border-dashed rounded-xl p-8 text-center transition-colors">
                            <svg class="w-10 h-10 text-neutral-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <p class="text-sm font-medium text-neutral-600" x-text="fileName || 'Drag & drop atau klik untuk pilih file'"></p>
                            <p class="text-xs text-neutral-400 mt-1">Semua tipe file · maks. 10MB</p>
                        </div>
                        <input type="file" name="file" id="file-input" required class="hidden"
                            @change="fileName = $event.target.files[0]?.name">
                    </label>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama File</label>
                        <input type="text" name="nama" placeholder="Kosongkan untuk nama otomatis"
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Koleksi</label>
                        <input type="text" name="koleksi" placeholder="Contoh: galeri, dokumen, banner"
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <div class="flex gap-3 mt-5">
                    <button type="submit"
                        class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                        Unggah
                    </button>
                    <button type="button" @click="showUpload = false"
                        class="px-4 py-2.5 rounded-xl border border-neutral-300 text-neutral-600 text-sm font-medium hover:bg-neutral-50 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Copy URL toast --}}
    <div x-show="copied" x-cloak x-transition
        class="fixed bottom-6 right-6 z-50 bg-neutral-900 text-white text-sm font-medium px-4 py-2.5 rounded-xl shadow-lg">
        URL disalin ke clipboard!
    </div>

</div>
@endsection

@push('scripts')
<script>
function mediaLibrary() {
    return {
        showUpload: false,
        dragging: false,
        fileName: '',
        copied: false,

        handleDrop(e) {
            this.dragging = false;
            const file = e.dataTransfer.files[0];
            if (file) {
                const input = document.getElementById('file-input');
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                this.fileName = file.name;
            }
        },

        copyUrl(url) {
            navigator.clipboard.writeText(url).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            });
        }
    }
}
</script>
@endpush
