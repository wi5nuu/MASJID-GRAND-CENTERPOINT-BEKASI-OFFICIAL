{{-- Marquee / Running Text Bar --}}
{{-- Diambil dari tv_displays dengan tipe 'running_text' yang aktif --}}
@php
    $marqueeItems = \App\Models\TvDisplay::where('tipe', 'running_text')
        ->where('is_active', true)
        ->orderBy('urutan')
        ->pluck('konten')
        ->toArray();
@endphp

@if(count($marqueeItems) > 0)

{{-- CSS inline agar pasti terbaca, tidak bergantung pada @stack --}}
<style>
@keyframes marquee-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.marquee-track {
    display: flex;
    white-space: nowrap;
    animation: marquee-scroll 50s linear infinite;
    will-change: transform;
}
.marquee-track.paused {
    animation-play-state: paused;
}
</style>

<div
    class="relative z-30 bg-gradient-to-r from-primary-800 via-primary-700 to-primary-800 border-b border-primary-600/50"
    x-data="marqueeBar()"
    @mouseenter="pause()"
    @mouseleave="resume()"
>
    <div class="flex items-center h-9">

        {{-- Label "INFO" di kiri --}}
        <div class="shrink-0 flex items-center gap-2 bg-gold-500 px-4 h-full z-10 shadow-md">
            <svg class="w-3.5 h-3.5 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="text-white text-xs font-bold uppercase tracking-widest whitespace-nowrap select-none">Info</span>
        </div>

        {{-- Area teks berjalan --}}
        <div class="overflow-hidden flex-1 h-full flex items-center">
            {{-- Track diduplikasi 2x agar looping seamless --}}
            <div
                class="marquee-track"
                :class="paused ? 'paused' : ''"
            >
                {{-- Set 1 --}}
                <span class="inline-flex items-center">
                    @foreach($marqueeItems as $i => $item)
                        <span class="text-white text-sm font-medium px-1">{{ $item }}</span>
                        <span class="text-gold-400 px-3 select-none" aria-hidden="true">&#9670;</span>
                    @endforeach
                </span>
                {{-- Set 2 (duplikat untuk seamless loop) --}}
                <span class="inline-flex items-center">
                    @foreach($marqueeItems as $i => $item)
                        <span class="text-white text-sm font-medium px-1">{{ $item }}</span>
                        <span class="text-gold-400 px-3 select-none" aria-hidden="true">&#9670;</span>
                    @endforeach
                </span>
            </div>
        </div>

    </div>
</div>

@endif
