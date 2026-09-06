@extends('layouts.admin')

@section('title', 'Pengaturan Layout TV')
@section('breadcrumb')
    <a href="{{ route('admin.tv.index') }}" class="text-neutral-400 hover:text-neutral-600 text-sm">TV Display</a>
    <span class="text-neutral-300 mx-2">/</span>
    <span class="text-neutral-600 text-sm font-medium">Pengaturan Layout</span>
@endsection

@section('content')
<div x-data="tvLayoutEditor()">

    {{-- Page Header --}}
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

    @if(session('success'))
    <div class="bg-primary-50 border border-primary-200 text-primary-800 text-sm px-4 py-3 rounded-xl mb-5 flex items-center gap-2"><svg class="w-4 h-4 shrink-0 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.tv.layout.update') }}" method="POST">
        @csrf

        {{-- Grid 2 kolom di desktop, 1 kolom di mobile --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

            {{-- KOLOM KIRI: Layout Kolom + Tampilkan Elemen --}}
            <div class="space-y-4">

                {{-- 1. Layout Kolom --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <p class="text-sm font-bold text-neutral-800 mb-4">Layout Kolom</p>
                    <div class="space-y-4">
                        @foreach([
                            ['tv_col_kiri',   'colKiri',   'Lebar Kiri — Jadwal Shalat', 0.5, 2.5, 0.1],
                            ['tv_col_tengah', 'colTengah', 'Lebar Tengah — Live Camera', 0.5, 4.5, 0.1],
                            ['tv_col_kanan',  'colKanan',  'Lebar Kanan — Info',         0.5, 2.5, 0.1],
                        ] as [$name, $model, $label, $min, $max, $step])
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-medium text-neutral-600">{{ $label }}</span>
                                <span class="text-xs font-mono font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-md"
                                      x-text="parseFloat({{ $model }}).toFixed(1) + 'fr'"></span>
                            </div>
                            <input type="range" name="{{ $name }}" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}"
                                   x-model="{{ $model }}" class="w-full accent-primary-600 h-1.5">
                        </div>
                        @endforeach

                        <div class="border-t border-neutral-100 pt-4 grid grid-cols-2 gap-4">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-medium text-neutral-600">Tinggi Header</span>
                                    <span class="text-xs font-mono font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-md"
                                          x-text="headerHeight + 'px'"></span>
                                </div>
                                <input type="range" name="tv_header_height" min="40" max="120" step="4"
                                       x-model="headerHeight" class="w-full accent-primary-600 h-1.5">
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-medium text-neutral-600">Tinggi Footer</span>
                                    <span class="text-xs font-mono font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-md"
                                          x-text="footerHeight + 'px'"></span>
                                </div>
                                <input type="range" name="tv_footer_height" min="20" max="80" step="2"
                                       x-model="footerHeight" class="w-full accent-primary-600 h-1.5">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Tampilkan Elemen --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <p class="text-sm font-bold text-neutral-800 mb-3">Tampilkan Elemen</p>
                    <div class="grid grid-cols-2 gap-2">

                        @foreach([
                            ['tv_show_kiri',      'showKiri',      'Kolom Kiri'],
                            ['tv_show_kanan',     'showKanan',     'Kolom Kanan'],
                            ['tv_show_footer',    'showFooter',    'Running Text'],
                            ['tv_show_countdown', 'showCountdown', 'Countdown'],
                            ['tv_show_donasi',    'showDonasi',    'Donasi'],
                            ['tv_show_wifi',      'showWifi',      'Info WiFi'],
                        ] as [$key, $model, $lbl])
                        <label class="flex items-center gap-2.5 cursor-pointer select-none rounded-xl px-3 py-2.5 transition-all border"
                               :class="{{ $model }} ? 'bg-primary-50 border-primary-300' : 'bg-neutral-50 border-neutral-200'">
                            <div class="relative flex-shrink-0 w-8 h-[18px]">
                                <input type="checkbox" name="{{ $key }}" value="1" x-model="{{ $model }}" class="sr-only">
                                <div class="w-8 h-[18px] rounded-full transition-colors" :class="{{ $model }} ? 'bg-primary-600' : 'bg-neutral-300'"></div>
                                <div class="absolute top-[3px] left-[3px] w-3 h-3 bg-white rounded-full shadow transition-transform" :class="{{ $model }} ? 'translate-x-[14px]' : ''"></div>
                            </div>
                            <span class="text-xs font-semibold leading-none" :class="{{ $model }} ? 'text-primary-700' : 'text-neutral-600'">{{ $lbl }}</span>
                        </label>
                        @endforeach

                        {{-- Shalat Jumat --}}
                        <label class="flex items-center gap-2.5 cursor-pointer select-none rounded-xl px-3 py-2.5 transition-all border"
                               x-data="{ on: {{ ($settings['tv_show_shalat_jum'] ?? '1') === '1' ? 'true' : 'false' }} }"
                               :class="on ? 'bg-primary-50 border-primary-300' : 'bg-neutral-50 border-neutral-200'">
                            <div class="relative flex-shrink-0 w-8 h-[18px]">
                                <input type="checkbox" name="tv_show_shalat_jum" value="1" x-model="on" class="sr-only">
                                <div class="w-8 h-[18px] rounded-full transition-colors" :class="on ? 'bg-primary-600' : 'bg-neutral-300'"></div>
                                <div class="absolute top-[3px] left-[3px] w-3 h-3 bg-white rounded-full shadow transition-transform" :class="on ? 'translate-x-[14px]' : ''"></div>
                            </div>
                            <span class="text-xs font-semibold leading-none" :class="on ? 'text-primary-700' : 'text-neutral-600'">Shalat Jumat</span>
                        </label>

                        {{-- Kegiatan --}}
                        <label class="flex items-center gap-2.5 cursor-pointer select-none rounded-xl px-3 py-2.5 transition-all border"
                               x-data="{ on: {{ ($settings['tv_show_kegiatan'] ?? '1') === '1' ? 'true' : 'false' }} }"
                               :class="on ? 'bg-primary-50 border-primary-300' : 'bg-neutral-50 border-neutral-200'">
                            <div class="relative flex-shrink-0 w-8 h-[18px]">
                                <input type="checkbox" name="tv_show_kegiatan" value="1" x-model="on" class="sr-only">
                                <div class="w-8 h-[18px] rounded-full transition-colors" :class="on ? 'bg-primary-600' : 'bg-neutral-300'"></div>
                                <div class="absolute top-[3px] left-[3px] w-3 h-3 bg-white rounded-full shadow transition-transform" :class="on ? 'translate-x-[14px]' : ''"></div>
                            </div>
                            <span class="text-xs font-semibold leading-none" :class="on ? 'text-primary-700' : 'text-neutral-600'">Kegiatan</span>
                        </label>

                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Live Stream + Konten Info --}}
            <div class="space-y-4">

                {{-- 3. Live Stream --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <p class="text-sm font-bold text-neutral-800 mb-3">Live Stream / CCTV</p>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-neutral-600 mb-1.5">Mode Stream</label>
                            <select name="stream_mode" class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="youtube" {{ ($settings['stream_mode'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube Live</option>
                                <option value="hls"     {{ ($settings['stream_mode'] ?? '') === 'hls'     ? 'selected' : '' }}>CCTV via go2rtc (HLS)</option>
                                <option value="none"    {{ ($settings['stream_mode'] ?? '') === 'none'    ? 'selected' : '' }}>Tidak ada (pengumuman)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-600 mb-1.5">URL YouTube Live</label>
                            <input type="url" name="tv_live_url" value="{{ $settings['tv_live_url'] ?? '' }}"
                                   placeholder="https://youtube.com/watch?v=..."
                                   class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-neutral-600 mb-1.5">Nama Kamera go2rtc</label>
                                <input type="text" name="stream_camera_name" value="{{ $settings['stream_camera_name'] ?? '' }}"
                                       placeholder="kamera-utama"
                                       class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-neutral-600 mb-1.5">Label Stream</label>
                                <input type="text" name="stream_label" value="{{ $settings['stream_label'] ?? 'Live Masjid' }}"
                                       class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer select-none bg-neutral-50 border border-neutral-200 rounded-xl px-3 py-2.5">
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

                {{-- 4. Konten Info --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <p class="text-sm font-bold text-neutral-800 mb-3">Konten Info</p>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-neutral-600 mb-1.5">SSID WiFi</label>
                                <input type="text" name="wifi_ssid" value="{{ $settings['wifi_ssid'] ?? 'MasjidGCP' }}"
                                       class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-neutral-600 mb-1.5">Password WiFi</label>
                                <input type="text" name="wifi_password" value="{{ $settings['wifi_password'] ?? '' }}"
                                       class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-600 mb-1.5">Rekening Donasi</label>
                            <textarea name="donasi_rekening" rows="3"
                                      class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ $settings['donasi_rekening'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-600 mb-1.5">Running Text</label>
                            <textarea name="running_text" rows="3"
                                      class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ $settings['running_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Simpan — full width, di bawah grid --}}
        <button type="submit"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold text-sm py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Pengaturan
        </button>

    </form>
</div>
@endsection

@push('scripts')
<script>
function tvLayoutEditor() {
    return {
        showKiri:     {{ ($settings['tv_show_kiri']       ?? '1') === '1' ? 'true' : 'false' }},
        showKanan:    {{ ($settings['tv_show_kanan']      ?? '1') === '1' ? 'true' : 'false' }},
        showFooter:   {{ ($settings['tv_show_footer']     ?? '1') === '1' ? 'true' : 'false' }},
        showCountdown:{{ ($settings['tv_show_countdown']  ?? '1') === '1' ? 'true' : 'false' }},
        showDonasi:   {{ ($settings['tv_show_donasi']     ?? '1') === '1' ? 'true' : 'false' }},
        showWifi:     {{ ($settings['tv_show_wifi']       ?? '1') === '1' ? 'true' : 'false' }},
    }
}
</script>
@endpush
