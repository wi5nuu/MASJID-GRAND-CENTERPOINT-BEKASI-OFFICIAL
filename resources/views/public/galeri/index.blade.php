@extends('layouts.public')

@section('title', 'Galeri Foto — Masjid Grand Centerpoint Bekasi')

@section('content')

<section class="bg-gradient-to-br from-primary-800 to-primary-900 relative overflow-hidden py-14">
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block text-xs font-semibold text-primary-200 uppercase tracking-widest mb-3">Media</span>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">Galeri Foto</h1>
        <p class="text-primary-200 text-sm">Dokumentasi kegiatan dan momen di Masjid Grand Centerpoint Bekasi.</p>
    </div>
</section>

<section class="py-12 bg-white" x-data="lightbox()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Album Filter --}}
        @if($albums->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-8">
            <a href="{{ route('galeri.index') }}" class="px-4 py-1.5 rounded-full text-sm font-medium {{ !request('album') ? 'bg-primary-600 text-white' : 'bg-neutral-100 text-neutral-600 hover:bg-primary-50 hover:text-primary-700' }} transition-colors">Semua</a>
            @foreach($albums as $album)
            <a href="{{ route('galeri.index', ['album' => $album]) }}" class="px-4 py-1.5 rounded-full text-sm font-medium {{ request('album') == $album ? 'bg-primary-600 text-white' : 'bg-neutral-100 text-neutral-600 hover:bg-primary-50 hover:text-primary-700' }} transition-colors">{{ $album }}</a>
            @endforeach
        </div>
        @endif

        {{-- Gallery Grid --}}
        @php
            $allImages = $galeris->map(fn($g) => ['src' => Storage::url($g->file), 'caption' => $g->judul])->values()->toArray();
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @forelse($galeris as $i => $foto)
            <div class="aspect-square rounded-xl overflow-hidden bg-neutral-100 cursor-pointer group relative"
                @click="show('{{ Storage::url($foto->file) }}', '{{ addslashes($foto->judul) }}', {{ json_encode($allImages) }}, {{ $i }})">
                <img src="{{ Storage::url($foto->file) }}" alt="{{ $foto->judul }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                    <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-16">
                <svg class="w-12 h-12 text-neutral-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-neutral-500 text-sm">Belum ada foto.</p>
            </div>
            @endforelse
        </div>

        @if($galeris->hasPages())
        <div class="mt-8 flex justify-center">{{ $galeris->links() }}</div>
        @endif
    </div>

    {{-- Lightbox --}}
    <div x-show="open" x-cloak @keydown.escape.window="close()"
        class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <button @click="close()" class="absolute top-4 right-4 text-white/70 hover:text-white p-2 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-2 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <div class="max-w-4xl w-full">
            <img :src="current" :alt="currentCaption" class="max-h-[80vh] mx-auto rounded-xl object-contain">
            <p class="text-white/70 text-sm text-center mt-3" x-text="currentCaption"></p>
        </div>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-2 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>
</section>
@endsection
