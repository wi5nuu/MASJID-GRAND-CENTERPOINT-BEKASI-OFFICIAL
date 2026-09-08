@extends('layouts.public')

@section('title', 'Masjid Grand Centerpoint Bekasi — Masjid Modern di Jantung Bekasi')
@section('meta_description', 'Masjid Grand Centerpoint Bekasi — pusat ibadah, pendidikan Al-Quran, kajian Islam, dan kegiatan sosial di kawasan Apartemen Grand Centerpoint, Jalan Ahmad Yani, Bekasi, Jawa Barat.')
@section('meta_keywords', 'masjid bekasi, masjid grand centerpoint, masjid apartemen bekasi, kajian islam bekasi, TPA bekasi, jadwal shalat bekasi, masjid jawa barat, DKM grand centerpoint')

@section('content')

{{-- ============================================================
     HERO SECTION — 2 kolom
     ============================================================ --}}
<section class="bg-white section-padding">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">

            {{-- KOLOM KIRI (55%) --}}
            <div data-animate="fade-right">
                <span class="section-label">MASJID MODERN</span>

                <h1 class="font-heading text-3xl min-[420px]:text-4xl sm:text-5xl lg:text-[52px] font-bold text-neutral-800 leading-tight mb-3">
                    Masjid Grand<br>Centerpoint
                </h1>
                <h2 class="font-heading text-xl sm:text-2xl lg:text-3xl font-semibold text-primary-600 leading-tight mb-6">
                    Pusat Ibadah &amp; Kegiatan Umat
                </h2>

                @php $deskripsi = $profilMasjid->deskripsi ?? null; @endphp
                <p class="text-base text-neutral-500 leading-relaxed mb-8 max-w-lg" style="line-height: 1.7;">
                    {{ $deskripsi ?? 'Masjid Grand Centerpoint adalah masjid di dalam kawasan Apartemen GCP — tempat warga penghuni dan masyarakat sekitar berkumpul untuk ibadah, silaturahmi, dan kegiatan sosial. Terbuka untuk semua, ramai dikunjungi, dan nyata manfaatnya.' }}
                </p>

                <div class="flex flex-col min-[480px]:flex-row gap-3">
                    <a href="{{ route('kegiatan.index') }}" class="btn-primary w-full min-[480px]:w-auto">
                        Jelajahi Program
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('kontak') }}" class="btn-outline w-full min-[480px]:w-auto">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            {{-- KOLOM KANAN (45%) --}}
            <div data-animate="fade-left" data-delay="200" class="relative">
                @php $foto = $profilMasjid->foto ?? null; @endphp
                @if($foto)
                    <img src="{{ asset('storage/'.$foto) }}"
                         alt="Masjid Grand Centerpoint Bekasi"
                         class="w-full h-60 sm:h-80 lg:h-[480px] object-cover rounded-xl shadow-xl"
                         style="border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.12);">
                @else
                    <picture>
                        <source srcset="{{ asset('images/mosque/gcp_herosection.webp') }}" type="image/webp">
                        <img src="{{ asset('images/mosque/gcp_herosection.png') }}"
                             alt="Masjid Grand Centerpoint Bekasi"
                             class="w-full h-60 sm:h-80 lg:h-[480px] object-cover rounded-xl shadow-xl"
                             style="border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.12);">
                    </picture>
                @endif

                {{-- Floating badge --}}
                <div class="absolute -bottom-4 left-4 sm:-left-4 bg-white rounded-xl shadow-lg border border-neutral-100 px-5 py-4 text-center hidden sm:block">
                    <p class="text-3xl font-extrabold text-primary-600 font-heading">14+</p>
                    <p class="text-xs text-neutral-500 font-medium mt-0.5">Tahun Berdiri</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     STATS BAR — Bar horizontal putih
     ============================================================ --}}
<section class="stats-bar border-y border-neutral-200" data-animate="fade-up">
    <div class="container-xl">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-y-2 sm:gap-y-0 sm:divide-x sm:divide-neutral-200">
            @php
                $statsItems = [
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'value' => '400+', 'label' => 'Jamaah Aktif'],
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'value' => '8+', 'label' => 'Program Aktif'],
                    ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'value' => '3', 'label' => 'Kelurahan Terlayani'],
                    ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'value' => '150+', 'label' => 'Penerima Santunan/Th'],
                ];
            @endphp
            @foreach($statsItems as $stat)
            <div class="flex flex-col items-center justify-center px-4 sm:px-8 py-6 text-center min-w-0">
                <p class="text-2xl sm:text-3xl font-extrabold text-primary-600 font-heading leading-none">{{ $stat['value'] }}</p>
                <p class="text-xs text-neutral-500 mt-1.5 font-medium">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     PROGRAM / KEGIATAN SECTION
     ============================================================ --}}
