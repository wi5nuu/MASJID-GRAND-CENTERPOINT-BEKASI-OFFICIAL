<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') — {{ config('app.name') }}</title>
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

            <h2 class="text-2xl font-bold text-neutral-900 mb-1">Masuk ke Dashboard</h2>
            <p class="text-neutral-500 text-sm mb-8">Masukkan kredensial Anda untuk melanjutkan.</p>

            @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    <ul class="text-xs text-red-700 space-y-0.5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 bg-white text-neutral-900 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        placeholder="admin@masjidgcp.com">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-neutral-700">Kata Sandi</label>
                        <a href="{{ route('admin.password.request') }}" class="text-xs text-primary-600 hover:text-primary-700 transition-colors">Lupa kata sandi?</a>
                    </div>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required
                            class="w-full px-4 py-2.5 pr-10 rounded-xl border border-neutral-300 bg-white text-neutral-900 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="••••••••">
                        <button type="button" @click="show=!show" class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 transition-colors">
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                    <label for="remember" class="text-sm text-neutral-600">Ingat saya selama 30 hari</label>
                </div>

                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm">
                    Masuk ke Dashboard
                </button>
            </form>

            <p class="text-center text-xs text-neutral-400 mt-8">
                <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Kembali ke Website</a>
            </p>
        </div>
    </div>

</body>
</html>
