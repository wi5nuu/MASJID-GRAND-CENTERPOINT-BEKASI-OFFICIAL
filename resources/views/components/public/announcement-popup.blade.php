{{-- Announcement Popup --}}
{{-- Diambil dari tv_displays dengan tipe 'popup' yang aktif --}}
@php
    $popups = \App\Models\TvDisplay::where('tipe', 'popup')
        ->where('is_active', true)
        ->orderBy('urutan')
        ->get();
@endphp

@if($popups->count() > 0)
<div
    x-data="announcementPopup()"
    x-init="items = {{ $popups->map(fn($p) => ['judul' => $p->judul, 'konten' => $p->konten, 'file' => $p->file])->toJson() }}; init()"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    @keydown.escape.window="close()"
>
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        @click="close()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    {{-- Modal --}}
    <div
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        @click.stop
    >
        {{-- Header dekoratif --}}
        <div class="bg-gradient-to-r from-primary-700 to-primary-600 px-6 pt-6 pb-4 relative overflow-hidden">
            {{-- Pattern Islamic background --}}
            <div class="absolute inset-0 pattern-islamic opacity-20"></div>
            <div class="relative flex items-start justify-between gap-3">
                <div class="flex items-center gap-2">
                    {{-- Star/Announcement icon --}}
                    <div class="w-8 h-8 rounded-full bg-gold-400/30 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-gold-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gold-300 text-xs font-medium uppercase tracking-widest">Pengumuman</p>
                        <h3 class="text-white font-bold text-base leading-tight" x-text="current ? current.judul : ''"></h3>
                    </div>
                </div>
                {{-- Close button --}}
                <button
                    @click="close()"
                    class="shrink-0 w-7 h-7 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors"
                    aria-label="Tutup"
                >
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Gambar poster (jika ada) --}}
        <template x-if="current && current.file">
            <div class="w-full bg-neutral-100">
                <img
                    :src="'/storage/' + current.file"
                    :alt="current ? current.judul : 'Pengumuman'"
                    class="w-full object-cover max-h-64"
                    onerror="this.parentElement.style.display='none'"
                >
            </div>
        </template>

        {{-- Konten teks --}}
        <div class="px-6 py-5">
            <p class="text-neutral-600 text-sm leading-relaxed" x-text="current ? current.konten : ''"></p>
        </div>

        {{-- Footer: navigasi multi-popup + tombol aksi --}}
        <div class="px-6 pb-5 flex items-center justify-between gap-3">
            {{-- Indikator dots (jika > 1 popup) --}}
            <div class="flex items-center gap-1.5" x-show="items.length > 1">
                <template x-for="(item, idx) in items" :key="idx">
                    <button
                        @click="currentIndex = idx"
                        :class="currentIndex === idx ? 'w-5 bg-primary-600' : 'w-2 bg-neutral-300'"
                        class="h-2 rounded-full transition-all duration-300"
                    ></button>
                </template>
            </div>
            <div x-show="items.length <= 1" class="flex-1"></div>

            {{-- Navigasi prev/next + close --}}
            <div class="flex items-center gap-2 ml-auto">
                <button
                    x-show="items.length > 1 && currentIndex > 0"
                    @click="prev()"
                    class="px-3 py-1.5 rounded-lg border border-neutral-200 text-neutral-600 text-xs font-medium hover:bg-neutral-50 transition-colors"
                >
                    Sebelumnya
                </button>
                <button
                    x-show="items.length > 1 && currentIndex < items.length - 1"
                    @click="next()"
                    class="px-3 py-1.5 rounded-lg bg-primary-600 text-white text-xs font-medium hover:bg-primary-700 transition-colors"
                >
                    Berikutnya
                </button>
                <button
                    x-show="items.length <= 1 || currentIndex === items.length - 1"
                    @click="close()"
                    class="px-4 py-1.5 rounded-lg bg-primary-600 text-white text-xs font-semibold hover:bg-primary-700 transition-colors"
                >
                    Tutup
                </button>
            </div>
        </div>

        {{-- Gold accent bottom line --}}
        <div class="h-1 bg-gradient-to-r from-gold-400 via-gold-500 to-gold-400"></div>
    </div>
</div>
@endif
