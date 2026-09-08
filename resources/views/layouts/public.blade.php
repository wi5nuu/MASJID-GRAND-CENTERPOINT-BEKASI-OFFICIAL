<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Masjid Grand Centerpoint Bekasi — Pusat Ibadah & Kegiatan Islam di Bekasi')</title>
    <meta name="description" content="@yield('meta_description', 'Masjid Grand Centerpoint Bekasi — pusat ibadah, pendidikan Al-Quran, kajian Islam, dan kegiatan sosial di kawasan Grand Centerpoint, Jalan Ahmad Yani, Bekasi, Jawa Barat.')">
    <meta name="keywords" content="@yield('meta_keywords', 'masjid bekasi, masjid grand centerpoint, masjid jawa barat, kajian islam bekasi, TPA bekasi, jadwal shalat bekasi, DKM grand centerpoint, masjid apartemen bekasi')">
    <meta name="robots" content="index, follow">
    <meta name="author" content="DKM Masjid Grand Centerpoint Bekasi">
    <meta name="geo.region" content="ID-JB">
    <meta name="geo.placename" content="Bekasi, Jawa Barat">
    <meta name="language" content="id">

    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', 'Masjid Grand Centerpoint Bekasi')">
    <meta property="og:description" content="@yield('og_description', 'Masjid Grand Centerpoint Bekasi — pusat ibadah, pendidikan Al-Quran, kajian Islam, dan kegiatan sosial di kawasan Grand Centerpoint, Bekasi.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:image" content="@yield('og_image', asset('images/mosque/gcp_herosection.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Masjid Grand Centerpoint Bekasi">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'Masjid Grand Centerpoint Bekasi')">
    <meta name="twitter:description" content="@yield('og_description', 'Pusat ibadah, pendidikan Al-Quran, dan kegiatan sosial di Bekasi.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/mosque/gcp_herosection.png'))">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts: Inter + Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Progressive enhancement untuk scroll-reveal: tandai <html> sedini mungkin
         agar [data-animate] hanya disembunyikan bila JS berjalan. Jika bundle gagal/
         lambat >4 detik, fallback melepasnya sehingga konten tetap tampil. --}}
    <script>
    (function(){document.documentElement.classList.add('reveal-pending');
    setTimeout(function(){if(!window.__revealReady){document.documentElement.classList.remove('reveal-pending');}},4000);})();
    </script>

    {{-- JSON-LD: Mosque / LocalBusiness Structured Data --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": ["MosqueOrTemple", "LocalBusiness"],
        "@@id": "{{ url('/') }}#mosque",
        "name": "Masjid Grand Centerpoint Bekasi",
        "alternateName": "Masjid GCP Bekasi",
        "description": "Masjid Grand Centerpoint Bekasi adalah pusat ibadah, pendidikan Al-Quran, kajian Islam, dan kegiatan sosial di kawasan Apartemen Grand Centerpoint, Bekasi, Jawa Barat.",
        "url": "{{ url('/') }}",
        "telephone": "+622112345678",
        "email": "masjid@grandcenterpoint.id",
        "logo": "{{ asset('logo_apartemen_grand_centerpoint.png') }}",
        "image": "{{ asset('images/mosque/gcp_herosection.png') }}",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "GRAND Centerpoint Tower C & D, Jalan Ahmad Yani Sentra Niaga Kalimalang A3.2",
            "addressLocality": "Bekasi",
            "addressRegion": "Jawa Barat",
            "addressCountry": "ID",
            "postalCode": "17144"
        },
        "geo": {
            "@@type": "GeoCoordinates",
            "latitude": "-6.2087",
            "longitude": "106.9923"
        },
        "openingHoursSpecification": [
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "opens": "04:00",
                "closes": "22:00"
            }
        ],
        "priceRange": "Free",
        "currenciesAccepted": "IDR",
        "paymentAccepted": "Cash, Transfer",
        "areaServed": {
            "@@type": "City",
            "name": "Bekasi"
        },
        "sameAs": []
    }
    </script>

    @stack('head')
