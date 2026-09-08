@extends('layouts.public')

@section('title', 'Donasi — Masjid Grand Centerpoint Bekasi')

@section('content')

<section class="page-header">
    <div class="container-xl relative z-10">
        <div class="max-w-2xl mx-auto text-center">
            <p class="font-arabic text-2xl text-gold-300 mb-3" dir="rtl">مَن ذَا الَّذِي يُقْرِضُ اللَّهَ قَرْضًا حَسَنًا</p>
            <span class="section-label" style="color: rgba(255,255,255,0.7);">PROGRAM DONASI</span>
            <h1 class="font-heading text-3xl sm:text-5xl font-bold leading-tight mt-2 mb-4" style="color: #ffffff;">Program Donasi</h1>
            <p class="text-white/70 text-sm max-w-lg mx-auto">Salurkan infak dan sedekah Anda untuk kemakmuran masjid dan kemaslahatan umat.</p>
            <nav class="flex items-center justify-center gap-2 mt-6 text-sm text-white/50">
                <a href="{{ route('home') }}" class="hover:text-white/80 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/80">Donasi</span>
            </nav>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-xl">

        {{-- Total donasi --}}
        <div class="bg-primary-50 border border-primary-100 rounded-2xl p-5 mb-10 text-center">
            <p class="text-sm text-primary-700 mb-1">Total Donasi Terkumpul</p>
            <p class="text-3xl font-bold text-primary-800">Rp {{ number_format($totalTerkumpul, 0, ',', '.') }}</p>
            <p class="text-xs text-primary-500 mt-1">Jazakallahu khairan kepada seluruh donatur</p>
        </div>

        {{-- Program Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse($programs as $program)
            <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                @if($program->thumbnail)
                <div class="aspect-video overflow-hidden">
                    <img src="{{ Storage::url($program->thumbnail) }}" alt="{{ $program->nama }}" class="w-full h-full object-cover">
                </div>
                @else
                <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                @endif
                <div class="p-5">
                    <h3 class="font-bold text-neutral-900 mb-2">{{ $program->nama }}</h3>
                    @if($program->deskripsi)
                    <p class="text-xs text-neutral-500 mb-4 line-clamp-2">{{ $program->deskripsi }}</p>
                    @endif
                    @if($program->target)
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-neutral-500 mb-1.5">
                            <span>Terkumpul</span>
                            <span class="font-semibold text-primary-700">{{ $program->persentase }}%</span>
                        </div>
                        <div class="h-2 bg-neutral-100 rounded-full overflow-hidden">
                            <div class="h-full bg-primary-600 rounded-full transition-all duration-500" style="width: {{ min(100, $program->persentase) }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs mt-1.5">
                            <span class="text-primary-700 font-semibold">Rp {{ number_format($program->terkumpul, 0, ',', '.') }}</span>
                            <span class="text-neutral-400">dari Rp {{ number_format($program->target, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif
                    <a href="{{ route('donasi.show', $program->slug) }}" class="block w-full text-center bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm">
                        Donasi Sekarang
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16">
                <svg class="w-12 h-12 text-neutral-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <p class="text-neutral-500 text-sm">Belum ada program donasi aktif.</p>
            </div>
            @endforelse
        </div>

        {{-- Info Rekening --}}
        <div class="bg-neutral-50 rounded-2xl border border-neutral-200 p-6 max-w-lg mx-auto text-center">
            <h3 class="font-bold text-neutral-900 mb-3">Informasi Rekening</h3>
            <div class="space-y-2 text-sm text-neutral-600">
                {!! nl2br(e(\App\Models\Setting::get('donasi_rekening', 'Hubungi sekretariat untuk informasi rekening donasi.'))) !!}
            </div>
            <p class="text-xs text-neutral-400 mt-4">Setelah transfer, simpan bukti dan konfirmasi ke sekretariat.</p>
        </div>
    </div>
</section>
@endsection
