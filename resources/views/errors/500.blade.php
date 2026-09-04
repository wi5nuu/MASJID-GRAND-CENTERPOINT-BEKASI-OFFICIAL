<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 — Server Error</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Amiri&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-neutral-50 text-neutral-800 antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-4 max-w-md mx-auto">
        {{-- Arabic --}}
        <p class="font-arabic text-2xl text-gold-500 mb-6" dir="rtl">حَسْبُنَا اللَّهُ وَنِعْمَ الْوَكِيلُ</p>

        {{-- Icon --}}
        <div class="w-20 h-20 rounded-2xl bg-orange-100 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <p class="text-6xl font-bold text-primary-600 mb-2">500</p>
        <h1 class="text-xl font-bold text-neutral-900 mb-3">Terjadi Kesalahan Server</h1>
        <p class="text-sm text-neutral-500 leading-relaxed mb-8">
            Mohon maaf, terjadi kesalahan pada server kami. Tim kami sudah diberitahu dan sedang memperbaiki masalah ini. Silakan coba beberapa saat lagi.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-3 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Ke Beranda
            </a>
            <button onclick="location.reload()" class="inline-flex items-center gap-2 border border-neutral-300 text-neutral-600 hover:bg-neutral-100 text-sm font-semibold px-6 py-3 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Coba Lagi
            </button>
        </div>

        <p class="mt-10 text-xs text-neutral-400">Masjid Grand Centerpoint Bekasi</p>
    </div>
</body>
</html>
