@extends('layouts.public')

@section('title', $event->judul . ' — Masjid Grand Centerpoint Bekasi')

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-primary-800 to-primary-900 relative overflow-hidden py-14">
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-primary-300 text-xs mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('event.index') }}" class="hover:text-white transition-colors">Event</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white">{{ Str::limit($event->judul, 40) }}</span>
        </div>
        <span class="inline-block bg-gold-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Event Khusus</span>
        <h1 class="text-2xl sm:text-3xl font-bold text-white max-w-3xl">{{ $event->judul }}</h1>
    </div>
</section>

{{-- Content --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main --}}
            <div class="lg:col-span-2">
                @if($event->thumbnail)
                <img src="{{ Storage::url($event->thumbnail) }}" alt="{{ $event->judul }}"
                    class="w-full h-72 object-cover rounded-2xl mb-6 shadow-md">
                @endif

                <div class="prose prose-neutral max-w-none text-sm leading-relaxed text-neutral-700">
                    {!! nl2br(e($event->deskripsi)) !!}
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-4">
                <div class="bg-gold-50 rounded-2xl border border-gold-100 p-5 space-y-4">
                    <h3 class="font-semibold text-gold-800 text-sm">Detail Event</h3>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gold-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 mb-0.5">Tanggal</p>
                            <p class="text-sm font-semibold text-neutral-800">
                                {{ $event->tanggal_mulai ? \Carbon\Carbon::parse($event->tanggal_mulai)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                                @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                    — {{ \Carbon\Carbon::parse($event->tanggal_selesai)->locale('id')->isoFormat('D MMMM Y') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($event->waktu_mulai)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gold-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 mb-0.5">Waktu</p>
                            <p class="text-sm font-semibold text-neutral-800">
                                {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($event->lokasi)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gold-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 mb-0.5">Lokasi</p>
                            <p class="text-sm font-semibold text-neutral-800">{{ $event->lokasi }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <a href="{{ route('event.index') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl border border-primary-600 text-primary-600 hover:bg-primary-50 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Event
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
