<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TV Display — Masjid Grand Centerpoint Bekasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { scrollbar-width: none; -ms-overflow-style: none; }
        *::-webkit-scrollbar { display: none; }

        html, body { height: 100%; overflow: hidden; }
        body { background: #f0fdf4; font-family: 'Plus Jakarta Sans', sans-serif; }

        .font-arabic { font-family: 'Amiri', serif; }

        /* Marquee */
        @keyframes marquee {
            0%   { transform: translateX(100vw); }
            100% { transform: translateX(-100%); }
        }
        .marquee-inner { animation: marquee 30s linear infinite; white-space: nowrap; display: inline-block; }

        /* Pulse ring for active shalat */
        @keyframes pulseRing {
            0%   { transform: scale(1);   opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        .pulse-ring::before {
            content: ''; position: absolute; inset: -4px;
            border-radius: 50%; background: #16a34a;
            animation: pulseRing 1.5s ease-out infinite;
        }

        /* Card glass effect */
        .glass { background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); }
        .glass-green { background: rgba(22,163,74,0.08); backdrop-filter: blur(12px); }

        /* Countdown digits */
        .countdown-digit {
            background: linear-gradient(135deg, #166534, #16a34a);
            color: white;
            border-radius: 10px;
            padding: 6px 10px;
            font-variant-numeric: tabular-nums;
            min-width: 52px;
            text-align: center;
            font-size: clamp(1.4rem, 2.5vw, 2rem);
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Active prayer row */
        .prayer-active {
            background: linear-gradient(135deg, #16a34a, #15803d) !important;
            border-color: #16a34a !important;
        }
        .prayer-active .prayer-name { color: white !important; }
        .prayer-active .prayer-arabic { color: #bbf7d0 !important; }
        .prayer-active .prayer-time { color: white !important; }

        /* Slide animation for announcements */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.5s ease forwards; }

        /* TV safe scaling */
        .tv-root {
            width: 100vw; height: 100vh;
            display: flex; flex-direction: column;
            overflow: hidden;
        }
    </style>
</head>
<body>
<div class="tv-root">

    {{-- ══ HEADER ══ --}}
    <header style="background: linear-gradient(135deg, #14532d 0%, #166534 50%, #14532d 100%); border-bottom: 3px solid #ca8a04; flex-shrink: 0;">
        <div style="display:flex; align-items:center; justify-content:space-between; padding: clamp(8px,1.2vh,16px) clamp(16px,2vw,32px);">

            {{-- Logo + Nama --}}
            <div style="display:flex; align-items:center; gap: clamp(10px,1.2vw,20px);">
                <div style="width:clamp(40px,4vw,56px); height:clamp(40px,4vw,56px); background:rgba(255,255,255,0.12); border:2px solid #fbbf24; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg style="width:60%; height:60%; color:white; fill:white;" viewBox="0 0 24 24">
                        <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                    </svg>
                </div>
                <div>
                    <p style="color:white; font-weight:800; font-size:clamp(13px,1.4vw,20px); line-height:1.2;">Masjid Grand Centerpoint Bekasi</p>
                    <p class="font-arabic" dir="rtl" style="color:#fde68a; font-size:clamp(11px,1.1vw,16px); line-height:1.4;">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
                </div>
            </div>

            {{-- Tanggal Hijri --}}
            <div style="text-align:center;">
                <p class="font-arabic" dir="rtl" style="color:#fde68a; font-size:clamp(11px,1.1vw,15px);" x-data x-text="window.hijriDate ?? ''"></p>
                <p style="color:rgba(255,255,255,0.7); font-size:clamp(9px,0.85vw,12px);">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            </div>

            {{-- Jam --}}
            <div style="text-align:right;" x-data="tvClock()">
                <p style="color:white; font-family:monospace; font-weight:800; font-size:clamp(22px,3.5vw,48px); line-height:1; letter-spacing:2px;" x-text="time">00:00:00</p>
                <p style="color:#86efac; font-size:clamp(9px,0.85vw,12px); margin-top:2px;" x-text="wib">WIB</p>
            </div>
        </div>
    </header>

    {{-- ══ MAIN CONTENT ══ --}}
    <main style="flex:1; display:grid; grid-template-columns: minmax(0,1fr) minmax(0,1.6fr) minmax(0,1fr); overflow:hidden;">

        {{-- ── KIRI: Jadwal Shalat ── --}}
        <div style="background: linear-gradient(180deg, #f0fdf4 0%, #dcfce7 100%); padding: clamp(10px,1.5vh,20px) clamp(10px,1.2vw,18px); display:flex; flex-direction:column; gap:clamp(6px,0.8vh,10px); border-right: 1px solid #bbf7d0; overflow:hidden;">

            {{-- Title --}}
            <div style="text-align:center; margin-bottom:clamp(2px,0.5vh,6px);">
                <p style="font-size:clamp(9px,0.8vw,11px); font-weight:700; letter-spacing:3px; color:#166534; text-transform:uppercase;">Jadwal Shalat</p>
                <p class="font-arabic" dir="rtl" style="color:#ca8a04; font-size:clamp(14px,1.4vw,20px);">مَوَاقِيتُ الصَّلَاةِ</p>
            </div>

            @php
                $shalatTv = [
                    ['key' => 'subuh',   'name' => 'Subuh',   'time' => $shalat?->subuh   ?? '04:34', 'arabic' => 'الفجر'],
                    ['key' => 'syuruq',  'name' => 'Syuruq',  'time' => $shalat?->syuruq  ?? '05:51', 'arabic' => 'الشروق'],
                    ['key' => 'dzuhur',  'name' => 'Dzuhur',  'time' => $shalat?->dzuhur  ?? '11:51', 'arabic' => 'الظهر'],
                    ['key' => 'ashar',   'name' => 'Ashar',   'time' => $shalat?->ashar   ?? '15:08', 'arabic' => 'العصر'],
                    ['key' => 'maghrib', 'name' => 'Maghrib', 'time' => $shalat?->maghrib ?? '17:51', 'arabic' => 'المغرب'],
                    ['key' => 'isya',    'name' => 'Isya',    'time' => $shalat?->isya    ?? '19:01', 'arabic' => 'العشاء'],
                ];
            @endphp

            <div style="display:flex; flex-direction:column; gap:clamp(4px,0.6vh,8px); flex:1;"
                 x-data="prayerHighlight()">
                @foreach($shalatTv as $s)
                <div :class="activePrayer === '{{ $s['key'] }}' ? 'prayer-active' : ''"
                     style="display:flex; align-items:center; justify-content:space-between; background:white; border:1.5px solid #bbf7d0; border-radius:12px; padding: clamp(6px,0.9vh,12px) clamp(10px,1vw,16px); transition: all 0.4s ease;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="position:relative; width:clamp(8px,0.9vw,12px); height:clamp(8px,0.9vw,12px); border-radius:50%; background:#16a34a; flex-shrink:0;"
                             :class="activePrayer === '{{ $s['key'] }}' ? 'pulse-ring' : ''"></div>
                        <div>
                            <p class="prayer-name" style="font-weight:700; color:#14532d; font-size:clamp(11px,1.1vw,15px); line-height:1.2;">{{ $s['name'] }}</p>
                            <p class="prayer-arabic font-arabic" dir="rtl" style="color:#ca8a04; font-size:clamp(12px,1.2vw,17px); line-height:1;">{{ $s['arabic'] }}</p>
                        </div>
                    </div>
                    <p class="prayer-time" style="font-family:monospace; font-weight:800; color:#166534; font-size:clamp(14px,1.5vw,22px);">{{ $s['time'] }}</p>
                </div>
                @endforeach

                {{-- Jumat --}}
                @if($shalat?->jumat ?? false)
                <div style="background: linear-gradient(135deg, #ca8a04, #d97706); border-radius:12px; padding:clamp(6px,0.8vh,10px) clamp(10px,1vw,16px); display:flex; align-items:center; justify-content:space-between;">
                    <p style="color:white; font-weight:700; font-size:clamp(11px,1vw,14px);">Shalat Jumat</p>
                    <p style="color:white; font-family:monospace; font-weight:800; font-size:clamp(13px,1.3vw,18px);">{{ $shalat->jumat }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- ── TENGAH: Live Camera / Pengumuman ── --}}
        <div style="background:#0f172a; display:flex; flex-direction:column; position:relative; overflow:hidden;">

            {{-- Live Camera Area --}}
            <div style="flex:1; position:relative; display:flex; align-items:center; justify-content:center; overflow:hidden;">

                @php
                    $liveUrl = \App\Models\Setting::get('tv_live_url', '');
                    $liveEmbed = '';
                    if ($liveUrl) {
                        // Convert YouTube watch URL to embed
                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $liveUrl, $m)) {
                            $liveEmbed = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&mute=1&controls=0&modestbranding=1&rel=0&showinfo=0&loop=1&playlist=' . $m[1];
                        } elseif (str_contains($liveUrl, 'youtube.com/embed')) {
                            $liveEmbed = $liveUrl;
                        }
                    }
                @endphp

                @if($liveEmbed)
                {{-- YouTube Live Embed --}}
                <iframe src="{{ $liveEmbed }}"
                        style="width:100%; height:100%; border:none; display:block;"
                        allow="autoplay; encrypted-media"
                        allowfullscreen></iframe>
                <div style="position:absolute; top:12px; left:12px; background:#ef4444; color:white; font-size:10px; font-weight:700; padding:3px 10px; border-radius:20px; letter-spacing:1px; display:flex; align-items:center; gap:5px;">
                    <span style="width:6px; height:6px; background:white; border-radius:50%; display:inline-block;"></span> LIVE
                </div>
                @else
                {{-- Placeholder saat tidak ada live stream --}}
                <div style="position:absolute; inset:0; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);"></div>

                {{-- Ornamen arabesk --}}
                <div style="position:absolute; inset:0; opacity:0.04; background-image: radial-gradient(circle at 20% 20%, #16a34a 0%, transparent 50%), radial-gradient(circle at 80% 80%, #ca8a04 0%, transparent 50%);"></div>

                {{-- Konten Pengumuman --}}
                <div style="position:relative; z-index:1; width:100%; padding: clamp(16px,2vw,32px); display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%;"
                     x-data="tvAnnouncement({{ json_encode($displays->where('tipe', 'pengumuman')->values()->toArray()) }})">

                    <template x-if="items.length > 0">
                        <div class="fade-in" :key="current" style="text-align:center; max-width:480px;">
                            <div style="width:clamp(40px,5vw,64px); height:clamp(40px,5vw,64px); background:linear-gradient(135deg,#166534,#16a34a); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto clamp(12px,1.5vh,20px);">
                                <svg style="width:50%; height:50%; color:white; stroke:white; fill:none;" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            </div>
                            <p style="color:#fbbf24; font-size:clamp(9px,0.85vw,12px); font-weight:700; letter-spacing:3px; text-transform:uppercase; margin-bottom:8px;">Pengumuman</p>
                            <h3 style="color:white; font-weight:800; font-size:clamp(16px,1.8vw,26px); line-height:1.3; margin-bottom:clamp(8px,1.2vh,16px);" x-text="items[current]?.judul"></h3>
                            <p style="color:rgba(255,255,255,0.7); font-size:clamp(12px,1.1vw,16px); line-height:1.6;" x-text="items[current]?.konten"></p>

                            {{-- Dot indicator --}}
                            <div style="display:flex; gap:6px; justify-content:center; margin-top:clamp(12px,1.5vh,20px);" x-show="items.length > 1">
                                <template x-for="(item, i) in items" :key="i">
                                    <div :style="i === current ? 'width:20px; background:#16a34a;' : 'width:6px; background:rgba(255,255,255,0.3);'"
                                         style="height:6px; border-radius:3px; transition:all 0.3s;"></div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="items.length === 0">
                        <div style="text-align:center; max-width:480px;">
                            <p class="font-arabic" dir="rtl" style="color:#fde68a; font-size:clamp(18px,2.2vw,32px); line-height:1.6; margin-bottom:16px;">إِنَّمَا يَعْمُرُ مَسَاجِدَ اللَّهِ مَنْ آمَنَ بِاللَّهِ</p>
                            <p style="color:rgba(255,255,255,0.5); font-size:clamp(10px,0.95vw,14px); font-style:italic;">"Hanya yang memakmurkan masjid-masjid Allah ialah orang yang beriman kepada Allah."</p>
                            <p style="color:rgba(255,255,255,0.35); font-size:clamp(9px,0.85vw,12px); margin-top:4px;">QS. At-Taubah: 18</p>
                        </div>
                    </template>
                </div>
                @endif
            </div>

            {{-- Live Camera Label (hanya saat ada live URL) --}}
            @if(!$liveEmbed)
            <div style="position:absolute; bottom: 12px; right: 12px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); border-radius:8px; padding:4px 12px;">
                <p style="color:rgba(255,255,255,0.4); font-size:10px; font-weight:600; letter-spacing:1px;">AREA LIVE CAMERA</p>
            </div>
            @endif
        </div>

        {{-- ── KANAN: Countdown + Info ── --}}
        <div style="background: linear-gradient(180deg, #f0fdf4 0%, #dcfce7 100%); padding: clamp(10px,1.5vh,20px) clamp(10px,1.2vw,18px); display:flex; flex-direction:column; gap:clamp(8px,1vh,14px); border-left: 1px solid #bbf7d0; overflow:hidden;">

            {{-- Countdown --}}
            <div style="background: linear-gradient(135deg, #14532d, #166534); border-radius:16px; padding:clamp(10px,1.5vh,18px) clamp(10px,1.2vw,16px); text-align:center; border:1.5px solid #15803d;"
                 x-data="prayerCountdown()">
                <p style="color:#86efac; font-size:clamp(8px,0.75vw,10px); font-weight:700; letter-spacing:3px; text-transform:uppercase; margin-bottom:4px;">Waktu Menuju Shalat</p>
                <p style="color:#fbbf24; font-weight:800; font-size:clamp(12px,1.2vw,17px); margin-bottom:8px;" x-text="nextPrayer">—</p>
                <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                    <div class="countdown-digit" x-text="hours">00</div>
                    <span style="color:white; font-weight:900; font-size:clamp(16px,2vw,26px); margin-bottom:4px;">:</span>
                    <div class="countdown-digit" x-text="minutes">00</div>
                    <span style="color:white; font-weight:900; font-size:clamp(16px,2vw,26px); margin-bottom:4px;">:</span>
                    <div class="countdown-digit" x-text="seconds">00</div>
                </div>
            </div>

            {{-- Donasi --}}
            <div style="background:white; border:1.5px solid #bbf7d0; border-radius:16px; padding:clamp(10px,1.3vh,16px) clamp(10px,1.2vw,16px);">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:clamp(6px,0.8vh,10px);">
                    <div style="width:clamp(24px,2.2vw,32px); height:clamp(24px,2.2vw,32px); background:linear-gradient(135deg,#166534,#16a34a); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg style="width:55%; height:55%; fill:none; stroke:white; stroke-width:2;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <p style="font-weight:800; color:#14532d; font-size:clamp(11px,1.05vw,14px);">Donasi Masjid</p>
                </div>
                <div style="background:#f0fdf4; border-radius:10px; padding:clamp(6px,0.8vh,10px); margin-bottom:clamp(6px,0.8vh,10px);">
                    <p style="color:#166534; font-size:clamp(9px,0.85vw,12px); line-height:1.6; white-space:pre-line;">{{ \App\Models\Setting::get('donasi_rekening', "Bank Syariah Indonesia\nNo. Rek: 1234567890\na.n. Masjid Grand Centerpoint") }}</p>
                </div>
                <div style="border-top:1px solid #bbf7d0; padding-top:clamp(6px,0.8vh,10px);">
                    <p style="color:#6b7280; font-size:clamp(8px,0.75vw,10px); font-weight:600; letter-spacing:1px; text-transform:uppercase;">Total Donasi Bulan Ini</p>
                    <p style="color:#14532d; font-weight:800; font-size:clamp(14px,1.4vw,20px); margin-top:2px;">
                        Rp {{ number_format(\App\Models\Donasi::confirmed()->whereMonth('confirmed_at', now()->month)->sum('jumlah'), 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Wifi --}}
            <div style="background:white; border:1.5px solid #bbf7d0; border-radius:16px; padding:clamp(10px,1.3vh,16px) clamp(10px,1.2vw,16px);">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:clamp(8px,1vh,12px);">
                    <div style="width:clamp(24px,2.2vw,32px); height:clamp(24px,2.2vw,32px); background:linear-gradient(135deg,#166534,#16a34a); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg style="width:55%; height:55%; fill:none; stroke:white; stroke-width:2;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                    </div>
                    <p style="font-weight:800; color:#14532d; font-size:clamp(11px,1.05vw,14px);">WiFi Masjid</p>
                </div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <div style="background:#f0fdf4; border-radius:8px; padding:clamp(5px,0.7vh,8px) clamp(8px,0.9vw,12px); display:flex; align-items:center; justify-content:space-between;">
                        <span style="color:#6b7280; font-size:clamp(9px,0.8vw,11px);">SSID</span>
                        <span style="color:#14532d; font-weight:700; font-size:clamp(10px,0.95vw,13px);">{{ \App\Models\Setting::get('wifi_ssid', 'MasjidGCP') }}</span>
                    </div>
                    <div style="background:#f0fdf4; border-radius:8px; padding:clamp(5px,0.7vh,8px) clamp(8px,0.9vw,12px); display:flex; align-items:center; justify-content:space-between;">
                        <span style="color:#6b7280; font-size:clamp(9px,0.8vw,11px);">Password</span>
                        <span style="color:#14532d; font-weight:700; font-size:clamp(10px,0.95vw,13px); font-family:monospace;">{{ \App\Models\Setting::get('wifi_password', 'masjidgcp2024') }}</span>
                    </div>
                </div>
            </div>

            {{-- Kegiatan Hari Ini --}}
            @php
                $kegiatanHariIni = \App\Models\Kegiatan::whereDate('tanggal', today())->take(2)->get();
            @endphp
            @if($kegiatanHariIni->count() > 0)
            <div style="background:white; border:1.5px solid #bbf7d0; border-radius:16px; padding:clamp(10px,1.3vh,16px) clamp(10px,1.2vw,16px); flex:1; overflow:hidden;">
                <p style="font-weight:800; color:#14532d; font-size:clamp(10px,1vw,13px); margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                    <span style="width:6px; height:6px; background:#16a34a; border-radius:50%; display:inline-block;"></span>
                    Kegiatan Hari Ini
                </p>
                @foreach($kegiatanHariIni as $kg)
                <div style="background:#f0fdf4; border-radius:8px; padding:clamp(5px,0.7vh,8px) clamp(8px,0.9vw,12px); margin-bottom:4px;">
                    <p style="color:#14532d; font-weight:700; font-size:clamp(9px,0.85vw,12px);">{{ $kg->judul }}</p>
                    @if($kg->waktu)
                    <p style="color:#6b7280; font-size:clamp(8px,0.75vw,10px);">{{ $kg->waktu }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </main>

    {{-- ══ RUNNING TEXT ══ --}}
    <div style="background: linear-gradient(90deg, #14532d, #166534, #14532d); border-top:2px solid #ca8a04; padding: clamp(5px,0.7vh,9px) 0; overflow:hidden; flex-shrink:0;">
        @php
            $runningText = \App\Models\Setting::get('running_text', 'Selamat datang di Masjid Grand Centerpoint Bekasi · Semoga Allah senantiasa meridhoi langkah kita · Aamiin');
        @endphp
        <div style="overflow:hidden; white-space:nowrap;">
            <span class="marquee-inner" style="color:white; font-size:clamp(11px,1.1vw,15px); font-weight:500; padding-right:80px;">
                &#9654; &nbsp; {{ $runningText }} &nbsp;&nbsp;&nbsp; ✦ &nbsp;&nbsp;&nbsp; {{ $runningText }} &nbsp;&nbsp;&nbsp; ✦ &nbsp;&nbsp;&nbsp; {{ $runningText }}
            </span>
        </div>
    </div>

</div>

<script>
window.prayerTimes = {
    subuh:   '{{ $shalat?->subuh   ?? "04:34" }}',
    syuruq:  '{{ $shalat?->syuruq  ?? "05:51" }}',
    dzuhur:  '{{ $shalat?->dzuhur  ?? "11:51" }}',
    ashar:   '{{ $shalat?->ashar   ?? "15:08" }}',
    maghrib: '{{ $shalat?->maghrib ?? "17:51" }}',
    isya:    '{{ $shalat?->isya    ?? "19:01" }}',
};

// ── Clock ──
function tvClock() {
    return {
        time: '00:00:00',
        wib: 'WIB',
        init() {
            this.tick();
            setInterval(() => this.tick(), 1000);
        },
        tick() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2,'0');
            const m = String(now.getMinutes()).padStart(2,'0');
            const s = String(now.getSeconds()).padStart(2,'0');
            this.time = `${h}:${m}:${s}`;
            this.wib  = 'WIB';
        }
    }
}

// ── Prayer Highlight (active prayer) ──
function prayerHighlight() {
    return {
        activePrayer: null,
        init() {
            this.update();
            setInterval(() => this.update(), 60000);
        },
        update() {
            const now   = new Date();
            const nowMin = now.getHours() * 60 + now.getMinutes();
            const times  = window.prayerTimes;
            const toMin  = t => { const [h,m] = t.split(':').map(Number); return h*60+m; };
            const keys   = ['subuh','syuruq','dzuhur','ashar','maghrib','isya'];
            const mins   = keys.map(k => toMin(times[k]));
            let active   = null;
            for (let i = keys.length - 1; i >= 0; i--) {
                if (nowMin >= mins[i]) { active = keys[i]; break; }
            }
            this.activePrayer = active;
        }
    }
}

// ── Prayer Countdown ──
function prayerCountdown() {
    return {
        nextPrayer: '—',
        hours:   '00',
        minutes: '00',
        seconds: '00',
        init() {
            this.update();
            setInterval(() => this.update(), 1000);
        },
        update() {
            const now   = new Date();
            const nowSec = now.getHours()*3600 + now.getMinutes()*60 + now.getSeconds();
            const labels = { subuh:'Subuh', syuruq:'Syuruq', dzuhur:'Dzuhur', ashar:'Ashar', maghrib:'Maghrib', isya:'Isya' };
            const times  = window.prayerTimes;
            const toSec  = t => { const [h,m] = t.split(':').map(Number); return h*3600+m*60; };

            let minDiff = Infinity, target = null;
            for (const [key, label] of Object.entries(labels)) {
                let diff = toSec(times[key]) - nowSec;
                if (diff < 0) diff += 86400;
                if (diff < minDiff) { minDiff = diff; target = label; }
            }

            this.nextPrayer = target ?? '—';
            this.hours   = String(Math.floor(minDiff / 3600)).padStart(2,'0');
            this.minutes = String(Math.floor((minDiff % 3600) / 60)).padStart(2,'0');
            this.seconds = String(minDiff % 60).padStart(2,'0');
        }
    }
}

// ── Announcement Carousel ──
function tvAnnouncement(items) {
    return {
        items: items,
        current: 0,
        init() {
            if (this.items.length > 1) {
                setInterval(() => {
                    this.current = (this.current + 1) % this.items.length;
                }, 10000);
            }
        }
    }
}
</script>

</body>
</html>
