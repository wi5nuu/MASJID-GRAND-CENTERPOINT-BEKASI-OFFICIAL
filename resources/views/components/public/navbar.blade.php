{{-- Public Navbar --}}
<nav id="main-navbar" class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-neutral-100 transition-all duration-300" x-data="mobileMenu()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-18">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center shrink-0">
                    {{-- Masjid SVG Icon --}}
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                    </svg>
                </div>
                <div class="hidden sm:block">
                    <p class="text-sm font-bold text-neutral-900 leading-tight">Masjid Grand</p>
                    <p class="text-xs text-primary-600 leading-tight font-medium">Centerpoint Bekasi</p>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'text-primary-700 bg-primary-50' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} transition-colors">
                    Beranda
                </a>
                <a href="{{ route('tentang') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('tentang') ? 'text-primary-700 bg-primary-50' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} transition-colors">
                    Tentang
                </a>

                {{-- Kegiatan Dropdown --}}
                <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('kegiatan*','event*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} transition-colors">
                        Kegiatan
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak
                        class="absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-neutral-100 py-2 z-50">
                        <a href="{{ route('kegiatan.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-neutral-600 hover:text-primary-700 hover:bg-primary-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Jadwal Kegiatan
                        </a>
                        <a href="{{ route('event.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-neutral-600 hover:text-primary-700 hover:bg-primary-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            Event Khusus
                        </a>
                    </div>
                </div>

                <a href="{{ route('berita.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('berita*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} transition-colors">
                    Berita
                </a>

                {{-- Media Dropdown --}}
                <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('galeri*','video*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} transition-colors">
                        Media
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak
                        class="absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-neutral-100 py-2 z-50">
                        <a href="{{ route('galeri.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-neutral-600 hover:text-primary-700 hover:bg-primary-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Galeri Foto
                        </a>
                        <a href="{{ route('video.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-neutral-600 hover:text-primary-700 hover:bg-primary-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                            Video & Kajian
                        </a>
                    </div>
                </div>

                <a href="{{ route('donasi.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('donasi*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} transition-colors">
                    Donasi
                </a>
                <a href="{{ route('kontak') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('kontak') ? 'text-primary-700 bg-primary-50' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} transition-colors">
                    Kontak
                </a>
            </div>

            {{-- Right: CTA + Mobile Toggle --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('donasi.index') }}" class="hidden sm:inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Donasi
                </a>

                {{-- Mobile menu button --}}
                <button @click="toggle()" class="lg:hidden p-2 rounded-lg text-neutral-600 hover:bg-neutral-100 transition-colors" aria-label="Menu">
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        x-cloak
        class="lg:hidden border-t border-neutral-100 bg-white"
    >
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'text-primary-700 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ route('tentang') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('tentang') ? 'text-primary-700 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Tentang Masjid
            </a>
            <a href="{{ route('kegiatan.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('kegiatan*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Jadwal Kegiatan
            </a>
            <a href="{{ route('event.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('event*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                Event Khusus
            </a>
            <a href="{{ route('berita.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('berita*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Berita
            </a>
            <a href="{{ route('galeri.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('galeri*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Galeri & Video
            </a>
            <a href="{{ route('donasi.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('donasi*') ? 'text-primary-700 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Donasi
            </a>
            <a href="{{ route('kontak') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('kontak') ? 'text-primary-700 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Kontak
            </a>
        </div>
    </div>
</nav>

{{-- Spacer for fixed navbar --}}
<div class="h-16 lg:h-18"></div>
