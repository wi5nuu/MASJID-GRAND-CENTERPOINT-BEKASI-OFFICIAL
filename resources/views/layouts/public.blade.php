<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>@yield('title', config('app.name', 'Masjid Grand Centerpoint Bekasi'))</title>
    <meta name="description" content="@yield('meta_description', 'Masjid Grand Centerpoint Bekasi — Pusat ibadah, pendidikan, dan kegiatan Islam di Bekasi.')">
    <meta name="keywords" content="@yield('meta_keywords', 'masjid bekasi, masjid grand centerpoint, jadwal shalat bekasi, kajian islam bekasi')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Masjid Grand Centerpoint Bekasi')">
    <meta property="og:image" content="@yield('og_image', asset('images/mosque/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/mosque/apple-touch-icon.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="font-sans bg-white text-neutral-800 antialiased">

    {{-- Flash Message --}}
    @if(session('success') || session('error') || session('warning'))
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
    @endif

    {{-- Announcement Popup --}}
    @include('components.public.announcement-popup')

    {{-- Navbar --}}
    @include('components.public.navbar')

    {{-- Marquee / Running Text Bar --}}
    @include('components.public.marquee-bar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.public.footer')

    @stack('scripts')
</body>
</html>
