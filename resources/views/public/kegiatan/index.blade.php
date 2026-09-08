@extends('layouts.public')

@section('title', 'Jadwal Kegiatan Islam — Masjid Grand Centerpoint Bekasi')
@section('meta_description', 'Jadwal lengkap kegiatan rutin dan program Islam di Masjid Grand Centerpoint Bekasi — kajian malam Jumat, Tahsin Al-Quran, TPA, yasinan, santunan, dan bakti sosial.')
@section('meta_keywords', 'jadwal kegiatan masjid bekasi, kajian islam bekasi, program masjid grand centerpoint, tahsin bekasi, TPA bekasi, yasinan bekasi')

@push('head')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {"@@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ url('/') }}"},
        {"@@type": "ListItem", "position": 2, "name": "Jadwal Kegiatan", "item": "{{ route('kegiatan.index') }}"}
    ]
}
</script>
@endpush

@section('content')

<section class="page-header">
    <div class="container-xl relative z-10">
        <div class="max-w-2xl mx-auto text-center">
            <span class="section-label" style="color: rgba(255,255,255,0.7);">PROGRAM MASJID</span>
            <h1 class="font-heading text-3xl sm:text-5xl font-bold leading-tight mt-2 mb-4" style="color: #ffffff;">Jadwal Kegiatan</h1>
            <p class="text-white/70 text-sm max-w-lg mx-auto">Jadwal lengkap kegiatan rutin dan program islami Masjid Grand Centerpoint Bekasi.</p>
            <nav class="flex items-center justify-center gap-2 mt-6 text-sm text-white/50">
                <a href="{{ route('home') }}" class="hover:text-white/80 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/80">Kegiatan</span>
            </nav>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-xl">

        {{-- Filter --}}
        <form method="GET" class="flex flex-wrap items-center gap-2 mb-8">
            <select name="kategori" class="w-full sm:flex-1 sm:min-w-0 px-3 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                <option value="{{ $kat->slug }}" {{ request('kategori') == $kat->slug ? 'selected' : '' }}>{{ $kat->nama }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full sm:w-auto shrink-0 bg-primary-600 hover:bg-primary-700 text-white px-3 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-medium transition-colors">Filter</button>
            <a href="{{ route('event.index') }}" class="w-full sm:w-auto shrink-0 inline-flex items-center justify-center gap-1.5 border border-primary-600 text-primary-600 hover:bg-primary-50 px-3 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-medium transition-colors sm:ml-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <span class="sm:hidden">Lihat Event</span>
                <span class="hidden sm:inline">Lihat Event Khusus</span>
            </a>
        </form>

        {{-- Kegiatan Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($kegiatans as $kegiatan)
            <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                <div class="p-5">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-16 rounded-xl bg-primary-600 flex flex-col items-center justify-center text-white shrink-0">
                            @if($kegiatan->jenis === 'rutin')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            @else
                            <span class="text-xs font-medium">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('M') }}</span>
                            <span class="text-xl font-bold leading-none">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d') }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="inline-block text-xs font-medium text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full mb-1">{{ $kegiatan->kategori->nama ?? 'Kegiatan' }}</span>
                            <h3 class="font-semibold text-neutral-900 text-sm leading-snug">{{ $kegiatan->judul }}</h3>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="flex items-center gap-1 text-xs text-neutral-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} WIB
                                </span>
                            </div>
                        </div>
                    </div>
                    @if($kegiatan->deskripsi)
                    <p class="text-xs text-neutral-500 mt-3 line-clamp-2">{{ $kegiatan->deskripsi }}</p>
                    @endif
                    @if($kegiatan->narasumber)
                    <div class="flex items-center gap-1.5 mt-3 text-xs text-neutral-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $kegiatan->narasumber }}
                    </div>
                    @endif
                    @if($kegiatan->lokasi)
                    <div class="flex items-center gap-1.5 mt-1.5 text-xs text-neutral-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $kegiatan->lokasi }}
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16">
                <svg class="w-12 h-12 text-neutral-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-neutral-500 text-sm">Belum ada jadwal kegiatan.</p>
            </div>
            @endforelse
        </div>

        @if($kegiatans->hasPages())
        <div class="mt-8 flex justify-center">{{ $kegiatans->links() }}</div>
        @endif
    </div>
</section>
@endsection
