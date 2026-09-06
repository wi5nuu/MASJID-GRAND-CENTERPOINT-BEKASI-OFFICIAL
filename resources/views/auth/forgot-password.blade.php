<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Kata Sandi — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-neutral-50 antialiased min-h-screen flex">

    {{-- Left Panel (desktop) --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-800 via-primary-700 to-primary-900 relative overflow-hidden flex-col items-center justify-center p-12">
        <div class="absolute inset-0 pattern-islamic opacity-20"></div>
        <div class="relative text-center">
            {{-- Mosque icon --}}
            <div class="w-20 h-20 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-8 backdrop-blur-sm">
                <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                </svg>
            </div>
            <p class="font-arabic text-3xl text-gold-300 mb-2" dir="rtl">بِسْمِ اللَّهِ</p>
            <h1 class="text-3xl font-bold text-white mb-3">Masjid Grand<br>Centerpoint Bekasi</h1>
            <p class="text-primary-200 text-sm max-w-xs mx-auto leading-relaxed">
                Panel administrasi untuk pengelolaan konten, kegiatan, dan informasi masjid.
            </p>

            {{-- Ayat --}}
            <div class="mt-10 bg-white/10 rounded-2xl p-5 max-w-sm mx-auto backdrop-blur-sm">
                <p class="font-arabic text-xl text-gold-300 mb-2 text-center" dir="rtl">إِنَّمَا يَعْمُرُ مَسَاجِدَ اللَّهِ مَنْ آمَنَ بِاللَّهِ</p>
                <p class="text-primary-200 text-xs text-center leading-relaxed">"Hanya yang memakmurkan masjid-masjid Allah ialah orang-orang yang beriman kepada Allah..."</p>
                <p class="text-primary-400 text-xs text-center mt-1">QS. At-Taubah: 18</p>
            </div>
        </div>
    </div>

    {{-- Right Panel: Form --}}
    <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-12 py-12">
        <div class="w-full max-w-md">

            {{-- Mobile Logo --}}
            <div class="flex flex-col items-center mb-8 lg:hidden">
                <div class="w-12 h-12 rounded-xl bg-primary-600 flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                    </svg>
                </div>
                <h1 class="text-lg font-bold text-neutral-900">Masjid Grand Centerpoint</h1>
                <p class="text-sm text-neutral-500">Panel Administrasi</p>
            </div>

            {{-- Icon --}}
            <div class="w-12 h-12 rounded-xl bg-primary-50 border border-primary-100 flex items-center justify-center mb-6">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-neutral-900 mb-1">Lupa Kata Sandi?</h2>
            <p class="text-neutral-500 text-sm mb-8">Fitur reset kata sandi belum tersedia. Silakan hubungi administrator sistem untuk mereset kata sandi Anda.</p>

            {{-- Info box --}}
            <div class="bg-primary-50 border border-primary-100 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-primary-800 mb-1">Hubungi Administrator</p>
                        <p class="text-xs text-primary-600 leading-relaxed">
                            Untuk mereset kata sandi, silakan hubungi pengelola sistem masjid secara langsung atau melalui email resmi.
                        </p>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.login') }}"
               class="w-full flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Halaman Login
            </a>

            <p class="text-center text-xs text-neutral-400 mt-8">
                <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Kembali ke Website</a>
            </p>
        </div>
    </div>

</body>
</html>