<section class="section-padding bg-neutral-50">
    <div class="container-xl">
        <div class="text-center mb-12" data-animate="fade-up">
            <span class="section-label">PROGRAM KAMI</span>
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-neutral-800">Dibangun untuk Setiap Kebutuhan Umat</h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6">
            @if(isset($upcomingKegiatanList) && $upcomingKegiatanList->count() > 0)
                @foreach($upcomingKegiatanList->take(4) as $index => $kegiatan)
                <a href="{{ route('kegiatan.show', $kegiatan->slug ?? $kegiatan->id) }}" class="card group block" data-animate="fade-up" data-delay="{{ $index * 100 }}">
                    {{-- Gambar --}}
                    @if($kegiatan->thumbnail_url)
                    <div class="overflow-hidden relative" style="aspect-ratio: 5/4;">
                        <img src="{{ $kegiatan->thumbnail_url }}" alt="{{ $kegiatan->judul }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        {{-- Shadow biru dari bawah --}}
                        <div class="absolute bottom-0 left-0 right-0 h-24" style="background: linear-gradient(to top, rgba(29, 78, 216, 0.75) 0%, transparent 100%);"></div>
                    </div>
                    @else
                    <div class="overflow-hidden relative bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center" style="aspect-ratio: 5/4;">
                        <div class="icon-circle-lg">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                    </div>
                    @endif
                    <div class="p-3 sm:p-5">
                        <h3 class="font-heading font-bold text-neutral-800 text-sm leading-snug mb-1 group-hover:text-primary-600 transition-colors line-clamp-2">{{ $kegiatan->judul }}</h3>
                        @if($kegiatan->deskripsi)
                        <p class="text-xs text-neutral-500 line-clamp-2 mb-3">{{ $kegiatan->deskripsi }}</p>
                        @endif
                        <span class="text-xs font-semibold text-primary-600 flex items-center gap-1 group-hover:gap-2 transition-all">
                            Selengkapnya
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
                @endforeach
            @else
                @foreach([
                    ['nama' => 'Kajian Malam Jumat', 'desc' => 'Kajian rutin setiap Kamis malam untuk seluruh jamaah.'],
                    ['nama' => 'Tahsin & TPA', 'desc' => 'Belajar baca Al-Quran untuk anak-anak dan dewasa.'],
                    ['nama' => 'Yasinan & Makan Bersama', 'desc' => 'Kegiatan yasinan rutin diikuti seluruh warga.'],
                    ['nama' => 'Santunan Anak Yatim', 'desc' => 'Program sosial tahunan menyentuh 150–200 penerima.'],
                ] as $i => $item)
                <a href="{{ route('kegiatan.index') }}" class="card hover:border-primary-300 hover:shadow-md transition-all" data-animate="fade-up" data-delay="{{ $i * 100 }}">
                    <div class="aspect-video bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center">
                        <div class="icon-circle-lg">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                        </div>
                    </div>
                    <div class="p-3 sm:p-5">
                        <div class="icon-circle mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13"/></svg>
                        </div>
                        <h3 class="font-heading font-bold text-neutral-800 text-sm mb-1">{{ $item['nama'] }}</h3>
                        <p class="text-xs text-neutral-500 mb-3">{{ $item['desc'] }}</p>
                        <span class="text-xs font-semibold text-primary-600">Selengkapnya →</span>
                    </div>
                </a>
                @endforeach
            @endif
        </div>

        <div class="text-center mt-10" data-animate="fade-up" data-delay="400">
            <a href="{{ route('kegiatan.index') }}" class="btn-outline">
                Lihat Semua Program
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     BLUE BANNER — Keunggulan kami
     ============================================================ --}}
