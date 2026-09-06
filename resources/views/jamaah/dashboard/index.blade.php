@extends('layouts.jamaah')

@section('title', 'Dashboard Jamaah — Masjid Grand Centerpoint Bekasi')

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-xl font-bold text-neutral-900">Assalamu'alaikum, {{ $user->name }}</h1>
    <p class="text-sm text-neutral-500 mt-1 flex items-center gap-2">
        @if($user->unit_no)
        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-primary-100 text-primary-700 rounded-full text-xs font-semibold">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Unit {{ $user->unit_no }}
        </span>
        @endif
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
    </p>
</div>

{{-- Jadwal Shalat Hari Ini --}}
<div class="bg-white rounded-2xl border border-neutral-200 p-5 mb-6">
    <h2 class="text-sm font-semibold text-neutral-700 mb-3 flex items-center gap-2">
        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Jadwal Shalat Hari Ini
    </h2>
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
        @foreach($prayerTimes as $pt)
        <div class="text-center p-2 rounded-xl bg-primary-50">
            <p class="text-xs text-primary-600 font-medium">{{ $pt['name'] }}</p>
            <p class="text-sm font-bold text-primary-800">{{ $pt['time'] }}</p>
        </div>
        @endforeach
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Kegiatan Hari Ini --}}
    <div class="bg-white rounded-2xl border border-neutral-200 p-5">
        <h2 class="text-sm font-semibold text-neutral-700 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Kegiatan Hari Ini
        </h2>
        @forelse($todayKegiatan as $kg)
        <div class="flex items-center gap-3 p-3 rounded-xl bg-neutral-50 mb-2 last:mb-0">
            <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                <span class="text-xs font-bold text-primary-700">{{ \Carbon\Carbon::parse($kg->waktu_mulai)->format('H:i') }}</span>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-neutral-800 truncate">{{ $kg->judul }}</p>
                <p class="text-xs text-neutral-500">{{ $kg->lokasi ?? 'Masjid GCP' }}</p>
            </div>
        </div>
        @empty
        <p class="text-sm text-neutral-400 text-center py-4">Tidak ada kegiatan hari ini.</p>
        @endforelse

        @if($upcomingKegiatan->isNotEmpty())
        <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide mt-5 mb-2">Segera Hadir</p>
        @foreach($upcomingKegiatan as $kg)
        <a href="{{ route('kegiatan.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors mb-2 last:mb-0">
            <div class="w-10 h-10 rounded-lg bg-white border border-neutral-200 flex flex-col items-center justify-center shrink-0">
                <span class="text-sm font-bold text-primary-700 leading-none">{{ \Carbon\Carbon::parse($kg->tanggal)->format('d') }}</span>
                <span class="text-[10px] text-neutral-400 leading-none mt-0.5">{{ \Carbon\Carbon::parse($kg->tanggal)->locale('id')->isoFormat('MMM') }}</span>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-neutral-800 truncate">{{ $kg->judul }}</p>
                <p class="text-xs text-neutral-500">{{ \Carbon\Carbon::parse($kg->tanggal)->locale('id')->isoFormat('dddd') }}{{ $kg->waktu_mulai ? ' · '.\Carbon\Carbon::parse($kg->waktu_mulai)->format('H:i').' WIB' : '' }}</p>
            </div>
        </a>
        @endforeach
        @endif
    </div>

    {{-- Berita Terbaru --}}
    <div class="bg-white rounded-2xl border border-neutral-200 p-5">
        <h2 class="text-sm font-semibold text-neutral-700 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            Berita Terbaru
        </h2>
        @forelse($recentBerita as $berita)
        <a href="{{ route('berita.show', $berita->slug) }}" class="block p-3 rounded-xl hover:bg-neutral-50 transition-colors mb-2 last:mb-0">
            <p class="text-sm font-medium text-neutral-800 line-clamp-1">{{ $berita->judul }}</p>
            <p class="text-xs text-neutral-500 mt-0.5">{{ $berita->created_at?->locale('id')->diffForHumans() }}</p>
        </a>
        @empty
        <p class="text-sm text-neutral-400 text-center py-4">Belum ada berita.</p>
        @endforelse
    </div>

</div>

{{-- Program Donasi --}}
@if($donasiPrograms->isNotEmpty())
<div class="bg-white rounded-2xl border border-neutral-200 p-5 mt-6">
    <h2 class="text-sm font-semibold text-neutral-700 mb-3 flex items-center gap-2">
        <svg class="w-4 h-4 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        Program Donasi Aktif
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        @foreach($donasiPrograms as $prog)
        <a href="{{ route('donasi.show', $prog->slug) }}" class="block p-4 rounded-xl bg-neutral-50 hover:bg-primary-50 hover:shadow-md transition-all">
            <p class="text-sm font-medium text-neutral-800 mb-1">{{ $prog->nama }}</p>
            <div class="w-full bg-neutral-200 rounded-full h-2 mb-2">
                <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $prog->persentase }}%"></div>
            </div>
            <p class="text-xs text-neutral-500">Rp {{ number_format($prog->terkumpul, 0, ',', '.') }} / Rp {{ number_format($prog->target, 0, ',', '.') }}</p>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection
