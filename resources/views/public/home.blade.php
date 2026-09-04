@extends('layouts.public')

@section('title', 'Beranda — Masjid Grand Centerpoint Bekasi')
@section('meta_description', 'Selamat datang di Masjid Grand Centerpoint Bekasi. Pusat ibadah, pendidikan Islam, dan kegiatan kemasyarakatan di Bekasi.')

@section('content')

{{-- HERO SECTION --}}
<section class="relative overflow-hidden" style="background-color: #0f3d2e;">
    {{-- Background photo --}}
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('bg_hero_section.png') }}');"></div>
    {{-- Dark overlay agar teks terbaca --}}
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/85 via-primary-800/75 to-primary-900/80"></div>
    {{-- Geometric pattern overlay --}}
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    {{-- Bottom fade --}}
    <div class="absolute inset-0 bg-gradient-to-t from-primary-900/70 via-transparent to-transparent"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="max-w-3xl">
            {{-- Arabic bismillah --}}
            <p class="font-arabic text-2xl sm:text-3xl text-gold-300 mb-3 text-center sm:text-left" dir="rtl">
                بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
            </p>
            <div class="divider-islamic mb-6 sm:hidden">
                <span class="text-xs text-primary-300">Masjid Grand Centerpoint Bekasi</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
                Selamat Datang di<br>
                <span class="text-gold-300">Masjid Grand Centerpoint</span><br>
                Bekasi
            </h1>
            <p class="text-primary-100 text-base sm:text-lg leading-relaxed mb-8 max-w-xl">
                Pusat ibadah, pendidikan Islam, dan kegiatan kemasyarakatan yang melayani umat di kawasan Grand Centerpoint Bekasi dan sekitarnya.
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center justify-center gap-2 bg-white text-primary-700 hover:bg-primary-50 font-semibold px-6 py-3 rounded-xl transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Jadwal Kegiatan
                </a>
                <a href="{{ route('donasi.index') }}" class="inline-flex items-center justify-center gap-2 bg-gold-500 hover:bg-gold-600 text-white font-semibold px-6 py-3 rounded-xl transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Donasi Sekarang
                </a>
            </div>
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 60L1440 60L1440 30C1200 60 960 0 720 30C480 60 240 0 0 30L0 60Z" fill="white"/>
        </svg>
    </div>
</section>

{{-- JADWAL SHALAT --}}
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl overflow-hidden shadow-lg">
            <div class="px-6 py-5">
                <div class="flex flex-col lg:flex-row items-center gap-6">
                    {{-- Title + date --}}
                    <div class="text-center lg:text-left lg:w-48 shrink-0">
                        <p class="text-primary-200 text-xs font-medium uppercase tracking-wider mb-1">Jadwal Shalat</p>
                        <p class="text-white font-bold text-base">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                        @php
                            $hijri = ''; // Will be populated from DB settings
                        @endphp
                    </div>

                    {{-- Prayer times grid --}}
                    <div class="flex-1 grid grid-cols-3 sm:grid-cols-5 gap-3 w-full">
                        @php
                            $prayers = $prayerTimes ?? [
                                ['name' => 'Subuh', 'time' => '04:45'],
                                ['name' => 'Dzuhur', 'time' => '12:00'],
                                ['name' => 'Ashar', 'time' => '15:15'],
                                ['name' => 'Maghrib', 'time' => '18:02'],
                                ['name' => 'Isya', 'time' => '19:15'],
                            ];
                        @endphp
                        @foreach($prayers as $prayer)
                        <div class="text-center bg-white/10 rounded-xl px-3 py-3 {{ isset($prayer['is_active']) && $prayer['is_active'] ? 'ring-2 ring-gold-400' : '' }}">
                            <p class="text-primary-200 text-xs mb-1">{{ is_array($prayer) ? $prayer['name'] : $prayer->name }}</p>
                            <p class="text-white font-bold text-base">{{ is_array($prayer) ? $prayer['time'] : $prayer->time }}</p>
                            @if(isset($prayer['is_active']) && $prayer['is_active'])
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-gold-400 mt-1"></span>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    {{-- Countdown --}}
                    <div class="text-center lg:w-40 shrink-0" x-data="prayerCountdown()">
                        <p class="text-primary-200 text-xs font-medium mb-1">Menuju</p>
                        <p class="text-white font-bold text-sm" x-text="nextPrayer"></p>
                        <p class="text-gold-300 font-mono text-xl font-bold" x-text="countdown">--:--:--</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATISTIK MASJID --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @php
                $stats = [
                    ['label' => 'Jamaah Aktif', 'value' => '2.500+', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label' => 'Program Kegiatan', 'value' => '45+', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['label' => 'Tahun Berdiri', 'value' => '2010', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['label' => 'Kajian Per Bulan', 'value' => '20+', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="text-center p-5 rounded-2xl bg-primary-50 border border-primary-100">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-primary-700 mb-1">{{ $stat['value'] }}</p>
                <p class="text-sm text-neutral-500">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- KEGIATAN TERBARU --}}
<section class="py-14 bg-neutral-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-10">
            <span class="section-badge mb-3">Kegiatan Kami</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-3">Jadwal Kegiatan Mendatang</h2>
            <p class="text-neutral-500 max-w-xl mx-auto text-sm">Ikuti berbagai program ibadah, kajian, dan kegiatan sosial yang kami selenggarakan untuk jamaah.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($upcomingKegiatanList ?? [] as $kegiatan)
            <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                <div class="p-5">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-14 rounded-xl bg-primary-600 flex flex-col items-center justify-center text-white shrink-0">
                            <span class="text-xs font-medium">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('M') }}</span>
                            <span class="text-xl font-bold leading-none">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="inline-block text-xs font-medium text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full mb-1">{{ $kegiatan->kategori }}</span>
                            <h3 class="font-semibold text-neutral-900 text-sm leading-snug truncate">{{ $kegiatan->judul }}</h3>
                            <p class="text-xs text-neutral-400 mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    @if($kegiatan->deskripsi)
                    <p class="text-xs text-neutral-500 mt-3 line-clamp-2">{{ $kegiatan->deskripsi }}</p>
                    @endif
                </div>
            </div>
            @empty
            {{-- Placeholder cards --}}
            @foreach([
                ['judul'=>'Kajian Subuh Harian', 'kategori'=>'Kajian', 'hari'=>'Setiap Hari', 'waktu'=>'04:45 WIB'],
                ['judul'=>'Kajian Tafsir Al-Quran', 'kategori'=>'Tafsir', 'hari'=>'Setiap Ahad', 'waktu'=>'08:00 WIB'],
                ['judul'=>'Majelis Dzikir & Doa', 'kategori'=>'Dzikir', 'hari'=>'Setiap Kamis', 'waktu'=>'20:00 WIB'],
                ['judul'=>'Kelas Tahsin Al-Quran', 'kategori'=>'Tahsin', 'hari'=>'Senin & Rabu', 'waktu'=>'16:00 WIB'],
                ['judul'=>'Kajian Fiqih Kontemporer', 'kategori'=>'Fiqih', 'hari'=>'Setiap Sabtu', 'waktu'=>'09:00 WIB'],
                ['judul'=>'Shalat Tahajjud Bersama', 'kategori'=>'Ibadah', 'hari'=>'Malam Jumat', 'waktu'=>'03:00 WIB'],
            ] as $placeholder)
            <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                <div class="p-5">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-14 rounded-xl bg-primary-600 flex flex-col items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="inline-block text-xs font-medium text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full mb-1">{{ $placeholder['kategori'] }}</span>
                            <h3 class="font-semibold text-neutral-900 text-sm leading-snug">{{ $placeholder['judul'] }}</h3>
                            <p class="text-xs text-neutral-400 mt-1">{{ $placeholder['hari'] }} • {{ $placeholder['waktu'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold text-sm">
                Lihat Semua Jadwal Kegiatan
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="section-badge mb-3">Informasi</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900">Berita Terbaru</h2>
            </div>
            <a href="{{ route('berita.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($latestBerita ?? [] as $berita)
            <article class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                @if($berita->thumbnail)
                <div class="aspect-video overflow-hidden">
                    <img src="{{ Storage::url($berita->thumbnail) }}" alt="{{ $berita->judul }}"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>
                @else
                <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                @endif
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">{{ $berita->kategori->nama ?? 'Umum' }}</span>
                        <span class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($berita->published_at)->locale('id')->diffForHumans() }}</span>
                    </div>
                    <h3 class="font-semibold text-neutral-900 text-sm leading-snug mb-2 line-clamp-2">
                        <a href="{{ route('berita.show', $berita->slug) }}" class="hover:text-primary-600 transition-colors">{{ $berita->judul }}</a>
                    </h3>
                    <p class="text-xs text-neutral-500 line-clamp-2">{{ $berita->ringkasan }}</p>
                </div>
            </article>
            @empty
            @foreach([
                ['judul'=>'Khutbah Jumat: Pentingnya Menjaga Ukhuwah Islamiyah', 'kategori'=>'Khutbah', 'waktu'=>'2 hari lalu'],
                ['judul'=>'Laporan Kegiatan Ramadan 1446 H Masjid Grand Centerpoint', 'kategori'=>'Laporan', 'waktu'=>'1 minggu lalu'],
                ['judul'=>'Kajian Rutin Ahad: Memahami Sifat-Sifat Allah', 'kategori'=>'Kajian', 'waktu'=>'2 minggu lalu'],
            ] as $placeholder)
            <article class="bg-white rounded-2xl border border-neutral-100 overflow-hidden card-hover">
                <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">{{ $placeholder['kategori'] }}</span>
                        <span class="text-xs text-neutral-400">{{ $placeholder['waktu'] }}</span>
                    </div>
                    <h3 class="font-semibold text-neutral-900 text-sm leading-snug">{{ $placeholder['judul'] }}</h3>
                </div>
            </article>
            @endforeach
            @endforelse
        </div>

        <div class="text-center mt-6 sm:hidden">
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-1 text-sm text-primary-600 font-medium">
                Lihat Semua Berita
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- DONASI CTA --}}
<section class="py-14 bg-gradient-to-br from-primary-800 to-primary-900 relative overflow-hidden">
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="font-arabic text-2xl text-gold-300 mb-4" dir="rtl">مَن ذَا الَّذِي يُقْرِضُ اللَّهَ قَرْضًا حَسَنًا</p>
        <p class="text-primary-200 text-xs mb-8">"Siapakah yang mau memberi pinjaman kepada Allah, pinjaman yang baik..." (QS. Al-Baqarah: 245)</p>
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Dukung Kegiatan Masjid</h2>
        <p class="text-primary-200 text-sm max-w-lg mx-auto mb-8">
            Donasi Anda membantu kami menyelenggarakan kajian, operasional masjid, dan program sosial untuk jamaah.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('donasi.index') }}" class="inline-flex items-center justify-center gap-2 bg-gold-500 hover:bg-gold-400 text-white font-bold px-8 py-3.5 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Donasi Sekarang
            </a>
            <a href="{{ route('tentang') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-8 py-3.5 rounded-xl transition-colors border border-white/20">
                Pelajari Program Kami
            </a>
        </div>
    </div>
</section>

{{-- GALERI SINGKAT --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="section-badge mb-3">Galeri</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900">Foto Kegiatan</h2>
            </div>
            <a href="{{ route('galeri.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @forelse($latestGaleri ?? [] as $foto)
            <div class="aspect-square rounded-xl overflow-hidden bg-neutral-100 cursor-pointer group">
                <img src="{{ Storage::url($foto->file) }}" alt="{{ $foto->judul }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            </div>
            @empty
            @for($i = 0; $i < 8; $i++)
            <div class="aspect-square rounded-xl overflow-hidden bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                <svg class="w-8 h-8 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endfor
            @endforelse
        </div>
    </div>
</section>

{{-- LOKASI --}}
<section class="py-14 bg-neutral-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div>
                <span class="section-badge mb-4">Lokasi</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-4">Temukan Kami</h2>
                <p class="text-neutral-500 text-sm mb-6">Masjid Grand Centerpoint Bekasi berlokasi di pusat kawasan Grand Centerpoint, mudah dijangkau dari berbagai penjuru Bekasi.</p>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-neutral-900 text-sm">Alamat</p>
                            <p class="text-neutral-500 text-sm">Grand Centerpoint, Jl. Ahmad Yani,<br>Bekasi, Jawa Barat</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-neutral-900 text-sm">Jam Operasional</p>
                            <p class="text-neutral-500 text-sm">Masjid buka 24 jam<br>Sekretariat: Senin–Jumat 08.00–17.00</p>
                        </div>
                    </div>
                </div>

                <a href="https://maps.google.com" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-2 mt-6 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Buka Google Maps
                </a>
            </div>

            <div class="rounded-2xl overflow-hidden shadow-md h-64 lg:h-80 bg-neutral-200">
                {{-- Google Maps embed placeholder --}}
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
