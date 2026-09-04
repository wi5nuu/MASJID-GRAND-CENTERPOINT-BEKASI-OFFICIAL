@extends('layouts.admin')

@section('title', 'Pengaturan Layout TV')
@section('breadcrumb')
    <a href="{{ route('admin.tv.index') }}" class="text-neutral-400 hover:text-neutral-600 text-sm">TV Display</a>
    <span class="text-neutral-300 mx-2">/</span>
    <span class="text-neutral-600 text-sm font-medium">Pengaturan Layout</span>
@endsection

@section('content')
<div x-data="tvLayoutEditor()">

    {{-- Header --}}
    <div class="flex items-center justify-between flex-wrap gap-3 mb-5">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">Pengaturan Layout TV</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Atur tampilan, ukuran kolom, dan konten TV Display secara real-time</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('tv.display') }}" target="_blank"
               class="inline-flex items-center gap-2 border border-primary-600 text-primary-600 hover:bg-primary-50 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Buka TV Display
            </a>
            <a href="{{ route('admin.tv.index') }}"
               class="inline-flex items-center gap-2 border border-neutral-300 text-neutral-600 hover:bg-neutral-50 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                Kelola Konten
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">{{ session('success') }}</div>
    @endif

    {{-- Side-by-side layout: settings kiri, preview kanan --}}
    <form action="{{ route('admin.tv.layout.update') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns: 360px 1fr; gap:20px; align-items:start;">

            {{-- ── KIRI: Settings Panel (scrollable) ── --}}
            <div class="space-y-4" style="min-width:0;">

                {{-- Layout Kolom --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h2 class="font-bold text-neutral-900 text-sm mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold">⊞</span>
                        Layout Kolom
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Lebar Kiri (Jadwal Shalat)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="parseFloat(colKiri).toFixed(1) + 'fr'"></span>
                            </div>
                            <input type="range" name="tv_col_kiri" min="0.5" max="2.5" step="0.1" x-model="colKiri" class="w-full accent-primary-600">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Lebar Tengah (Live Camera)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="parseFloat(colTengah).toFixed(1) + 'fr'"></span>
                            </div>
                            <input type="range" name="tv_col_tengah" min="0.5" max="4.5" step="0.1" x-model="colTengah" class="w-full accent-primary-600">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Lebar Kanan (Info)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="parseFloat(colKanan).toFixed(1) + 'fr'"></span>
                            </div>
                            <input type="range" name="tv_col_kanan" min="0.5" max="2.5" step="0.1" x-model="colKanan" class="w-full accent-primary-600">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Tinggi Header (px)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="headerHeight + 'px'"></span>
                            </div>
                            <input type="range" name="tv_header_height" min="40" max="120" step="4" x-model="headerHeight" class="w-full accent-primary-600">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Tinggi Footer Running Text (px)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="footerHeight + 'px'"></span>
                            </div>
                            <input type="range" name="tv_footer_height" min="20" max="80" step="2" x-model="footerHeight" class="w-full accent-primary-600">
                        </div>
                    </div>
                </div>

                {{-- Tampilkan/Sembunyikan Elemen --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h2 class="font-bold text-neutral-900 text-sm mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold">👁</span>
                        Tampilkan Elemen
                    </h2>
                    <div class="space-y-2.5">
                        @foreach([
                            'tv_show_kiri'       => ['Kolom Kiri (Jadwal Shalat)', 'showKiri'],
                            'tv_show_kanan'      => ['Kolom Kanan (Info)',          'showKanan'],
                            'tv_show_footer'     => ['Footer Running Text',         'showFooter'],
                            'tv_show_shalat_jum' => ['Jadwal Shalat Jumat',         null],
                            'tv_show_countdown'  => ['Countdown Waktu Shalat',      'showCountdown'],
                            'tv_show_donasi'     => ['Info Donasi',                 'showDonasi'],
                            'tv_show_wifi'       => ['Info WiFi',                   'showWifi'],
                            'tv_show_kegiatan'   => ['Kegiatan Hari Ini',           null],
                        ] as $key => [$label, $model])
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative flex-shrink-0">
                                <input type="checkbox" name="{{ $key }}" value="1"
                                       {{ ($settings[$key] ?? '1') === '1' ? 'checked' : '' }}
                                       {{ $model ? 'x-model="'.$model.'"' : '' }}
                                       class="sr-only peer">
                                <div class="w-9 h-5 bg-neutral-200 peer-checked:bg-primary-600 rounded-full transition-colors"></div>
                                <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                            </div>
                            <span class="text-xs font-medium text-neutral-700 group-hover:text-neutral-900">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Stream / Live Camera --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h2 class="font-bold text-neutral-900 text-sm mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-red-100 text-red-600 rounded-lg flex items-center justify-center text-xs font-bold">▶</span>
                        Live Stream / CCTV
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1.5">Mode Stream</label>
                            <select name="stream_mode" class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="youtube" {{ ($settings['stream_mode'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube Live</option>
                                <option value="hls"     {{ ($settings['stream_mode'] ?? '') === 'hls'     ? 'selected' : '' }}>CCTV via go2rtc (HLS)</option>
                                <option value="none"    {{ ($settings['stream_mode'] ?? '') === 'none'    ? 'selected' : '' }}>Tidak ada (tampilkan pengumuman)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1.5">URL YouTube Live</label>
                            <input type="url" name="tv_live_url" value="{{ $settings['tv_live_url'] ?? '' }}"
                                   placeholder="https://youtube.com/watch?v=..."
                                   class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1.5">Nama Kamera go2rtc</label>
                            <input type="text" name="stream_camera_name" value="{{ $settings['stream_camera_name'] ?? '' }}"
                                   placeholder="kamera-utama"
                                   class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <p class="text-xs text-neutral-400 mt-1">Nama stream sesuai go2rtc.yaml</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1.5">Label Stream</label>
                            <input type="text" name="stream_label" value="{{ $settings['stream_label'] ?? 'Live Masjid' }}"
                                   class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <div class="relative flex-shrink-0">
                                <input type="checkbox" name="stream_is_live" value="1"
                                       {{ ($settings['stream_is_live'] ?? '0') === '1' ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-9 h-5 bg-neutral-200 peer-checked:bg-red-500 rounded-full transition-colors"></div>
                                <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                            </div>
                            <span class="text-xs font-medium text-neutral-700">Tampilkan badge LIVE</span>
                        </label>
                    </div>
                </div>

                {{-- Konten Info --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h2 class="font-bold text-neutral-900 text-sm mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold">✎</span>
                        Konten Info
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1.5">SSID WiFi</label>
                            <input type="text" name="wifi_ssid" value="{{ $settings['wifi_ssid'] ?? 'MasjidGCP' }}"
                                   class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1.5">Password WiFi</label>
                            <input type="text" name="wifi_password" value="{{ $settings['wifi_password'] ?? '' }}"
                                   class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1.5">Info Rekening Donasi</label>
                            <textarea name="donasi_rekening" rows="3"
                                      class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ $settings['donasi_rekening'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1.5">Running Text</label>
                            <textarea name="running_text" rows="2"
                                      class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ $settings['running_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Save button --}}
                <button type="submit"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold text-sm py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pengaturan
                </button>
            </div>

            {{-- ── KANAN: Live Preview (sticky) ── --}}
            <div style="position:sticky; top:80px; min-width:0;">
                <div class="bg-white rounded-2xl border border-neutral-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-bold text-neutral-700 uppercase tracking-widest">Live Preview</p>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-neutral-400 bg-neutral-100 px-2 py-1 rounded-lg">16:9 — proporsional</span>
                            <a href="{{ route('tv.display') }}" target="_blank"
                               class="text-xs text-primary-600 hover:text-primary-700 bg-primary-50 hover:bg-primary-100 px-2 py-1 rounded-lg transition-colors">
                               Buka fullscreen →
                            </a>
                        </div>
                    </div>

                    {{-- TV Screen Preview --}}
                    <div class="rounded-xl overflow-hidden border-2 border-neutral-800 shadow-2xl bg-neutral-900"
                         style="aspect-ratio:16/9; position:relative;">
                        <div style="position:absolute; inset:0; display:flex; flex-direction:column; font-family:'Plus Jakarta Sans',sans-serif; overflow:hidden;">

                            {{-- Header --}}
                            <div :style="'height:'+Math.round(headerHeight/6)+'%; min-height:12px; flex-shrink:0; background:linear-gradient(135deg,#14532d,#166534); border-bottom:1.5px solid #ca8a04; display:flex; align-items:center; padding:0 8px; gap:6px;'">
                                <div style="width:12px; height:12px; background:rgba(255,255,255,0.15); border:1px solid #fbbf24; border-radius:2px; flex-shrink:0;"></div>
                                <div style="flex:1; min-width:0;">
                                    <div style="color:white; font-weight:800; font-size:clamp(5px,0.9vw,8px); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Masjid Grand Centerpoint Bekasi</div>
                                    <div style="color:#fde68a; font-size:clamp(4px,0.7vw,6px); direction:rtl;">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
                                </div>
                                <div style="text-align:right; flex-shrink:0;">
                                    <div style="color:white; font-family:monospace; font-weight:800; font-size:clamp(7px,1.2vw,11px);">09:08:24</div>
                                    <div style="color:#86efac; font-size:clamp(3px,0.5vw,5px);">WIB</div>
                                </div>
                            </div>

                            {{-- Grid --}}
                            <div style="flex:1; display:grid; overflow:hidden; min-height:0;"
                                 :style="'grid-template-columns:' + (showKiri ? parseFloat(colKiri)+'fr ' : '') + parseFloat(colTengah)+'fr' + (showKanan ? ' '+parseFloat(colKanan)+'fr' : '')">

                                {{-- Kiri --}}
                                <div x-show="showKiri" x-cloak
                                     style="background:linear-gradient(180deg,#f0fdf4,#dcfce7); border-right:1px solid #bbf7d0; padding:3px 4px; display:flex; flex-direction:column; gap:1.5px; overflow:hidden;">
                                    <div style="text-align:center; padding-bottom:1px;">
                                        <div style="font-size:clamp(4px,0.6vw,5px); font-weight:700; color:#166534; letter-spacing:1.5px; text-transform:uppercase;">JADWAL SHALAT</div>
                                    </div>
                                    @foreach([['Subuh','04:34'],['Syuruq','05:51'],['Dzuhur','11:51'],['Ashar','15:08'],['Maghrib','17:51'],['Isya','19:01']] as [$n,$t])
                                    <div style="background:white; border:1px solid #bbf7d0; border-radius:2px; padding:1.5px 3px; display:flex; justify-content:space-between; align-items:center; flex-shrink:0;">
                                        <span style="font-weight:700; color:#14532d; font-size:clamp(4px,0.65vw,6px);">{{ $n }}</span>
                                        <span style="font-family:monospace; font-weight:800; color:#166534; font-size:clamp(4px,0.7vw,7px);">{{ $t }}</span>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Tengah --}}
                                <div style="background:#0a0f1a; position:relative; display:flex; align-items:center; justify-content:center;">
                                    <div style="position:absolute; inset:0; opacity:0.08; background:radial-gradient(circle at 20% 20%,#16a34a,transparent 55%),radial-gradient(circle at 80% 80%,#ca8a04,transparent 55%);"></div>
                                    <div style="position:relative; z-index:1; text-align:center;">
                                        <div style="color:rgba(255,255,255,0.25); font-size:clamp(5px,0.8vw,7px); font-weight:600; letter-spacing:1.5px; text-transform:uppercase;">AREA LIVE CAMERA</div>
                                        <div style="color:rgba(255,255,255,0.12); font-size:clamp(4px,0.6vw,5px); margin-top:2px;">CCTV / YouTube Live</div>
                                    </div>
                                </div>

                                {{-- Kanan --}}
                                <div x-show="showKanan" x-cloak
                                     style="background:linear-gradient(180deg,#f0fdf4,#dcfce7); border-left:1px solid #bbf7d0; padding:3px 4px; display:flex; flex-direction:column; gap:2px; overflow:hidden;">
                                    <div x-show="showCountdown"
                                         style="background:linear-gradient(135deg,#14532d,#166534); border-radius:3px; padding:2px 3px; text-align:center; flex-shrink:0;">
                                        <div style="color:#86efac; font-size:clamp(3px,0.45vw,4px); font-weight:700; letter-spacing:0.5px; text-transform:uppercase;">Waktu Menuju Shalat</div>
                                        <div style="color:#fbbf24; font-size:clamp(4px,0.6vw,5px); font-weight:800; margin-top:1px;">Dzuhur</div>
                                        <div style="display:flex; justify-content:center; gap:1px; margin-top:1px;">
                                            <div style="background:rgba(255,255,255,0.15); color:white; font-size:clamp(5px,0.8vw,7px); font-weight:800; padding:1px 2px; border-radius:1.5px;">02</div>
                                            <span style="color:white; font-weight:900; font-size:clamp(5px,0.7vw,6px);">:</span>
                                            <div style="background:rgba(255,255,255,0.15); color:white; font-size:clamp(5px,0.8vw,7px); font-weight:800; padding:1px 2px; border-radius:1.5px;">53</div>
                                            <span style="color:white; font-weight:900; font-size:clamp(5px,0.7vw,6px);">:</span>
                                            <div style="background:rgba(255,255,255,0.15); color:white; font-size:clamp(5px,0.8vw,7px); font-weight:800; padding:1px 2px; border-radius:1.5px;">24</div>
                                        </div>
                                    </div>
                                    <div x-show="showDonasi"
                                         style="background:white; border:1px solid #bbf7d0; border-radius:2px; padding:2px 3px; flex-shrink:0;">
                                        <div style="font-weight:800; color:#14532d; font-size:clamp(3px,0.5vw,5px); margin-bottom:0.5px;">Donasi Masjid</div>
                                        <div style="color:#166534; font-size:clamp(3px,0.45vw,4px);">Bank Syariah Indonesia</div>
                                    </div>
                                    <div x-show="showWifi"
                                         style="background:white; border:1px solid #bbf7d0; border-radius:2px; padding:2px 3px; flex-shrink:0;">
                                        <div style="font-weight:800; color:#14532d; font-size:clamp(3px,0.5vw,5px); margin-bottom:0.5px;">WiFi Masjid</div>
                                        <div style="display:flex; justify-content:space-between; background:#f0fdf4; border-radius:1.5px; padding:1px 2px;">
                                            <span style="color:#6b7280; font-size:clamp(3px,0.4vw,4px);">SSID</span>
                                            <span style="color:#14532d; font-weight:700; font-size:clamp(3px,0.4vw,4px);">MasjidGCP</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div x-show="showFooter" x-cloak
                                 :style="'height:'+Math.round(footerHeight/4)+'%; min-height:6px; flex-shrink:0; background:linear-gradient(90deg,#14532d,#166534); border-top:1px solid #ca8a04; display:flex; align-items:center; overflow:hidden;'">
                                <div style="color:white; font-size:clamp(4px,0.6vw,5px); white-space:nowrap; padding:0 6px; opacity:0.9;">
                                    ▶ &nbsp; Selamat datang di Masjid Grand Centerpoint Bekasi &nbsp; ✦ &nbsp; Selamat datang di Masjid Grand Centerpoint Bekasi
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info proporsi kolom --}}
                    <div class="mt-3 flex items-center gap-3 flex-wrap text-xs text-neutral-500">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-green-200 border border-green-400 inline-block"></span>
                            <span x-text="'Kiri: ' + parseFloat(colKiri).toFixed(1) + 'fr'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-slate-800 border border-slate-600 inline-block"></span>
                            <span x-text="'Tengah: ' + parseFloat(colTengah).toFixed(1) + 'fr'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-green-200 border border-green-400 inline-block"></span>
                            <span x-text="'Kanan: ' + parseFloat(colKanan).toFixed(1) + 'fr'"></span>
                        </div>
                        <div class="ml-auto text-neutral-400">
                            Rasio tengah: <span class="font-mono text-primary-600" x-text="Math.round(parseFloat(colTengah) / (parseFloat(colKiri) + parseFloat(colTengah) + parseFloat(colKanan)) * 100) + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function tvLayoutEditor() {
    return {
        colKiri:      {{ $settings['tv_col_kiri']   ?? 1.1 }},
        colTengah:    {{ $settings['tv_col_tengah'] ?? 1.8 }},
        colKanan:     {{ $settings['tv_col_kanan']  ?? 1.1 }},
        headerHeight: {{ $settings['tv_header_height'] ?? 64 }},
        footerHeight: {{ $settings['tv_footer_height'] ?? 36 }},
        showKiri:     {{ ($settings['tv_show_kiri']      ?? '1') === '1' ? 'true' : 'false' }},
        showKanan:    {{ ($settings['tv_show_kanan']     ?? '1') === '1' ? 'true' : 'false' }},
        showFooter:   {{ ($settings['tv_show_footer']    ?? '1') === '1' ? 'true' : 'false' }},
        showCountdown:{{ ($settings['tv_show_countdown'] ?? '1') === '1' ? 'true' : 'false' }},
        showDonasi:   {{ ($settings['tv_show_donasi']    ?? '1') === '1' ? 'true' : 'false' }},
        showWifi:     {{ ($settings['tv_show_wifi']      ?? '1') === '1' ? 'true' : 'false' }},

        updatePreview() {
            // Preview updates reactively via x-bind/x-show — no extra JS needed
        },
    }
}
</script>
@endpush