</head>
<body class="font-sans bg-neutral-50 text-neutral-800 antialiased {{ request()->routeIs('jamaah.*') ? '' : 'has-mobile-nav' }}">
    <noscript><style>[data-animate]{opacity:1 !important;transform:none !important;}</style></noscript>

    @if(session('success') || session('error'))
    <div id="flash-message" class="fixed top-4 right-4 z-50 max-w-sm w-full">
        @if(session('success'))
        <div class="flex items-center gap-3 bg-white border-l-4 border-primary-600 rounded-lg shadow-lg p-4">
            <svg class="w-5 h-5 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <p class="text-sm text-neutral-700">{{ session('success') }}</p>
        </div>
        @elseif(session('error'))
        <div class="flex items-center gap-3 bg-white border-l-4 border-red-500 rounded-lg shadow-lg p-4">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <p class="text-sm text-neutral-700">{{ session('error') }}</p>
        </div>
        @endif
    </div>
    <script>setTimeout(()=>{const el=document.getElementById('flash-message');if(el)el.remove();},4000);</script>
    @endif

    @include('components.public.announcement-popup')
    @include('components.public.navbar')
    @include('components.public.marquee-bar')

    {{-- overflow-x-clip: menahan translate awal [data-animate] (±40px) agar tidak
         menambah scrollWidth halaman sebelum animasi berjalan. Aman karena tidak
         ada elemen sticky di dalam <main> (navbar & bottom-nav di luar main). --}}
    <main class="overflow-x-clip">@yield('content')</main>

    @include('components.public.footer')
{{-- Bottom Navigation Bar (Mobile only) — dibuat ramping agar muat 6 item di 320px --}}
<nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-neutral-200 lg:hidden safe-area-bottom" aria-label="Navigasi bawah">
    <div class="grid grid-cols-6 h-16 overflow-hidden">
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-1 min-w-0 px-0.5 py-1.5 {{ request()->routeIs('home') ? 'text-primary-600' : 'text-neutral-400' }} transition-colors">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="text-[10px] leading-tight font-semibold truncate max-w-full">Beranda</span>
        </a>
        <a href="{{ route('kegiatan.index') }}" class="flex flex-col items-center justify-center gap-1 min-w-0 px-0.5 py-1.5 {{ request()->routeIs('kegiatan*') ? 'text-primary-600' : 'text-neutral-400' }} transition-colors">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="text-[10px] leading-tight font-semibold truncate max-w-full">Program</span>
        </a>
        <a href="{{ route('galeri.index') }}" class="flex flex-col items-center justify-center gap-1 min-w-0 px-0.5 py-1.5 {{ request()->routeIs('galeri*') ? 'text-primary-600' : 'text-neutral-400' }} transition-colors">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="text-[10px] leading-tight font-semibold truncate max-w-full">Galeri</span>
        </a>
        <a href="{{ route('event.index') }}" class="flex flex-col items-center justify-center gap-1 min-w-0 px-0.5 py-1.5 {{ request()->routeIs('event*') ? 'text-primary-600' : 'text-neutral-400' }} transition-colors">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            <span class="text-[10px] leading-tight font-semibold truncate max-w-full">Kegiatan</span>
        </a>
        <a href="{{ route('kontak') }}" class="flex flex-col items-center justify-center gap-1 min-w-0 px-0.5 py-1.5 {{ request()->routeIs('kontak') ? 'text-primary-600' : 'text-neutral-400' }} transition-colors">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            <span class="text-[10px] leading-tight font-semibold truncate max-w-full">Kontak</span>
        </a>
        <a href="{{ route('jamaah.login') }}" class="flex flex-col items-center justify-center gap-1 min-w-0 px-0.5 py-1.5 {{ request()->routeIs('jamaah.login') ? 'text-primary-600' : 'text-neutral-400' }} transition-colors">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span class="text-[10px] leading-tight font-semibold truncate max-w-full">Login</span>
        </a>
    </div>
</nav>

    @stack('scripts')
</body>
</html>
