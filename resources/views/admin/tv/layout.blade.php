@extends('layouts.admin')

@section('title', 'Pengaturan Layout TV')
@section('breadcrumb')
    <a href="{{ route('admin.tv.index') }}" class="text-neutral-400 hover:text-neutral-600 text-sm">TV Display</a>
    <span class="text-neutral-300 mx-2">/</span>
    <span class="text-neutral-600 text-sm font-medium">Pengaturan Layout</span>
@endsection

@section('content')
<div x-data="tvLayoutEditor()" class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between flex-wrap gap-3">
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
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.tv.layout.update') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ── Panel Kiri: Settings ── --}}
            <div class="xl:col-span-1 space-y-4">

                {{-- Layout Kolom --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h2 class="font-bold text-neutral-900 text-sm mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center text-xs">⊞</span>
                        Layout Kolom
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Lebar Kiri (Jadwal Shalat)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="colKiri + 'fr'">1.1fr</span>
                            </div>
                            <input type="range" name="tv_col_kiri" min="0.5" max="2.5" step="0.1"
                                   x-model="colKiri" @input="updatePreview()"
                                   class="w-full accent-primary-600">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Lebar Tengah (Live Camera)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="colTengah + 'fr'">1.8fr</span>
                            </div>
                            <input type="range" name="tv_col_tengah" min="0.5" max="4" step="0.1"
                                   x-model="colTengah" @input="updatePreview()"
                                   class="w-full accent-primary-600">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Lebar Kanan (Info)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="colKanan + 'fr'">1.1fr</span>
                            </div>
                            <input type="range" name="tv_col_kanan" min="0.5" max="2.5" step="0.1"
                                   x-model="colKanan" @input="updatePreview()"
                                   class="w-full accent-primary-600">
                        </div>

                        {{-- Header height --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Tinggi Header (px)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="headerHeight + 'px'">64px</span>
                            </div>
                            <input type="range" name="tv_header_height" min="40" max="120" step="4"
                                   x-model="headerHeight" @input="updatePreview()"
                                   class="w-full accent-primary-600">
                        </div>

                        {{-- Footer height --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Tinggi Footer Running Text (px)</label>
                                <span class="text-xs font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded-lg" x-text="footerHeight + 'px'">36px</span>
                            </div>
                            <input type="range" name="tv_footer_height" min="20" max="80" step="2"
                                   x-model="footerHeight" @input="updatePreview()"
                                   class="w-full accent-primary-600">
                        </div>
                    </div>
                </div>

                {{-- Tampilkan/Sembunyikan Elemen --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h2 class="font-bold text-neutral-900 text-sm mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center text-xs">👁</span>
                        Tampilkan Elemen
                    </h2>
                    <div class="space-y-2.5">
                        @foreach([
                            'tv_show_kiri'       => 'Kolom Kiri (Jadwal Shalat)',
                            'tv_show_kanan'      => 'Kolom Kanan (Info)',
                            'tv_show_footer'     => 'Footer Running Text',
                            'tv_show_shalat_jum' => 'Jadwal Shalat Jumat',
                            'tv_show_countdown'  => 'Countdown Waktu Shalat',
                            'tv_show_donasi'     => 'Info Donasi',
                            'tv_show_wifi'       => 'Info WiFi',
                            'tv_show_kegiatan'   => 'Kegiatan Hari Ini',
                        ] as $key => $label)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="{{ $key }}" value="1"
                                       {{ ($settings[$key] ?? '1') === '1' ? 'checked' : '' }}
                                       @change="updatePreview()"
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
                        <span class="w-6 h-6 bg-red-100 text-red-600 rounded-lg flex items-center justify-center text-xs">▶</span>
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
                            <div class="relative">
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
                        <span class="w-6 h-6 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center text-xs">✎</span>
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

            {{-- ── Panel Kanan: Live Preview ── --}}
            <div class="xl:col-span-2">
                <div class="bg-white rounded-2xl border border-neutral-200 p-4 sticky top-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-bold text-neutral-700 uppercase tracking-widest">Live Preview</p>
                        <span class="text-xs text-neutral-400 bg-neutral-100 px-2 py-1 rounded-lg">Proporsional — bukan skala penuh</span>
                    </div>

                    {{-- Preview screen --}}
                    <div class="rounded-xl overflow-hidden border-2 border-neutral-800 shadow-xl bg-neutral-900"
                         style="aspect-ratio: 16/9; position:relative;">

                        {{-- Preview inner --}}
                        <div style="position:absolute; inset:0; display:flex; flex-direction:column; font-size:8px; font-family:'Plus Jakarta Sans',sans-serif;">

                            {{-- Header preview --}}
                            <div :style="'background:linear-gradient(135deg,#14532d,#166534); border-bottom:2px solid #ca8a04; height:' + (headerHeight/6) + '%; flex-shrink:0; display:flex; align-items:center; padding:0 8px; gap:6px;'"
                                 style="min-height:14px;">
                                <div style="width:14px; height:14px; background:rgba(255,255,255,0.15); border:1px solid #fbbf24; border-radius:3px; flex-shrink:0;"></div>
                                <div style="flex:1;">
                                    <div style="color:white; font-weight:800; font-size:7px; line-height:1.2;">Masjid Grand Centerpoint Bekasi</div>
                                    <div style="color:#fde68a; font-size:6px; direction:rtl;">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
                                </div>
                                <div style="text-align:right;">
                                    <div style="color:white; font-family:monospace; font-weight:800; font-size:10px;">09:08:24</div>
                                    <div style="color:#86efac; font-size:5px;">WIB</div>
                                </div>
                            </div>

                            {{-- Main grid preview --}}
                            <div style="flex:1; overflow:hidden; display:grid;"
                                 :style="'grid-template-columns: ' + (showKiri ? colKiri+'fr ' : '') + colTengah + 'fr' + (showKanan ? ' '+colKanan+'fr' : '')">

                                {{-- Kiri --}}
                                <div x-show="showKiri" style="background:linear-gradient(180deg,#f0fdf4,#dcfce7); border-right:1px solid #bbf7d0; padding:4px; display:flex; flex-direction:column; gap:2px; overflow:hidden;">
                                    <div style="text-align:center; margin-bottom:2px;">
                                        <div style="font-size:5px; font-weight:700; color:#166534; letter-spacing:2px; text-transform:uppercase;">JADWAL SHALAT</div>
                                    </div>
                                    @foreach([['Subuh','04:34'],['Syuruq','05:51'],['Dzuhur','11:51'],['Ashar','15:08'],['Maghrib','17:51'],['Isya','19:01']] as [$n,$t])
                                    <div style="background:white; border:1px solid #bbf7d0; border-radius:3px; padding:2px 4px; display:flex; justify-content:space-between; align-items:center;">
                                        <span style="font-weight:700; color:#14532d; font-size:6px;">{{ $n }}</span>
                                        <span style="font-family:monospace; font-weight:800; color:#166534; font-size:7px;">{{ $t }}</span>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Tengah --}}
                                <div style="background:#0a0f1a; display:flex; align-items:center; justify-content:center; position:relative;">
                                    <div style="position:absolute; inset:0; opacity:0.07; background:radial-gradient(circle at 20% 20%,#16a34a 0%,transparent 55%),radial-gradient(circle at 80% 80%,#ca8a04 0%,transparent 55%);"></div>
                                    <div style="position:relative; z-index:1; text-align:center;">
                                        <div style="color:rgba(255,255,255,0.2); font-size:6px; font-weight:600; letter-spacing:1.5px;">AREA LIVE CAMERA</div>
                                        <div style="color:rgba(255,255,255,0.1); font-size:5px; margin-top:2px;">CCTV / YouTube Live</div>
                                    </div>
                                </div>

                                {{-- Kanan --}}
                                <div x-show="showKanan" style="background:linear-gradient(180deg,#f0fdf4,#dcfce7); border-left:1px solid #bbf7d0; padding:4px; display:flex; flex-direction:column; gap:2px; overflow:hidden;">
                                    <div x-show="showCountdown" style="background:linear-gradient(135deg,#14532d,#166534); border-radius:4px; padding:3px 4px; text-align:center;">
                                        <div style="color:#86efac; font-size:4px; font-weight:700; letter-spacing:1px; text-transform:uppercase; margin-bottom:1px;">Waktu Menuju Shalat</div>
                                        <div style="color:#fbbf24; font-size:5px; font-weight:800;">Dzuhur</div>
                                        <div style="display:flex; justify-content:center; gap:2px; margin-top:1px;">
                                            <div style="background:rgba(255,255,255,0.15); color:white; font-size:7px; font-weight:800; padding:1px 3px; border-radius:2px;">02</div>
                                            <span style="color:white; font-weight:900;">:</span>
                                            <div style="background:rgba(255,255,255,0.15); color:white; font-size:7px; font-weight:800; padding:1px 3px; border-radius:2px;">53</div>
                                            <span style="color:white; font-weight:900;">:</span>
                                            <div style="background:rgba(255,255,255,0.15); color:white; font-size:7px; font-weight:800; padding:1px 3px; border-radius:2px;">24</div>
                                        </div>
                                    </div>
                                    <div x-show="showDonasi" style="background:white; border:1px solid #bbf7d0; border-radius:3px; padding:2px 4px;">
                                        <div style="font-weight:800; color:#14532d; font-size:5px; margin-bottom:1px;">Donasi Masjid</div>
                                        <div style="color:#166534; font-size:5px; line-height:1.5;">Bank Syariah Indonesia</div>
                                    </div>
                                    <div x-show="showWifi" style="background:white; border:1px solid #bbf7d0; border-radius:3px; padding:2px 4px;">
                                        <div style="font-weight:800; color:#14532d; font-size:5px; margin-bottom:1px;">WiFi Masjid</div>
                                        <div style="display:flex; justify-content:space-between; background:#f0fdf4; border-radius:2px; padding:1px 2px;">
                                            <span style="color:#6b7280; font-size:4px;">SSID</span>
                                            <span style="color:#14532d; font-weight:700; font-size:4px;">MasjidGCP</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer preview --}}
                            <div x-show="showFooter"
                                 :style="'background:linear-gradient(90deg,#14532d,#166534); border-top:1px solid #ca8a04; height:' + (footerHeight/4) + '%; flex-shrink:0; display:flex; align-items:center; overflow:hidden;'"
                                 style="min-height:8px;">
                                <div style="color:white; font-size:5px; white-space:nowrap; padding:0 6px;">▶ &nbsp; Selamat datang di Masjid Grand Centerpoint Bekasi &nbsp; ✦ &nbsp; Selamat datang di Masjid Grand Centerpoint Bekasi</div>
                            </div>
                        </div>
                    </div>

                    {{-- Proporsi info --}}
                    <div class="mt-3 flex items-center gap-3 flex-wrap">
                        <div class="flex items-center gap-2 text-xs text-neutral-500">
                            <span class="w-3 h-3 rounded bg-green-200 border border-green-400 inline-block"></span>
                            <span x-text="'Kiri: ' + colKiri + 'fr'">Kiri: 1.1fr</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-neutral-500">
                            <span class="w-3 h-3 rounded bg-slate-700 border border-slate-500 inline-block"></span>
                            <span x-text="'Tengah: ' + colTengah + 'fr'">Tengah: 1.8fr</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-neutral-500">
                            <span class="w-3 h-3 rounded bg-green-200 border border-green-400 inline-block"></span>
                            <span x-text="'Kanan: ' + colKanan + 'fr'">Kanan: 1.1fr</span>
                        </div>
                        <div class="ml-auto text-xs text-neutral-400">
                            Total: <span x-text="(parseFloat(colKiri) + parseFloat(colTengah) + parseFloat(colKanan)).toFixed(1) + 'fr'"></span>
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
