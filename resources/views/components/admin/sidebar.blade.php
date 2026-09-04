{{-- Admin Sidebar --}}
<aside
    :class="open ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-neutral-200 flex flex-col transform transition-transform duration-200 ease-in-out lg:relative lg:translate-x-0 lg:flex lg:shrink-0"
>
    {{-- Sidebar Header --}}
    <div class="flex items-center justify-between h-16 px-4 border-b border-neutral-200 shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-neutral-900 leading-tight">Panel Admin</p>
                <p class="text-xs text-primary-600 leading-tight">Masjid GCP Bekasi</p>
            </div>
        </a>
        <button @click="toggle()" class="lg:hidden p-1 rounded-lg text-neutral-400 hover:bg-neutral-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5 scrollbar-none [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

        {{-- Main --}}
        <p class="px-3 py-1 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Utama</p>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        {{-- Konten --}}
        <p class="px-3 pt-4 pb-1 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Konten</p>

        <a href="{{ route('admin.berita.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.berita*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            Berita & Artikel
        </a>

        <a href="{{ route('admin.kegiatan.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.kegiatan*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Jadwal Kegiatan
        </a>

        <a href="{{ route('admin.event.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.event*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            Event Khusus
        </a>

        {{-- Media --}}
        <p class="px-3 pt-4 pb-1 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Media</p>

        <a href="{{ route('admin.galeri.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.galeri*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Galeri Foto
        </a>

        <a href="{{ route('admin.video.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.video*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
            Video & Kajian
        </a>

        <a href="{{ route('admin.media.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.media*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Manajemen Media
        </a>

        {{-- Keuangan --}}
        <p class="px-3 pt-4 pb-1 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Keuangan</p>

        <a href="{{ route('admin.donasi.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.donasi*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            Donasi
        </a>

        {{-- Masjid --}}
        <p class="px-3 pt-4 pb-1 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Masjid</p>

        <a href="{{ route('admin.pengurus.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.pengurus*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Pengurus Masjid
        </a>

        <a href="{{ route('admin.shalat.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.shalat*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Jadwal Shalat
        </a>

        <a href="{{ route('admin.tv.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.tv*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            TV Display
        </a>

        {{-- Sistem --}}
        <p class="px-3 pt-4 pb-1 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Sistem</p>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.users*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Manajemen User
        </a>

        <a href="{{ route('admin.seo.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.seo*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Manajemen SEO
        </a>

        <a href="{{ route('admin.settings.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.settings*') ? 'bg-primary-50 text-primary-700 border-l-[3px] border-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Pengaturan
        </a>
    </nav>

    {{-- Sidebar Footer --}}
    <div class="px-3 py-3 border-t border-neutral-100 shrink-0">
        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-neutral-50 transition-colors">
            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                <span class="text-primary-700 text-xs font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-neutral-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-neutral-400 truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
            <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="p-1 rounded-lg text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-colors" title="Keluar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </a>
        </div>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
</aside>
