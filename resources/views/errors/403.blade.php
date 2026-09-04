<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Ditolak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Amiri&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-neutral-50 text-neutral-800 antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-4 max-w-md mx-auto">
        {{-- Arabic --}}
        <p class="font-arabic text-2xl text-gold-500 mb-6" dir="rtl">إِنَّا لِلَّهِ وَإِنَّا إِلَيْهِ رَاجِعُونَ</p>

        {{-- Icon --}}
        <div class="w-20 h-20 rounded-2xl bg-red-100 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <p class="text-6xl font-bold text-primary-600 mb-2">403</p>
        <h1 class="text-xl font-bold text-neutral-900 mb-3">Akses Ditolak</h1>
        <p class="text-sm text-neutral-500 leading-relaxed mb-8">
            Anda tidak memiliki izin untuk mengakses halaman ini. Hubungi administrator jika Anda merasa ini adalah kesalahan.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-3 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 border border-neutral-300 text-neutral-600 hover:bg-neutral-100 text-sm font-semibold px-6 py-3 rounded-xl transition-colors">
                Ke Beranda
            </a>
        </div>

        <p class="mt-10 text-xs text-neutral-400">Masjid Grand Centerpoint Bekasi</p>
    </div>
</body>
</html>
