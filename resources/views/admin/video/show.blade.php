@extends('layouts.admin')

@section('title', 'Detail Video')
@section('breadcrumb')
    <a href="{{ route('admin.video.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Video & Kajian</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">Detail</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">Detail Video</h1>
        <a href="{{ route('admin.video.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        @php
            $ytId = null;
            if ($video->url_youtube && preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video->url_youtube, $m)) $ytId = $m[1];
        @endphp
        @if($ytId)
        <div class="aspect-video bg-neutral-900">
            <iframe src="https://www.youtube.com/embed/{{ $ytId }}" title="{{ $video->judul }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
        </div>
        @elseif($video->thumbnail)
        <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->judul }}" class="w-full max-h-96 object-cover bg-neutral-100">
        @endif
        <div class="px-6 py-5">
            <div class="flex items-start justify-between gap-4 mb-4">
                <h2 class="font-bold text-neutral-900 text-lg">{{ $video->judul }}</h2>
                @if($video->is_active)
                <span class="inline-flex items-center gap-1 bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-1 rounded-full shrink-0">Aktif</span>
                @else
                <span class="inline-flex items-center gap-1 bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full shrink-0">Nonaktif</span>
                @endif
            </div>
            @if($video->deskripsi)
            <p class="text-sm text-neutral-600 leading-relaxed mb-4">{{ $video->deskripsi }}</p>
            @endif
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Kategori</dt>
                    <dd class="text-sm text-neutral-800">{{ $video->kategori->nama ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Dilihat</dt>
                    <dd class="text-sm text-neutral-800">{{ number_format($video->views ?? 0, 0, ',', '.') }}x</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">URL YouTube</dt>
                    <dd class="text-sm text-neutral-800 break-all">{{ $video->url_youtube ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Unggulan</dt>
                    <dd class="text-sm text-neutral-800">{{ $video->is_featured ? 'Ya' : 'Tidak' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1"> Tayang</dt>
                    <dd class="text-sm text-neutral-800">{{ $video->published_at ? $video->published_at->format('d M Y') : '-' }}</dd>
                </div>
            </dl>
        </div>
        <div class="px-6 py-4 border-t border-neutral-100 flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.video.edit', $video) }}"
                class="inline-flex items-center gap-1.5 border border-neutral-300 hover:bg-neutral-50 text-neutral-700 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">Edit</a>
            <form action="{{ route('admin.video.destroy', $video) }}" method="POST"
                data-confirm="Video ini akan dihapus permanen dan tidak dapat dikembalikan." data-confirm-title="Hapus Video?" data-confirm-ok="Ya, Hapus" data-confirm-variant="danger">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
