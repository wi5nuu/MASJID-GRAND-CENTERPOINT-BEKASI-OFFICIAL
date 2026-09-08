@extends('layouts.public')

@section('title', 'Berita & Artikel — Masjid Grand Centerpoint Bekasi')

@section('content')

<section class="page-header">
    <div class="container-xl relative z-10">
        <div class="max-w-2xl mx-auto text-center">
            <span class="section-label" style="color: rgba(255,255,255,0.7);">INFORMASI</span>
            <h1 class="font-heading text-3xl sm:text-5xl font-bold leading-tight mt-2 mb-4" style="color: #ffffff;">Berita & Artikel</h1>
            <p class="text-white/70 text-sm max-w-lg mx-auto">Informasi terbaru seputar kegiatan dan kajian Masjid Grand Centerpoint Bekasi.</p>
            <nav class="flex items-center justify-center gap-2 mt-6 text-sm text-white/50">
                <a href="{{ route('home') }}" class="hover:text-white/80 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/80">Berita</span>
            </nav>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-xl">

        {{-- Filter & Search --}}
        <form method="GET" class="flex flex-wrap items-center gap-3 mb-8">
            <div class="relative flex-1 min-w-0 sm:min-w-[180px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari berita..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <select name="kategori" class="w-full sm:w-auto px-3 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                <option value="{{ $kat->slug }}" {{ request('kategori') == $kat->slug ? 'selected' : '' }}>{{ $kat->nama }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">Cari</button>
        </form>

        {{-- Featured --}}
        @if($featured->isNotEmpty() && !request()->hasAny(['cari','kategori']))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-10">
            @foreach($featured->take(3) as $i => $item)
            <article class="{{ $i === 0 ? 'lg:col-span-2' : '' }} bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                <div class="aspect-video overflow-hidden bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    @if($item->thumbnail)
                    <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover" loading="lazy">
                    @else
                    <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">{{ $item->kategori->nama ?? 'Umum' }}</span>
                        <span class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($item->published_at)->locale('id')->diffForHumans() }}</span>
                    </div>
                    <h2 class="{{ $i === 0 ? 'text-lg' : 'text-sm' }} font-bold text-neutral-900 mb-2 line-clamp-2 hover:text-primary-600 transition-colors">
                        <a href="{{ route('berita.show', $item->slug) }}">{{ $item->judul }}</a>
                    </h2>
                    @if($item->ringkasan)
                    <p class="text-xs text-neutral-500 line-clamp-2">{{ $item->ringkasan }}</p>
                    @endif
                </div>
            </article>
            @endforeach
        </div>
        @endif

        {{-- All Berita --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($beritas as $berita)
            <article class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                <div class="aspect-video overflow-hidden bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    @if($berita->thumbnail)
                    <img src="{{ Storage::url($berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    @else
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">{{ $berita->kategori->nama ?? 'Umum' }}</span>
                        <span class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($berita->published_at)->locale('id')->diffForHumans() }}</span>
                    </div>
                    <h3 class="font-semibold text-neutral-900 text-sm leading-snug mb-2 line-clamp-2">
                        <a href="{{ route('berita.show', $berita->slug) }}" class="hover:text-primary-600 transition-colors">{{ $berita->judul }}</a>
                    </h3>
                    @if($berita->ringkasan)
                    <p class="text-xs text-neutral-500 line-clamp-2">{{ $berita->ringkasan }}</p>
                    @endif
                    <div class="flex items-center gap-3 mt-3 pt-3 border-t border-neutral-50">
                        <span class="flex items-center gap-1 text-xs text-neutral-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ number_format($berita->views) }}
                        </span>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="ml-auto text-xs text-primary-600 font-medium hover:underline">Baca selengkapnya</a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16">
                <svg class="w-12 h-12 text-neutral-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <p class="text-neutral-500 text-sm">Belum ada berita yang diterbitkan.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($beritas->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $beritas->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
