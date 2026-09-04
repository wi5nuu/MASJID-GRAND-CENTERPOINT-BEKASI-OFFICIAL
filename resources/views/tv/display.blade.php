<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TV Display — Masjid Grand Centerpoint Bekasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #0f2d1a; }
        @keyframes fadeSlide {
            0%   { opacity: 0; transform: translateY(20px); }
            10%  { opacity: 1; transform: translateY(0); }
            85%  { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }
        .fade-slide { animation: fadeSlide 10s ease-in-out infinite; }
    </style>
</head>
<body class="font-sans min-h-screen flex flex-col overflow-hidden">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 border-b-4 border-gold-500 px-8 py-4 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary-600 border-2 border-gold-400 flex items-center justify-center">
                <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                </svg>
            </div>
            <div>
                <p class="text-white font-bold text-lg leading-tight">Masjid Grand Centerpoint Bekasi</p>
                <p class="font-arabic text-gold-300 text-base" dir="rtl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
            </div>
        </div>

        {{-- Clock --}}
        <div class="text-right" x-data="clock()">
            <p class="text-white font-mono font-bold text-4xl" x-text="time">00:00:00</p>
            <p class="text-primary-300 text-sm" x-text="date"></p>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="flex-1 grid grid-cols-3 gap-0">

        {{-- Left: Jadwal Shalat --}}
        <div class="bg-gradient-to-b from-primary-900 to-primary-950 p-8 flex flex-col">
            <h2 class="text-gold-400 font-bold text-xl uppercase tracking-widest mb-6 text-center">Jadwal Shalat</h2>
            <p class="text-primary-300 text-center text-sm mb-6">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>

            @php
                $shalatTv = [
                    ['name' => 'Subuh',   'time' => $shalat?->subuh   ?? '04:45', 'arabic' => 'الفجر'],
                    ['name' => 'Syuruq',  'time' => $shalat?->syuruq  ?? '06:02', 'arabic' => 'الشروق'],
                    ['name' => 'Dzuhur',  'time' => $shalat?->dzuhur  ?? '12:00', 'arabic' => 'الظهر'],
                    ['name' => 'Ashar',   'time' => $shalat?->ashar   ?? '15:15', 'arabic' => 'العصر'],
                    ['name' => 'Maghrib', 'time' => $shalat?->maghrib ?? '18:02', 'arabic' => 'المغرب'],
                    ['name' => 'Isya',    'time' => $shalat?->isya    ?? '19:15', 'arabic' => 'العشاء'],
                ];
            @endphp

            <div class="space-y-3 flex-1">
                @foreach($shalatTv as $s)
                <div class="flex items-center justify-between bg-white/5 rounded-xl px-5 py-3 border border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-gold-400"></div>
                        <div>
                            <p class="text-white font-semibold text-base">{{ $s['name'] }}</p>
                            <p class="font-arabic text-gold-400 text-sm" dir="rtl">{{ $s['arabic'] }}</p>
                        </div>
                    </div>
                    <p class="text-white font-mono font-bold text-xl">{{ $s['time'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Jumat --}}
            @if($shalat?->jumat)
            <div class="mt-4 bg-gold-500/20 border border-gold-500/40 rounded-xl px-5 py-3 flex items-center justify-between">
                <p class="text-gold-300 font-semibold">Shalat Jumat</p>
                <p class="text-white font-mono font-bold text-xl">{{ $shalat->jumat }}</p>
            </div>
            @endif
        </div>

        {{-- Center: Pengumuman / Konten --}}
        <div class="bg-gradient-to-b from-neutral-900 to-neutral-950 p-8 flex flex-col items-center justify-center border-x border-white/10">
            <div class="text-center max-w-sm" x-data="{
                items: {{ json_encode($displays->where('tipe', 'pengumuman')->values()) }},
                current: 0,
                init() {
                    if (this.items.length > 1) {
                        setInterval(() => {
                            this.current = (this.current + 1) % this.items.length;
                        }, 10000);
                    }
                }
            }">
                <template x-if="items.length > 0">
                    <div>
                        <div class="w-16 h-16 rounded-full bg-primary-600 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        </div>
                        <h3 class="text-gold-400 font-bold text-2xl mb-4" x-text="items[current]?.judul"></h3>
                        <p class="text-white/80 text-lg leading-relaxed" x-text="items[current]?.konten"></p>
                    </div>
                </template>
                <template x-if="items.length === 0">
                    <div>
                        <p class="font-arabic text-gold-300 text-3xl mb-4" dir="rtl">إِنَّمَا يَعْمُرُ مَسَاجِدَ اللَّهِ مَنْ آمَنَ بِاللَّهِ</p>
                        <p class="text-white/60 text-sm">"Hanya yang memakmurkan masjid-masjid Allah ialah orang yang beriman kepada Allah." — QS. At-Taubah: 18</p>
                    </div>
                </template>
            </div>
        </div>

        {{-- Right: Info & Countdown --}}
        <div class="bg-gradient-to-b from-primary-950 to-primary-900 p-8 flex flex-col gap-6">
            {{-- Countdown to next prayer --}}
            <div class="bg-white/5 rounded-2xl border border-gold-500/30 p-5 text-center" x-data="prayerCountdown()">
                <p class="text-primary-300 text-xs uppercase tracking-widest mb-2">Waktu Menuju Shalat</p>
                <p class="text-gold-400 font-bold text-lg mb-1" x-text="nextPrayer">—</p>
                <p class="text-white font-mono font-bold text-4xl" x-text="countdown">--:--:--</p>
            </div>

            {{-- Donasi Info --}}
            <div class="bg-white/5 rounded-2xl border border-white/10 p-5">
                <h3 class="text-gold-400 font-bold text-base mb-3">Donasi Masjid</h3>
                <p class="text-white/70 text-sm leading-relaxed">{{ \App\Models\Setting::get('donasi_rekening', 'Hubungi sekretariat untuk info donasi') }}</p>
                <div class="mt-3 pt-3 border-t border-white/10">
                    <p class="text-primary-300 text-xs">Total Donasi Bulan Ini</p>
                    <p class="text-white font-bold text-xl">Rp {{ number_format(\App\Models\Donasi::confirmed()->whereMonth('confirmed_at', now()->month)->sum('jumlah'), 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Wifi / Info --}}
            <div class="bg-white/5 rounded-2xl border border-white/10 p-5">
                <h3 class="text-gold-400 font-bold text-base mb-2">Wifi Masjid</h3>
                <p class="text-white/70 text-sm">SSID: <span class="text-white font-semibold">MasjidGCP</span></p>
                <p class="text-white/70 text-sm">Password: <span class="text-white font-semibold">masjidgcp2024</span></p>
            </div>
        </div>
    </div>

    {{-- Running Text --}}
    <div class="bg-primary-600 border-t-2 border-gold-500 py-2.5 overflow-hidden shrink-0">
        <div class="marquee whitespace-nowrap text-white font-medium text-sm px-4">
            @php $runningText = \App\Models\Setting::get('running_text', 'Selamat datang di Masjid Grand Centerpoint Bekasi.'); @endphp
            {{ $runningText }} &nbsp;&nbsp;&nbsp;&nbsp;★&nbsp;&nbsp;&nbsp;&nbsp; {{ $runningText }} &nbsp;&nbsp;&nbsp;&nbsp;★&nbsp;&nbsp;&nbsp;&nbsp; {{ $runningText }}
        </div>
    </div>

    <script>
        window.prayerTimes = {
            subuh:   '{{ $shalat?->subuh ?? "04:45" }}',
            dzuhur:  '{{ $shalat?->dzuhur ?? "12:00" }}',
            ashar:   '{{ $shalat?->ashar ?? "15:15" }}',
            maghrib: '{{ $shalat?->maghrib ?? "18:02" }}',
            isya:    '{{ $shalat?->isya ?? "19:15" }}',
        };
    </script>

</body>
</html>
