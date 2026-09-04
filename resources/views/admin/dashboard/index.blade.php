@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Dashboard</span>
@endsection

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-xl font-bold text-neutral-900">Dashboard</h1>
    <p class="text-sm text-neutral-500 mt-1">
        Selamat datang kembali, <span class="font-medium text-neutral-700">{{ auth()->user()->name ?? 'Admin' }}</span>.
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
    </p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
        $statCards = [
            ['label'=>'Total Berita', 'value'=> $stats['berita'] ?? 0, 'change'=>'+3 bulan ini', 'positive'=>true, 'color'=>'primary', 'icon'=>'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
            ['label'=>'Total Kegiatan', 'value'=> $stats['kegiatan'] ?? 0, 'change'=>'Aktif bulan ini', 'positive'=>true, 'color'=>'primary', 'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['label'=>'Total Donasi', 'value'=> 'Rp '.number_format($stats['donasi'] ?? 0, 0, ',', '.'), 'change'=>'Bulan ini', 'positive'=>true, 'color'=>'gold', 'icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
            ['label'=>'Total Jamaah', 'value'=> $stats['users'] ?? 0, 'change'=>'Pengguna terdaftar', 'positive'=>true, 'color'=>'primary', 'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ];
    @endphp
    @foreach($statCards as $card)
    <div class="bg-white rounded-2xl border border-neutral-200 p-5">
        <div class="flex items-start justify-between mb-3">
            <div class="w-9 h-9 rounded-xl {{ $card['color'] === 'gold' ? 'bg-gold-100' : 'bg-primary-100' }} flex items-center justify-center">
                <svg class="w-4 h-4 {{ $card['color'] === 'gold' ? 'text-gold-600' : 'text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
        </div>
        <p class="text-xl font-bold text-neutral-900 mb-0.5">{{ $card['value'] }}</p>
        <p class="text-xs text-neutral-400">{{ $card['label'] }}</p>
        <p class="text-xs {{ $card['positive'] ? 'text-primary-600' : 'text-red-500' }} mt-1 font-medium">{{ $card['change'] }}</p>
    </div>
    @endforeach
</div>

{{-- Main Content Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Left: Kegiatan Hari Ini --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Jadwal Shalat Hari Ini --}}
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl p-5 text-white">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold">Jadwal Shalat Hari Ini</h2>
                <a href="{{ route('admin.shalat.index') }}" class="text-primary-200 hover:text-white text-xs transition-colors">Edit</a>
            </div>
            <div class="grid grid-cols-5 gap-2">
                @php
                    $shalatList = $prayerTimes ?? [
                        ['name' => 'Subuh', 'time' => '04:45'],
                        ['name' => 'Dzuhur', 'time' => '12:00'],
                        ['name' => 'Ashar', 'time' => '15:15'],
                        ['name' => 'Maghrib', 'time' => '18:02'],
                        ['name' => 'Isya', 'time' => '19:15'],
                    ];
                @endphp
                @foreach($shalatList as $shalat)
                <div class="text-center bg-white/10 rounded-xl py-3 px-1">
                    <p class="text-primary-200 text-xs mb-0.5">{{ is_array($shalat) ? $shalat['name'] : $shalat->name }}</p>
                    <p class="text-white font-bold text-sm">{{ is_array($shalat) ? $shalat['time'] : $shalat->time }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Berita --}}
        <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100">
                <h2 class="font-semibold text-neutral-900 text-sm">Berita Terbaru</h2>
                <a href="{{ route('admin.berita.create') }}" class="inline-flex items-center gap-1 text-xs font-medium text-primary-600 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </a>
            </div>
            <div class="divide-y divide-neutral-50">
                @forelse($recentBerita ?? [] as $berita)
                <div class="flex items-center gap-3 px-5 py-3">
                    <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-neutral-900 truncate">{{ $berita->judul }}</p>
                        <p class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($berita->created_at)->locale('id')->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $berita->status === 'published' ? 'bg-primary-50 text-primary-700' : 'bg-neutral-100 text-neutral-500' }}">
                        {{ $berita->status === 'published' ? 'Tayang' : 'Draft' }}
                    </span>
                </div>
                @empty
                @for($i = 0; $i < 4; $i++)
                <div class="flex items-center gap-3 px-5 py-3">
                    <div class="w-8 h-8 rounded-lg skeleton"></div>
                    <div class="flex-1 space-y-1.5">
                        <div class="h-3 skeleton rounded w-3/4"></div>
                        <div class="h-2.5 skeleton rounded w-1/3"></div>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>
        </div>

        {{-- Donasi Terbaru --}}
        <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100">
                <h2 class="font-semibold text-neutral-900 text-sm">Donasi Terbaru</h2>
                <a href="{{ route('admin.donasi.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Lihat Semua</a>
            </div>
            <div class="divide-y divide-neutral-50">
                @forelse($recentDonasi ?? [] as $donasi)
                <div class="flex items-center gap-3 px-5 py-3">
                    <div class="w-8 h-8 rounded-full bg-gold-100 flex items-center justify-center shrink-0">
                        <span class="text-gold-700 text-xs font-bold">{{ strtoupper(substr($donasi->nama ?? 'H', 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-neutral-900 truncate">{{ $donasi->nama ?? 'Hamba Allah' }}</p>
                        <p class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($donasi->created_at)->locale('id')->diffForHumans() }}</p>
                    </div>
                    <span class="text-sm font-semibold text-primary-700">Rp {{ number_format($donasi->jumlah ?? 0, 0, ',', '.') }}</span>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-xs text-neutral-400">Belum ada donasi terbaru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div class="space-y-5">

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl border border-neutral-200 p-5">
            <h2 class="font-semibold text-neutral-900 text-sm mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-2 gap-2">
                @php
                    $quickActions = [
                        ['label'=>'Tulis Berita', 'href'=>route('admin.berita.create'), 'icon'=>'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                        ['label'=>'Tambah Kegiatan', 'href'=>route('admin.kegiatan.create'), 'icon'=>'M12 4v16m8-8H4'],
                        ['label'=>'Upload Foto', 'href'=>route('admin.galeri.create'), 'icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['label'=>'TV Display', 'href'=>route('admin.tv.index'), 'icon'=>'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ];
                @endphp
                @foreach($quickActions as $action)
                <a href="{{ $action['href'] }}" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 hover:text-primary-700 transition-colors text-neutral-600 group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/></svg>
                    <span class="text-xs font-medium text-center leading-tight">{{ $action['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Kegiatan Hari Ini --}}
        <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100">
                <h2 class="font-semibold text-neutral-900 text-sm">Kegiatan Hari Ini</h2>
                <a href="{{ route('admin.kegiatan.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Semua</a>
            </div>
            <div class="p-4 space-y-2">
                @forelse($todayKegiatanList ?? [] as $kegiatan)
                <div class="flex items-start gap-3 p-3 rounded-xl bg-neutral-50">
                    <div class="w-1 h-full min-h-8 rounded-full bg-primary-500 shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-neutral-900 truncate">{{ $kegiatan->judul }}</p>
                        <p class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} WIB</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <svg class="w-8 h-8 text-neutral-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-xs text-neutral-400">Tidak ada kegiatan hari ini</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Info Sistem --}}
        <div class="bg-white rounded-2xl border border-neutral-200 p-5">
            <h2 class="font-semibold text-neutral-900 text-sm mb-3">Info Sistem</h2>
            <div class="space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-neutral-500">PHP</span>
                    <span class="font-medium text-neutral-700">{{ phpversion() }}</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-neutral-500">Laravel</span>
                    <span class="font-medium text-neutral-700">{{ app()->version() }}</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-neutral-500">Status Website</span>
                    <span class="inline-flex items-center gap-1 text-primary-700 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                        Online
                    </span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-neutral-500">Environment</span>
                    <span class="font-medium text-neutral-700">{{ app()->environment() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
