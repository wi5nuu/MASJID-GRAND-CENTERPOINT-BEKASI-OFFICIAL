{{-- Public Navbar --}}
<nav id="main-navbar"
     class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-neutral-200 transition-all duration-300"
     x-data="mobileMenu()"
     x-init="initNavbar()">

    <div class="container-xl">
        <div class="flex items-center justify-between h-16 lg:h-18">

            {{-- KIRI: Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                <img src="{{ asset('logo_apartemen_grand_centerpoint.png') }}"
                     alt="Logo Masjid Grand Centerpoint Bekasi"
                     class="h-10 w-auto object-contain">
            </a>

            {{-- TENGAH: Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                    Beranda
                </a>
                <a href="{{ route('tentang') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('tentang') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('kegiatan.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('kegiatan*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                    Program
                </a>
                <a href="{{ route('galeri.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('galeri*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                    Galeri
                </a>
                <a href="{{ route('event.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('event*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                    Kegiatan
                </a>
                <a href="{{ route('kontak') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('kontak') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-primary-600 hover:bg-neutral-50' }}">
                    Kontak
                </a>
            </div>

            {{-- KANAN: Telepon + CTA + Hamburger --}}
            <div class="flex items-center gap-3">
                {{-- Nomor telepon --}}
                <a href="https://wa.me/6221123456789"
                   target="_blank" rel="noopener"
                   class="hidden md:flex items-center gap-2 text-sm font-semibold text-neutral-600 hover:text-primary-600 transition-colors">
                    <svg class="w-4 h-4 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="hidden lg:inline">+62 21 1234 5678</span>
                </a>

                {{-- CTA Login Jamaah --}}
                <a href="{{ route('jamaah.login') }}"
                   class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-xl border border-primary-600 text-primary-600 hover:bg-primary-50 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Login
                </a>

                {{-- CTA Donasi --}}
                <a href="{{ route('donasi.index') }}"
                   class="hidden sm:inline-flex btn-primary text-sm px-4 py-2">
                    Donasi
                </a>

                {{-- Mobile hamburger --}}
                <button @click="toggle()"
                        :aria-expanded="open.toString()"
                        aria-controls="mobile-menu"
                        aria-label="Buka/tutup menu navigasi"
                        class="flex lg:hidden w-10 h-10 flex-col justify-center items-center gap-1.5 rounded-lg hover:bg-neutral-100 active:bg-neutral-200 transition-colors shrink-0"
                >
                    <span class="block w-5 h-0.5 bg-neutral-700 rounded-full transition-all duration-300" :class="open ? 'rotate-45 translate-y-2' : ''"></span>
                    <span class="block w-5 h-0.5 bg-neutral-700 rounded-full transition-all duration-300" :class="open ? 'opacity-0' : ''"></span>
                    <span class="block w-5 h-0.5 bg-neutral-700 rounded-full transition-all duration-300" :class="open ? '-rotate-45 -translate-y-2' : ''"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu"
         x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden bg-white border-t border-neutral-100 shadow-xl max-h-[calc(100dvh-4rem)] overflow-y-auto"
         @click.away="close()"
         @keydown.escape.window="close()">
        <div class="container-xl py-4 space-y-1">
            <a href="{{ route('home') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">Beranda</a>
            <a href="{{ route('tentang') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('tentang') ? 'text-primary-600 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">Tentang Kami</a>
            <a href="{{ route('kegiatan.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('kegiatan*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">Program</a>
            <a href="{{ route('galeri.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('galeri*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">Galeri</a>
            <a href="{{ route('event.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('event*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">Kegiatan</a>
            <a href="{{ route('kontak') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('kontak') ? 'text-primary-600 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">Kontak</a>
            <a href="{{ route('donasi.index') }}" @click="close()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('donasi*') ? 'text-primary-600 bg-primary-50' : 'text-neutral-700 hover:bg-neutral-50' }} transition-colors">Donasi</a>
            <div class="pt-3 border-t border-neutral-100 space-y-2">
                <a href="{{ route('jamaah.login') }}" @click="close()" class="btn-outline w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Login
                </a>
                <a href="{{ route('donasi.index') }}" @click="close()" class="btn-primary w-full justify-center">Donasi Sekarang</a>
            </div>
        </div>
    </div>
</nav>

{{-- Spacer --}}
<div class="h-16 lg:h-18"></div>

@push('scripts')
<script>
function mobileMenu() {
    return {
        open: false,
        toggle() { this.open = !this.open; },
        close() { this.open = false; },
        initNavbar() {
            window.addEventListener('scroll', () => {
                const navbar = document.getElementById('main-navbar');
                if (!navbar) return;
                if (window.scrollY > 40) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });
        }
    }
}
</script>
@endpush
