<footer class="bg-neutral-900 text-neutral-300">

    {{-- Top green accent bar --}}
    <div class="h-1 bg-gradient-to-r from-primary-600 via-primary-500 to-gold-500"></div>

    {{-- Main Footer --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

            {{-- Column 1: Brand --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-base leading-tight">Masjid Grand</p>
                        <p class="text-primary-400 text-sm font-medium leading-tight">Centerpoint Bekasi</p>
                    </div>
                </a>
                <p class="text-sm leading-relaxed text-neutral-400 mb-5">
                    Pusat ibadah, pendidikan Islam, dan kegiatan kemasyarakatan di kawasan Grand Centerpoint Bekasi.
                </p>
                {{-- Arabic tagline --}}
                <p class="font-arabic text-xl text-gold-400 text-right mb-1">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
                <p class="text-xs text-neutral-500 text-right">Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang</p>
            </div>

            {{-- Column 2: Navigasi --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Navigasi</h3>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('home') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('tentang') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Tentang Masjid</a></li>
                    <li><a href="{{ route('kegiatan.index') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Jadwal Kegiatan</a></li>
                    <li><a href="{{ route('event.index') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Event Khusus</a></li>
                    <li><a href="{{ route('berita.index') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Berita & Artikel</a></li>
                    <li><a href="{{ route('galeri.index') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Galeri Foto</a></li>
                    <li><a href="{{ route('video.index') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Video & Kajian</a></li>
                    <li><a href="{{ route('donasi.index') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Donasi</a></li>
                    <li><a href="{{ route('kontak') }}" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">Kontak</a></li>
                </ul>
            </div>

            {{-- Column 3: Informasi --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Informasi</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="text-sm text-neutral-400">Grand Centerpoint Bekasi,<br>Jl. Ahmad Yani, Bekasi</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:+62211234567" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">(021) 1234-5678</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:info@masjidgcp.com" class="text-sm text-neutral-400 hover:text-primary-400 transition-colors">info@masjidgcp.com</a>
                    </li>
                </ul>

                {{-- Jam Operasional --}}
                <div class="mt-5">
                    <h4 class="text-white text-xs font-semibold uppercase tracking-wider mb-2">Sekretariat</h4>
                    <p class="text-sm text-neutral-400">Senin – Jumat: 08.00 – 17.00</p>
                    <p class="text-sm text-neutral-400">Sabtu: 08.00 – 12.00</p>
                    <p class="text-xs text-primary-500 mt-1">Masjid buka 24 jam</p>
                </div>
            </div>

            {{-- Column 4: Media Sosial & Newsletter --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Ikuti Kami</h3>
                <div class="flex gap-3 mb-6">
                    <a href="#" aria-label="YouTube" class="w-9 h-9 rounded-lg bg-neutral-800 hover:bg-primary-600 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-neutral-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-lg bg-neutral-800 hover:bg-primary-600 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-neutral-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" aria-label="Facebook" class="w-9 h-9 rounded-lg bg-neutral-800 hover:bg-primary-600 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-neutral-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="WhatsApp" class="w-9 h-9 rounded-lg bg-neutral-800 hover:bg-primary-600 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-neutral-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                </div>

                {{-- Newsletter singkat --}}
                <h4 class="text-white text-xs font-semibold uppercase tracking-wider mb-2">Info Terbaru</h4>
                <p class="text-xs text-neutral-400 mb-3">Dapatkan informasi kegiatan dan jadwal terbaru.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="email" name="email" placeholder="Email Anda" required
                        class="flex-1 min-w-0 bg-neutral-800 border border-neutral-700 rounded-lg px-3 py-2 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-primary-500 transition-colors">
                    <button type="submit" class="shrink-0 bg-primary-600 hover:bg-primary-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                        Daftar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-neutral-500 text-center sm:text-left">
                &copy; {{ date('Y') }} Masjid Grand Centerpoint Bekasi. Seluruh hak cipta dilindungi.
            </p>
            <div class="flex items-center gap-4">
                <a href="#" class="text-xs text-neutral-500 hover:text-neutral-400 transition-colors">Kebijakan Privasi</a>
                <a href="#" class="text-xs text-neutral-500 hover:text-neutral-400 transition-colors">Syarat Penggunaan</a>
                <a href="{{ route('admin.login') }}" class="text-xs text-neutral-600 hover:text-neutral-500 transition-colors">Admin</a>
            </div>
        </div>
    </div>
</footer>
