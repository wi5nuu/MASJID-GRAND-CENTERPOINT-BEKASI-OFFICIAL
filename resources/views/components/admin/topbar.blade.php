{{-- Admin Topbar --}}
<header class="h-16 bg-white border-b border-neutral-200 flex items-center justify-between px-4 md:px-6 shrink-0">

    {{-- Left: Menu toggle + Breadcrumb --}}
    <div class="flex items-center gap-3">
        <button @click="toggle()" class="p-2 rounded-lg text-neutral-500 hover:bg-neutral-100 hover:text-neutral-700 transition-colors" aria-label="Toggle menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        {{-- Breadcrumb (desktop) --}}
        <nav class="hidden md:flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}" class="text-neutral-400 hover:text-primary-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </a>
            @hasSection('breadcrumb')
            <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            @yield('breadcrumb')
            @endif
        </nav>
    </div>

    {{-- Right: Actions --}}
    <div class="flex items-center gap-2">
        {{-- View Website --}}
        <a href="{{ route('home') }}" target="_blank"
            class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-neutral-100 hover:bg-neutral-200 text-neutral-600 text-xs font-medium transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Lihat Website
        </a>

        {{-- Notifications --}}
        <div class="relative" x-data="notifications()">
            <button @click="toggle()" class="relative p-2 rounded-lg text-neutral-500 hover:bg-neutral-100 transition-colors" aria-label="Notifikasi">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span id="notif-dot" class="{{ ($adminNotif['counts']['total'] ?? 0) > 0 ? '' : 'hidden ' }}absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div x-show="open" @click.outside="open=false" x-cloak
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute right-0 mt-2 w-80 max-w-[calc(100vw-2rem)] bg-white rounded-xl shadow-lg border border-neutral-200 z-50">
                <div class="flex items-center justify-between px-4 py-3 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-900">Notifikasi <span id="notif-total" class="text-xs font-medium text-neutral-400">({{ $adminNotif['counts']['total'] ?? 0 }})</span></h3>
                    <button id="notif-read-all" type="button" class="text-xs text-primary-600 font-medium cursor-pointer hover:underline">Tandai semua dibaca</button>
                </div>
                <div id="notif-items" class="py-2 max-h-72 overflow-y-auto">
                    @forelse($adminNotif['items'] ?? [] as $item)
                    <a href="{{ $item['url'] }}" class="block px-4 py-3 hover:bg-neutral-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full mt-1.5 shrink-0 {{ $item['color'] === 'amber' ? 'bg-amber-500' : ($item['color'] === 'blue' ? 'bg-blue-500' : 'bg-green-500') }}"></div>
                            <div class="min-w-0">
                                <p class="text-xs text-neutral-700 leading-relaxed">{{ $item['text'] }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $item['time'] }}</p>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="px-4 py-8 text-center" data-notif-empty>
                        <svg class="w-8 h-8 text-neutral-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-neutral-400">Tidak ada notifikasi baru</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- User dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open=!open" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-neutral-100 transition-colors">
                <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center">
                    <span class="text-primary-700 text-xs font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</span>
                </div>
                <span class="hidden sm:block text-sm font-medium text-neutral-700 max-w-24 truncate">{{ auth()->user()->name ?? 'Admin' }}</span>
                <svg class="w-4 h-4 text-neutral-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" @click.outside="open=false" x-cloak
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-neutral-200 py-2 z-50">
                <div class="px-3 pb-2 mb-2 border-b border-neutral-100">
                    <p class="text-xs font-semibold text-neutral-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-neutral-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
                <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-neutral-600 hover:bg-neutral-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil Saya
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-neutral-600 hover:bg-neutral-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan
                </a>
                <div class="border-t border-neutral-100 mt-1 pt-1">
                    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('topbar-logout-form').submit();"
                        class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </a>
                    <form id="topbar-logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
(function () {
    var FEED_URL = @json(route('admin.notifications.feed'));
    var READ_ALL_URL = @json(route('admin.notifications.read-all'));
    var CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    var POLL_MS = 30000;
    var timer = null;

    var DOT_COLORS = { amber: 'bg-amber-500', blue: 'bg-blue-500', green: 'bg-green-500' };

    function esc(s) {
        return String(s ?? '').replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c];
        });
    }

    function setBadge(key, n) {
        document.querySelectorAll('[data-notif-badge="' + key + '"]').forEach(function (el) {
            el.textContent = n;
            el.classList.toggle('hidden', !(n > 0));
        });
    }

    function render(data) {
        var counts = data.counts || { users: 0, kontak: 0, donasi: 0, total: 0 };
        var items = data.items || [];

        var dot = document.getElementById('notif-dot');
        if (dot) dot.classList.toggle('hidden', !(counts.total > 0));

        var total = document.getElementById('notif-total');
        if (total) total.textContent = '(' + counts.total + ')';

        setBadge('users', counts.users);
        setBadge('kontak', counts.kontak);
        setBadge('donasi', counts.donasi);

        var box = document.getElementById('notif-items');
        if (box) {
            if (!items.length) {
                box.innerHTML = '<div class="px-4 py-8 text-center"><svg class="w-8 h-8 text-neutral-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><p class="text-xs text-neutral-400">Tidak ada notifikasi baru</p></div>';
            } else {
                box.innerHTML = items.map(function (it) {
                    var dotCls = DOT_COLORS[it.color] || 'bg-primary-500';
                    return '<a href="' + esc(it.url) + '" class="block px-4 py-3 hover:bg-neutral-50 transition-colors">'
                        + '<div class="flex items-start gap-3">'
                        + '<div class="w-2 h-2 rounded-full mt-1.5 shrink-0 ' + dotCls + '"></div>'
                        + '<div class="min-w-0"><p class="text-xs text-neutral-700 leading-relaxed">' + esc(it.text) + '</p>'
                        + '<p class="text-xs text-neutral-400 mt-0.5">' + esc(it.time) + '</p></div>'
                        + '</div></a>';
                }).join('');
            }
        }
    }

    async function poll() {
        if (document.hidden) return;
        try {
            var res = await fetch(FEED_URL, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
            if (res.status === 401 || res.status === 403 || res.status === 419) { stop(); return; }
            if (!res.ok) return;
            render(await res.json());
        } catch (e) { /* jaringan terputus — coba lagi periodenya */ }
    }

    function stop() { if (timer) { clearInterval(timer); timer = null; } }

    document.getElementById('notif-read-all')?.addEventListener('click', async function () {
        try {
            var res = await fetch(READ_ALL_URL, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                credentials: 'same-origin'
            });
            if (!res.ok) return;
            render(await res.json());
        } catch (e) { /* abaikan */ }
    });

    document.addEventListener('visibilitychange', function () { if (!document.hidden) poll(); });

    timer = setInterval(poll, POLL_MS);
})();
</script>
@endpush
