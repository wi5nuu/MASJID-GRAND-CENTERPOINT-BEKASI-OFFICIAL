@extends('layouts.public')

@section('title', $video->judul.' — Video Masjid Grand Centerpoint Bekasi')

@section('content')
<section class="py-10 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-neutral-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('video.index') }}" class="hover:text-primary-600 transition-colors">Video</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-neutral-600 line-clamp-1">{{ $video->judul }}</span>
        </nav>

        <h1 class="text-2xl font-bold text-neutral-900 mb-4">{{ $video->judul }}</h1>

        {{-- Video Player --}}
        <div class="aspect-video rounded-2xl overflow-hidden bg-black mb-6">
            @if($video->youtube_id)
            <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}?autoplay=0&rel=0"
                class="w-full h-full" frameborder="0" allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                title="{{ $video->judul }}"></iframe>
            @elseif($video->file_video)
            <video controls class="w-full h-full" preload="metadata">
                <source src="{{ Storage::url($video->file_video) }}" type="video/mp4">
                Browser Anda tidak mendukung video.
            </video>
            @else
            <div class="w-full h-full flex items-center justify-center bg-neutral-900">
                <p class="text-neutral-400 text-sm">Video tidak tersedia.</p>
            </div>
            @endif
        </div>

        @if($video->deskripsi)
        <div class="prose prose-sm max-w-none text-neutral-600 mb-8">
            <p>{{ $video->deskripsi }}</p>
        </div>
        @endif

        @if($related->isNotEmpty())
        <h3 class="font-bold text-neutral-900 mb-4">Video Lainnya</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @foreach($related as $rel)
            <a href="{{ route('video.show', $rel->slug) }}" class="block bg-neutral-50 rounded-xl overflow-hidden card-hover">
                <div class="aspect-video bg-neutral-200 relative overflow-hidden">
                    @if($rel->thumbnail_url)
                    <img src="{{ $rel->thumbnail_url }}" alt="{{ $rel->judul }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                    </div>
                    @endif
                </div>
                <div class="p-3">
                    <h4 class="text-xs font-semibold text-neutral-900 line-clamp-2">{{ $rel->judul }}</h4>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('video.index') }}" class="inline-flex items-center gap-2 text-sm text-primary-600 font-medium hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Video
            </a>
        </div>
    </div>
</section>
@endsection