<section class="section-padding" style="background: linear-gradient(135deg, #1a3a6b 0%, #1e40af 60%, #2563eb 100%);">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">

            {{-- Kiri: Gambar --}}
            <div data-animate="fade-right" class="relative rounded-xl overflow-hidden shadow-2xl">
                @if(isset($foto) && $foto)
                <img src="{{ asset('storage/'.$foto) }}" alt="Kegiatan Masjid"
                     class="w-full h-56 sm:h-72 lg:h-96 object-cover">
                @else
                <picture>
                    <source srcset="{{ asset('images/mosque/pengurusdkm.webp') }}" type="image/webp">
                    <img src="{{ asset('images/mosque/pengurusdkm.png') }}"
                         alt="Pengurus DKM Masjid Grand Centerpoint Bekasi"
                         class="w-full h-56 sm:h-72 lg:h-96 object-cover">
                </picture>
                @endif
                {{-- Shadow biru dari bawah --}}
                <div class="absolute bottom-0 left-0 right-0 h-32" style="background: linear-gradient(to top, rgba(29, 78, 216, 0.75) 0%, transparent 100%);"></div>
            </div>

            {{-- Kanan: Stats --}}
            <div data-animate="fade-left" data-delay="200">
                <span class="section-label" style="color: rgba(255,255,255,0.7);">KEUNGGULAN KAMI</span>
<h2 class="font-heading text-3xl sm:text-4xl font-bold leading-tight mt-2 mb-3" style="color: #ffffff;">
    Aktif. Inklusif.<br>Nyata Manfaatnya.
</h2>
<p class="text-base leading-relaxed mb-8" style="color: rgba(255,255,255,0.7);">
    Masjid yang tumbuh bersama warganya — dari ibadah harian, pendidikan Al-Quran, hingga kepedulian sosial yang menyentuh langsung kehidupan jamaah.
