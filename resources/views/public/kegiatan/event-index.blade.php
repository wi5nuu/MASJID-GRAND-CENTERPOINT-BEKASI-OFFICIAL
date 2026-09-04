@extends('layouts.public')
@section('title', 'Event Khusus — Masjid Grand Centerpoint Bekasi')
@section('content')
<section class="bg-gradient-to-br from-primary-800 to-primary-900 relative overflow-hidden py-14">
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">Event Khusus</h1>
        <p class="text-primary-200 text-sm">Program dan event spesial dari Masjid Grand Centerpoint Bekasi.</p>
    </div>
</section>
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($events as $event)
            <article class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                @if($event->thumbnail)
                <div class="aspect-video overflow-hidden"><img src="{{ Storage::url($event->thumbnail) }}" alt="{{ $event->judul }}" class="w-full h-full object-cover"></div>
                @else
                <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                @endif
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="flex items-center gap-1 text-xs text-neutral-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($event->tanggal_mulai)->locale('id')->isoFormat('D MMM Y') }}
                        </span>
                    </div>
                    <h3 class="font-bold text-neutral-900 text-sm mb-2">{{ $event->judul }}</h3>
                    @if($event->deskripsi)<p class="text-xs text-neutral-500 line-clamp-2">{{ $event->deskripsi }}</p>@endif
                    @if($event->lokasi)
                    <p class="flex items-center gap-1 text-xs text-neutral-400 mt-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $event->lokasi }}
                    </p>
                    @endif
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-16">
                <p class="text-neutral-500 text-sm">Belum ada event khusus.</p>
            </div>
            @endforelse
        </div>
        @if($events->hasPages())
        <div class="mt-8 flex justify-center">{{ $events->links() }}</div>
        @endif
    </div>
</section>
@endsection
