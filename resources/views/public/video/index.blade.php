@extends('layouts.public')

@section('title', 'Video & Kajian — Masjid Grand Centerpoint Bekasi')
@section('meta_description', 'Tonton video kajian, ceramah, dan kegiatan Masjid Grand Centerpoint Bekasi.')

@section('content')

<section class="page-header">
    <div class="container-xl relative z-10">
        <div class="max-w-2xl mx-auto text-center">
            <span class="section-label" style="color: rgba(255,255,255,0.7);">MEDIA</span>
            <h1 class="font-heading text-3xl sm:text-5xl font-bold leading-tight mt-2 mb-4" style="color: #ffffff;">Video & Kajian</h1>
            <p class="text-white/70 text-sm max-w-lg mx-auto">Rekaman kajian, khutbah, dan ceramah dari Masjid Grand Centerpoint Bekasi.</p>
            <nav class="flex items-center justify-center gap-2 mt-6 text-sm text-white/50">
                <a href="{{ route('home') }}" class="hover:text-white/80 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/80">Video</span>
            </nav>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-xl">

        <form method="GET" class="flex flex-wrap items-center gap-3 mb-8">
            <div class="relative flex-1 min-w-0 sm:min-w-[180px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari video..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <select name="kategori" class="w-full sm:w-auto px-3 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                <option value="{{ $kat->slug }}" {{ request('kategori') == $kat->slug ? 'selected' : '' }}>{{ $kat->nama }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full sm:w-auto bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">Filter</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($videos as $video)
            <article class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                <a href="{{ route('video.show', $video->slug) }}" class="block">
                    <div class="aspect-video bg-neutral-900 relative overflow-hidden">
                        @if($video->thumbnail_url)
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->judul }}" class="w-full h-full object-cover" loading="lazy">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-900 to-primary-700 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        </div>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 hover:bg-black/30 transition-colors">
                            <div class="w-12 h-12 rounded-full bg-white/90 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-700 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="p-4">
                    <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">{{ $video->kategori->nama ?? 'Video' }}</span>
                    <h3 class="font-semibold text-neutral-900 text-sm mt-2 mb-1 line-clamp-2">
                        <a href="{{ route('video.show', $video->slug) }}" class="hover:text-primary-600 transition-colors">{{ $video->judul }}</a>
                    </h3>
                    <div class="flex items-center gap-3 text-xs text-neutral-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ number_format($video->views) }}
                        </span>
                        @if($video->published_at)
                        <span>{{ \Carbon\Carbon::parse($video->published_at)->locale('id')->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16">
                <svg class="w-12 h-12 text-neutral-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                <p class="text-neutral-500 text-sm">Belum ada video.</p>
            </div>
            @endforelse
        </div>

        @if($videos->hasPages())
        <div class="mt-8 flex justify-center">{{ $videos->links() }}</div>
        @endif
    </div>
</section>
@endsection