</p>

                <div class="grid grid-cols-1 min-[480px]:grid-cols-2 gap-5 sm:gap-6">
                    @foreach([
                        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'value' => '400+', 'label' => 'Jamaah Aktif'],
                        ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'value' => '150+', 'label' => 'Penerima Santunan/Th'],
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'value' => '13', 'label' => 'Pengurus DKM'],
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'value' => '3', 'label' => 'Kelurahan Terlayani'],
                    ] as $item)
                    <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                        <div class="icon-circle-white shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-white font-heading">{{ $item['value'] }}</p>
                            <p class="text-xs text-white/70 mt-0.5">{{ $item['label'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


        </div>
    </div>
</section>

{{-- ============================================================
     HOW IT WORKS — Alur Kegiatan
     ============================================================ --}}
<section class="section-padding bg-white">
    <div class="container-xl">
        <div class="text-center mb-14" data-animate="fade-up">
            <span class="section-label">ALUR KEGIATAN</span>
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-neutral-800">Cara Kami Melayani Umat</h2>
        </div>

        {{-- Steps desktop --}}
        <div class="hidden lg:grid grid-cols-5 gap-0 relative">
            @php
                $steps = [
                    ['num' => 1, 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'title' => 'Daftar', 'desc' => 'Daftarkan diri Anda sebagai jamaah resmi masjid'],
                    ['num' => 2, 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13', 'title' => 'Ikuti Program', 'desc' => 'Pilih dan ikuti program sesuai kebutuhan Anda'],
                    ['num' => 3, 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Berpartisipasi', 'desc' => 'Aktif berpartisipasi dalam kegiatan masjid'],
                    ['num' => 4, 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Berkontribusi', 'desc' => 'Berkontribusi melalui waktu, tenaga, atau donasi'],
                    ['num' => 5, 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'title' => 'Nikmati Manfaat', 'desc' => 'Rasakan manfaat nyata bagi diri dan keluarga'],
                ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="relative flex flex-col items-center text-center px-4" data-animate="fade-up" data-delay="{{ $i * 100 }}">
                {{-- Connector line --}}
                @if($i < count($steps) - 1)
                <div class="step-connector" style="top: 32px;"></div>
                @endif

                {{-- Circle --}}
                <div class="relative z-10 w-16 h-16 rounded-full bg-primary-600 flex items-center justify-center shadow-lg mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/></svg>
                    <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-white border-2 border-primary-600 text-primary-700 text-xs font-bold flex items-center justify-center">{{ $step['num'] }}</span>
                </div>

                <h3 class="font-heading font-bold text-neutral-800 text-sm mb-2">{{ $step['title'] }}</h3>
                <p class="text-xs text-neutral-500 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Steps mobile — vertical timeline --}}
        <div class="lg:hidden space-y-6">
            @foreach($steps as $step)
            <div class="flex items-start gap-4" data-animate="fade-up">
                <div class="relative flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/></svg>
                    </div>
                    <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-white border-2 border-primary-600 text-primary-700 text-xs font-bold flex items-center justify-center">{{ $step['num'] }}</span>
                </div>
                <div class="pt-2">
                    <h3 class="font-heading font-bold text-neutral-800 text-sm mb-1">{{ $step['title'] }}</h3>
                    <p class="text-xs text-neutral-500">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     KEGIATAN TERBARU
     ============================================================ --}}
<section class="section-padding bg-neutral-50">
    <div class="container-xl">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10" data-animate="fade-up">
            <div>
                <span class="section-label">KEGIATAN TERBARU</span>
                <h2 class="font-heading text-3xl sm:text-4xl font-bold text-neutral-800">Kegiatan Nyata. Hasil Nyata.</h2>
            </div>
            <a href="{{ route('event.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-1.5 shrink-0 transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(isset($latestKegiatan) && $latestKegiatan->count() > 0)
                @foreach($latestKegiatan->take(3) as $i => $kegiatan)
                <a href="{{ route('kegiatan.show', $kegiatan->slug ?? $kegiatan->id) }}" class="card group block" data-animate="fade-up" data-delay="{{ $i * 150 }}">
                    @if($kegiatan->thumbnail_url)
                    <div class="aspect-video overflow-hidden relative">
                        <img src="{{ $kegiatan->thumbnail_url }}" alt="{{ $kegiatan->judul }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute bottom-0 left-0 right-0 h-16" style="background: linear-gradient(to top, rgba(29, 78, 216, 0.75) 0%, transparent 100%);"></div>
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="badge-blue">{{ $kegiatan->kategori->nama ?? 'Kegiatan' }}</span>
                            <span class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->locale('id')->isoFormat('D MMM Y') }}</span>
                        </div>
                        <h3 class="font-heading font-bold text-neutral-800 text-sm leading-snug group-hover:text-primary-600 transition-colors line-clamp-2 mb-2">{{ $kegiatan->judul }}</h3>
                        @if($kegiatan->lokasi)
                        <p class="text-xs text-neutral-400 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $kegiatan->lokasi }}
                        </p>
                        @endif
                    </div>
                </a>
                @endforeach
            @else
                @foreach(['Kajian Ramadhan', 'Kajian Ibu-Ibu', 'Bakti Sosial'] as $i => $nama)
                <div class="card" data-animate="fade-up" data-delay="{{ $i * 150 }}">
                    <div class="aspect-video bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="p-5">
                        <span class="badge-blue mb-3 inline-block">Kegiatan</span>
                        <h3 class="font-heading font-bold text-neutral-800 text-sm mb-1">{{ $nama }}</h3>
                        <p class="text-xs text-neutral-400">Masjid Grand Centerpoint</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- ============================================================
     CTA + FAQ SECTION — 2 kolom
     ============================================================ --}}
<section class="section-padding bg-white">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            {{-- KOLOM KIRI: CTA biru solid --}}
            <div class="rounded-2xl p-6 sm:p-8 lg:p-10 flex flex-col justify-center" style="background: linear-gradient(135deg, #1a3a6b 0%, #2563eb 100%);" data-animate="fade-right">
                <h3 class="font-heading text-2xl sm:text-3xl font-bold leading-tight mb-4" style="color: #ffffff;">
                    Siap Berkontribusi<br>untuk Masjid?
                </h3>
                <p class="text-white/80 text-sm leading-relaxed mb-8" style="line-height: 1.7;">
                    Donasi Anda membantu kami menjalankan program dakwah, pendidikan, dan pelayanan umat. Setiap rupiah adalah investasi akhirat yang nyata.
                </p>
                <a href="{{ route('donasi.index') }}" class="btn-white self-start">
                    Donasi Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- KOLOM KANAN: FAQ --}}
            <div data-animate="fade-left" data-delay="200">
                <span class="section-label">FAQ</span>
                <h3 class="font-heading text-2xl sm:text-3xl font-bold text-neutral-800 mb-6">Pertanyaan yang Sering Diajukan</h3>

                <div x-data="{ open: 0 }">
                    @php
                        $faqs = [
                            ['q' => 'Apa saja program rutin di masjid ini?', 'a' => 'Program rutin kami antara lain: kajian malam Jumat, yasinan & makan bersama, Jumat Barokah, Tahsin & TPA untuk anak-anak, maulid nabi, akikah, santunan anak yatim, kurban, dan zakat fitrah. Cek halaman Kegiatan untuk jadwal lengkap.'],
                            ['q' => 'Di mana lokasi Masjid Grand Centerpoint?', 'a' => 'Kami berlokasi di GRAND Centerpoint Tower C & D, Jalan Ahmad Yani Sentra Niaga Kalimalang A3.2, Kayuringinjaya, Jawa Barat.'],
                            ['q' => 'Bagaimana cara berdonasi untuk masjid?', 'a' => 'Anda dapat berdonasi melalui transfer bank atau datang langsung ke sekretariat DKM. Klik tombol "Donasi Sekarang" untuk informasi rekening dan nominal yang dibutuhkan.'],
                            ['q' => 'Siapa yang mengelola masjid ini?', 'a' => 'Masjid dikelola oleh Dewan Kemakmuran Masjid (DKM) dengan 13 pengurus aktif. Ketua DKM adalah Bapak Agus Supriyono dan Pembina adalah Bapak Aji Ali Sabana.'],
                            ['q' => 'Apakah non-Muslim boleh ikut kegiatan?', 'a' => 'Semangat toleransi adalah ciri khas kami. Warga non-Muslim di lingkungan Grand Centerpoint bahkan turut membantu kegiatan masjid — sebuah ukhuwah yang kami jaga dengan bangga.'],
                        ];
                    @endphp

                    @foreach($faqs as $i => $faq)
                    <div class="faq-item">
                        <button class="faq-trigger" @click="open = open === {{ $i }} ? null : {{ $i }}" :aria-expanded="open === {{ $i }}">
                            <span>{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-primary-600 shrink-0 transition-transform duration-200" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="faq-content" :class="open === {{ $i }} ? 'open' : ''">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     GALERI SECTION
     ============================================================ --}}
