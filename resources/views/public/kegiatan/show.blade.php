@extends('layouts.public')

@section('title', $kegiatan->judul . ' — Masjid Grand Centerpoint Bekasi')
@section('meta_description', Str::limit(strip_tags($kegiatan->deskripsi), 160))

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-primary-800 to-primary-900 relative overflow-hidden py-14">
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-primary-300 text-xs mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('kegiatan.index') }}" class="hover:text-white transition-colors">Kegiatan</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white">{{ Str::limit($kegiatan->judul, 40) }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-white max-w-3xl">{{ $kegiatan->judul }}</h1>
    </div>
</section>

{{-- Content --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main --}}
            <div class="lg:col-span-2">
                @if($kegiatan->thumbnail)
                <img src="{{ Storage::url($kegiatan->thumbnail) }}" alt="{{ $kegiatan->judul }}"
                    class="w-full h-64 object-cover rounded-2xl mb-6">
                @endif

                <div class="prose prose-neutral max-w-none text-sm leading-relaxed text-neutral-700">
                    {!! nl2br(e($kegiatan->deskripsi)) !!}
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-4">
                <div class="bg-primary-50 rounded-2xl border border-primary-100 p-5 space-y-4">
                    <h3 class="font-semibold text-primary-800 text-sm">Informasi Kegiatan</h3>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 mb-0.5">Tanggal</p>
                            <p class="text-sm font-semibold text-neutral-800">
                                {{ $kegiatan->tanggal ? $kegiatan->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') : '-' }}
                            </p>
                        </div>
                    </div>

                    @if($kegiatan->waktu_mulai)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 mb-0.5">Waktu</p>
                            <p class="text-sm font-semibold text-neutral-800">
                                {{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} WIB
                                @if($kegiatan->waktu_selesai)
                                    — {{ \Carbon\Carbon::parse($kegiatan->waktu_selesai)->format('H:i') }} WIB
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($kegiatan->lokasi)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 mb-0.5">Lokasi</p>
                            <p class="text-sm font-semibold text-neutral-800">{{ $kegiatan->lokasi }}</p>
                        </div>
                    </div>
                    @endif

                    @if($kegiatan->narasumber)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 mb-0.5">Narasumber</p>
                            <p class="text-sm font-semibold text-neutral-800">{{ $kegiatan->narasumber }}</p>
                        </div>
                    </div>
                    @endif

                    @if($kegiatan->kategori)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400 mb-0.5">Kategori</p>
                            <p class="text-sm font-semibold text-neutral-800">{{ $kegiatan->kategori->nama }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <a href="{{ route('kegiatan.index') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl border border-primary-600 text-primary-600 hover:bg-primary-50 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Jadwal
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
