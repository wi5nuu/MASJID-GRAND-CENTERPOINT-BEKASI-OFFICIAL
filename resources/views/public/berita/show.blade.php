@extends('layouts.public')

@section('title', $berita->meta_title ?? $berita->judul.' — Masjid Grand Centerpoint Bekasi')
@section('meta_description', $berita->meta_description ?? $berita->ringkasan)

@section('content')

<section class="py-10 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-neutral-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('berita.index') }}" class="hover:text-primary-600 transition-colors">Berita</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-neutral-600 line-clamp-1">{{ $berita->judul }}</span>
        </nav>

        {{-- Article Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2.5 py-1 rounded-full">{{ $berita->kategori->nama ?? 'Umum' }}</span>
                <span class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($berita->published_at)->locale('id')->isoFormat('D MMMM Y') }}</span>
                <span class="text-xs text-neutral-300">•</span>
                <span class="flex items-center gap-1 text-xs text-neutral-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    {{ number_format($berita->views) }} pembaca
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-4 leading-snug">{{ $berita->judul }}</h1>
            @if($berita->ringkasan)
            <p class="text-neutral-500 text-base leading-relaxed border-l-4 border-primary-500 pl-4 italic">{{ $berita->ringkasan }}</p>
            @endif
        </div>

        {{-- Thumbnail --}}
        @if($berita->thumbnail)
        <div class="mb-8 rounded-2xl overflow-hidden">
            <img src="{{ Storage::url($berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full object-cover max-h-96">
        </div>
        @endif

        {{-- Content --}}
        <div class="prose prose-sm sm:prose max-w-none prose-headings:text-neutral-900 prose-a:text-primary-600 prose-img:rounded-xl mb-10">
            {!! $berita->konten !!}
        </div>

        {{-- Share --}}
        <div class="flex items-center gap-3 py-5 border-t border-b border-neutral-100 mb-10">
            <span class="text-sm font-medium text-neutral-600">Bagikan:</span>
            <a href="https://wa.me/?text={{ urlencode($berita->judul.' '.url()->current()) }}" target="_blank" rel="noopener"
                class="flex items-center gap-1.5 text-xs font-medium text-neutral-600 hover:text-primary-600 bg-neutral-100 hover:bg-primary-50 px-3 py-1.5 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                WhatsApp
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
                class="flex items-center gap-1.5 text-xs font-medium text-neutral-600 hover:text-primary-600 bg-neutral-100 hover:bg-primary-50 px-3 py-1.5 rounded-lg transition-colors">
                Facebook
            </a>
        </div>

        {{-- Related --}}
        @if($related->isNotEmpty())
        <div>
            <h3 class="font-bold text-neutral-900 mb-4">Berita Terkait</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($related as $rel)
                <article class="bg-neutral-50 rounded-xl overflow-hidden card-hover">
                    <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center overflow-hidden">
                        @if($rel->thumbnail)
                        <img src="{{ Storage::url($rel->thumbnail) }}" alt="{{ $rel->judul }}" class="w-full h-full object-cover">
                        @else
                        <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        @endif
                    </div>
                    <div class="p-3">
                        <h4 class="text-xs font-semibold text-neutral-900 line-clamp-2 hover:text-primary-600 transition-colors">
                            <a href="{{ route('berita.show', $rel->slug) }}">{{ $rel->judul }}</a>
                        </h4>
                        <p class="text-xs text-neutral-400 mt-1">{{ \Carbon\Carbon::parse($rel->published_at)->locale('id')->diffForHumans() }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-sm text-primary-600 font-medium hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Berita
            </a>
        </div>
    </div>
</section>
@endsection