@if(isset($latestGaleri) && $latestGaleri->count() > 0)
<section class="section-padding bg-neutral-50">
    <div class="container-xl">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10" data-animate="fade-up">
            <div>
                <span class="section-label">DOKUMENTASI</span>
                <h2 class="font-heading text-3xl font-bold text-neutral-800">Galeri Masjid</h2>
            </div>
            <a href="{{ route('galeri.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-1.5 shrink-0 transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($latestGaleri->take(8) as $i => $galeri)
            <a href="{{ route('galeri.index') }}#galeri-{{ $galeri->id }}" class="group relative aspect-square overflow-hidden rounded-xl bg-neutral-200" data-animate="scale" data-delay="{{ ($i % 4) * 100 }}"
               style="border-radius: 12px;">
                <img src="{{ asset('storage/'.$galeri->file) }}" alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                     loading="lazy">
                <div class="absolute bottom-0 left-0 right-0 h-24 flex items-end p-3" style="background: linear-gradient(to top, rgba(29, 78, 216, 0.75) 0%, transparent 100%); z-index: 10;">
                    @if($galeri->keterangan)
                    <p class="text-white text-xs font-medium line-clamp-2">{{ $galeri->keterangan }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     LOKASI SECTION
     ============================================================ --}}
<section class="section-padding bg-white">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
            <div data-animate="fade-right">
                <span class="section-label">LOKASI KAMI</span>
                <h2 class="font-heading text-3xl font-bold text-neutral-800 mb-6">Temukan Masjid Kami</h2>

                <div class="space-y-4 mb-8">
                    @foreach([
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Alamat', 'value' => 'GRAND Centerpoint Tower C & D, Jalan Ahmad Yani Sentra Niaga Kalimalang A3.2, Kayuringinjaya, Jawa Barat'],
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Jam Operasional', 'value' => 'Buka 24 jam — Sekretariat: 08.00–17.00 WIB'],
                        ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'label' => 'Telepon', 'value' => '+62 21 1234 5678'],
                    ] as $info)
                    <div class="flex items-start gap-4 p-4 bg-neutral-50 rounded-xl border border-neutral-200 hover:border-primary-200 transition-colors">
                        <div class="icon-circle shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-1">{{ $info['label'] }}</p>
                            <p class="text-sm text-neutral-700 font-medium leading-relaxed">{{ $info['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="https://maps.google.com/?q=Grand+Centerpoint+Bekasi" target="_blank" rel="noopener" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Buka Google Maps
                </a>
            </div>

            <div class="rounded-xl overflow-hidden shadow-lg h-64 sm:h-80 lg:h-96 border border-neutral-200" data-animate="fade-left" data-delay="200" style="border-radius: 12px;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.99218031476878!3d-6.208763395493066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMzEuNiJTIDEwNsKwNTknMjMuMiJF!5e0!3m2!1sen!2sid!4v1234567890"
                    class="w-full h-full border-0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Masjid Grand Centerpoint Bekasi">
                </iframe>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// FAQ accordion handled by Alpine.js - no vanilla JS needed
</script>
@endpush
