@extends('layouts.public')

@section('title', $kegiatan->judul . ' — Jadwal Kegiatan Masjid Grand Centerpoint Bekasi')
@section('meta_description', Str::limit(strip_tags($kegiatan->deskripsi ?? 'Kegiatan Islam di Masjid Grand Centerpoint Bekasi — pusat ibadah dan kegiatan umat di Bekasi, Jawa Barat.'), 160))
@section('og_title', $kegiatan->judul . ' — Masjid Grand Centerpoint Bekasi')
@section('og_description', Str::limit(strip_tags($kegiatan->deskripsi ?? ''), 160))
@section('og_image', $kegiatan->thumbnail_url ?? asset('images/mosque/gcp_herosection.png'))

@push('head')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Event",
    "name": "{{ $kegiatan->judul }}",
    "description": "{{ Str::limit(strip_tags($kegiatan->deskripsi ?? ''), 200) }}",
    "startDate": "{{ $kegiatan->tanggal?->format('Y-m-d') }}T{{ $kegiatan->waktu_mulai ?? '00:00' }}",
    @if($kegiatan->waktu_selesai)
    "endDate": "{{ $kegiatan->tanggal?->format('Y-m-d') }}T{{ $kegiatan->waktu_selesai }}",
    @endif
    "location": {
        "@@type": "Place",
        "name": "{{ $kegiatan->lokasi ?? 'Masjid Grand Centerpoint Bekasi' }}",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "GRAND Centerpoint Tower C & D, Jalan Ahmad Yani Sentra Niaga Kalimalang A3.2",
            "addressLocality": "Bekasi",
            "addressRegion": "Jawa Barat",
            "addressCountry": "ID"
        }
    },
    "organizer": {
        "@@type": "Organization",
        "name": "DKM Masjid Grand Centerpoint Bekasi",
        "url": "{{ url('/') }}"
    },
    "eventStatus": "https://schema.org/EventScheduled",
    "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
    "isAccessibleForFree": true,
    "url": "{{ url()->current() }}"
    @if($kegiatan->thumbnail_url)
    ,"image": "{{ $kegiatan->thumbnail_url }}"
    @endif
}
</script>
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {"@@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ url('/') }}"},
        {"@@type": "ListItem", "position": 2, "name": "Kegiatan", "item": "{{ route('kegiatan.index') }}"},
        {"@@type": "ListItem", "position": 3, "name": "{{ $kegiatan->judul }}", "item": "{{ url()->current() }}"}
    ]
}
</script>
@endpush

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-primary-800 to-primary-900 relative overflow-hidden py-14">
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-primary-300 text-xs mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors shrink-0">Beranda</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('kegiatan.index') }}" class="hover:text-white transition-colors shrink-0">Kegiatan</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white min-w-0 truncate">{{ Str::limit($kegiatan->judul, 40) }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold max-w-3xl mb-3" style="color: #ffffff;">{{ $kegiatan->judul }}</h1>
        @if($kegiatan->deskripsi)
        <p class="text-primary-200 text-sm sm:text-base max-w-2xl leading-relaxed">{{ Str::limit(strip_tags($kegiatan->deskripsi), 180) }}</p>
        @endif
    </div>
</section>

{{-- Content --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main --}}
            <div class="lg:col-span-2">
                @if($kegiatan->thumbnail_url)
                <div class="overflow-hidden rounded-2xl" style="aspect-ratio: 16/9;">
                    <img src="{{ $kegiatan->thumbnail_url }}" alt="{{ $kegiatan->judul }}"
                        class="w-full h-full object-cover">
                </div>
                @endif
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
