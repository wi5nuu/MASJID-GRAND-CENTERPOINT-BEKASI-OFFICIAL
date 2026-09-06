@extends('layouts.public')

@section('title', 'Tentang Kami — Profil Masjid Grand Centerpoint Bekasi')
@section('meta_description', 'Profil lengkap Masjid Grand Centerpoint Bekasi — sejarah, visi misi, susunan pengurus DKM, dan fasilitas masjid modern di kawasan Apartemen Grand Centerpoint, Bekasi, Jawa Barat.')
@section('meta_keywords', 'profil masjid grand centerpoint, sejarah masjid bekasi, DKM grand centerpoint, visi misi masjid bekasi, pengurus masjid bekasi')
@section('og_title', 'Tentang Masjid Grand Centerpoint Bekasi')
@section('og_description', 'Profil lengkap Masjid Grand Centerpoint Bekasi — sejarah, visi misi, susunan pengurus DKM, dan fasilitas masjid modern di Bekasi.')

@push('head')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {"@@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ url('/') }}"},
        {"@@type": "ListItem", "position": 2, "name": "Tentang Kami", "item": "{{ route('tentang') }}"}
    ]
}
</script>
@endpush

@section('content')

{{-- ============================================================
     PAGE HEADER
     ============================================================ --}}
<section class="page-header">
    <div class="container-xl relative z-10">
        <div class="max-w-2xl mx-auto text-center">
            <span class="section-label" style="color: rgba(255,255,255,0.7);">PROFIL MASJID</span>
            <h1 class="font-heading text-3xl sm:text-5xl font-bold leading-tight mt-2 mb-4" style="color: #ffffff;">
                Tentang Kami
            </h1>
            <p class="text-white/70 text-base leading-relaxed">
                Mengenal lebih dekat masjid kami — tempat ibadah, ilmu, dan ukhuwah di jantung Bekasi.
            </p>
            <nav class="flex items-center justify-center gap-2 mt-6 text-sm text-white/50">
                <a href="{{ route('home') }}" class="hover:text-white/80 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/80">Tentang Kami</span>
            </nav>
        </div>
    </div>
</section>

{{-- ============================================================
     STORY SECTION — 2 kolom
     ============================================================ --}}
<section class="section-padding bg-white">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">

            {{-- Kiri: Gambar --}}
            <div class="relative">
                <picture>
                    <source srcset="{{ asset('images/mosque/jamaah_dalam_masjid.webp') }}" type="image/webp">
                    <img src="{{ asset('images/mosque/jamaah_dalam_masjid.png') }}" alt="Masjid Grand Centerpoint"
                         class="w-full h-60 sm:h-80 lg:h-[460px] object-cover rounded-xl shadow-xl">
                </picture>
                {{-- Floating badge --}}
                <div class="absolute -bottom-4 right-4 sm:-right-4 bg-white rounded-xl shadow-lg border border-neutral-100 px-5 py-4 text-center hidden sm:block" style="border-radius: 12px;">
                    <p class="text-3xl font-extrabold text-primary-600 font-heading">400+</p>
                    <p class="text-xs text-neutral-500 font-medium mt-0.5">Jamaah Aktif</p>
                </div>
            </div>

            {{-- Kanan: Sejarah --}}
            <div>
                <span class="section-label">SEJARAH</span>
                <h2 class="font-heading text-3xl sm:text-4xl font-bold text-neutral-800 mt-2 mb-6">Perjalanan Masjid Kami</h2>

                <div class="space-y-4 text-neutral-500 text-sm sm:text-base leading-relaxed mb-8" style="line-height: 1.7;">
                    <p>Masjid Grand Centerpoint Bekasi berlokasi di GRAND Centerpoint Tower C &amp; D, Jalan Ahmad Yani Sentra Niaga Kalimalang A3.2, Kayuringinjaya, Jawa Barat. Masjid ini berdiri untuk memenuhi kebutuhan ibadah dan kegiatan keislaman bagi para penghuni dan masyarakat sekitar kawasan Grand Centerpoint.</p>
                    <p>Dikenal sebagai satu-satunya masjid di rusun Kota Bekasi yang aktif, masjid ini dikelola oleh Dewan Kemakmuran Masjid (DKM) dengan 13 pengurus yang melayani lebih dari 400 jamaah tetap mencakup 3 kelurahan di Bekasi Selatan.</p>
                    <p>Keistimewaan masjid ini terletak pada semangat toleransi yang tinggi — warga non-Muslim pun turut membantu kegiatan masjid. Masjid ini juga pernah mendapat kunjungan langsung dari Wali Kota Bekasi dan Ketua FKUB, serta mendapat liputan dari berbagai media seperti inijabar.com dan Suara Karya.</p>
                </div>

                <a href="{{ route('kontak') }}" class="btn-primary">
                    Hubungi Kami
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     TIMELINE SEJARAH — Vertical
     ============================================================ --}}
<section class="section-padding-sm bg-neutral-50">
    <div class="container-xl">
        <div class="text-center mb-10">
            <span class="section-label">PERJALANAN KAMI</span>
            <h2 class="font-heading text-3xl font-bold text-neutral-800">Timeline Sejarah</h2>
        </div>

        <div class="max-w-2xl mx-auto">
            @php
                $timeline = [
                    ['year' => '2010', 'title' => 'Pendirian Masjid', 'desc' => 'Masjid Grand Centerpoint resmi berdiri di GRAND Centerpoint Tower C & D, Jalan Ahmad Yani Sentra Niaga Kalimalang A3.2, Kayuringinjaya, Jawa Barat, untuk melayani kebutuhan ibadah penghuni dan warga sekitar.'],
                    ['year' => '2012', 'title' => 'Program Kajian & TPA', 'desc' => 'Kajian malam Jumat dan program Taman Pendidikan Al-Quran (TPA) serta Tahsin mulai dijalankan secara rutin untuk seluruh kalangan jamaah.'],
                    ['year' => '2015', 'title' => 'Santunan Anak Yatim', 'desc' => 'Program santunan anak yatim pertama kali digelar, menjadi program sosial rutin tahunan yang kini menyentuh 150–200 penerima setiap tahun.'],
                    ['year' => '2019', 'title' => 'Pengakuan FKUB', 'desc' => 'Masjid mendapat pengakuan dari FKUB Kota Bekasi atas semangat toleransi dan keaktifannya, disebut sebagai satu-satunya masjid di rusun Kota Bekasi yang aktif.'],
                    ['year' => '2023', 'title' => 'Kunjungan Wali Kota', 'desc' => 'Masjid mendapat kehormatan kunjungan langsung Wali Kota Bekasi dan Ketua FKUB, serta diliput media nasional inijabar.com dan Suara Karya.'],
                ];
            @endphp

            <div class="relative">
                {{-- Vertical line --}}
                <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-primary-100"></div>

                <div class="space-y-8">
                    @foreach($timeline as $item)
                    <div class="flex items-start gap-4 sm:gap-6 relative">
                        <div class="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center shrink-0 shadow-md z-10">
                            <span class="text-white text-xs font-bold">{{ substr($item['year'], 2) }}</span>
                        </div>
                        <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-neutral-200 flex-1 min-w-0" style="border-radius: 12px;">
                            <span class="text-xs font-bold text-primary-600 mb-1 block">{{ $item['year'] }}</span>
                            <h3 class="font-heading font-bold text-neutral-800 text-sm mb-1">{{ $item['title'] }}</h3>
                            <p class="text-xs text-neutral-500 leading-relaxed">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     VISI MISI — 3 kolom cards
     ============================================================ --}}
<section class="section-padding bg-white">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">ARAH & TUJUAN</span>
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-neutral-800">Visi, Misi &amp; Nilai</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Visi --}}
            <div class="card p-7" style="background: linear-gradient(135deg, #1a3a6b 0%, #2563eb 100%); border-radius: 12px;">
                <div class="icon-circle-white mb-5">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <span class="section-label" style="color: rgba(255,255,255,0.6);">VISI</span>
                <h3 class="font-heading text-lg font-bold mt-2 leading-snug" style="color: #ffffff;">
                    {{ isset($profilMasjid) ? $profilMasjid->visi : 'Menjadi masjid yang makmur dan menjadi pusat peradaban Islam di Bekasi' }}
                </h3>
            </div>

            {{-- Misi --}}
            <div class="card p-7" style="border-radius: 12px;">
                <div class="icon-circle mb-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="section-label">MISI</span>
                @php
                    $misiList = isset($profilMasjid) ? $profilMasjid->misi : null;
                    $defaultMisi = [
                        'Menyelenggarakan ibadah yang tertib dan khusyuk berlandaskan sunnah',
                        'Mengelola program pendidikan Islam — TPA, Tahsin, dan kajian rutin',
                        'Memberdayakan umat melalui santunan, zakat fitrah, dan kurban',
                        'Membangun ukhuwah lintas latar belakang dengan semangat toleransi',
                        'Menjaga transparansi dan amanah dalam pengelolaan masjid',
                    ];
                    $misiItems = $misiList ? (is_array($misiList) ? $misiList : explode("\n", $misiList)) : $defaultMisi;
                @endphp
                <ul class="mt-2 space-y-2">
                    @foreach($misiItems as $i => $misi)
                    <li class="flex items-start gap-2 text-sm text-neutral-600">
                        <span class="w-5 h-5 rounded-full bg-primary-100 text-primary-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">{{ $i + 1 }}</span>
                        {{ trim($misi) }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Nilai --}}
            <div class="card p-7" style="border-radius: 12px;">
                <div class="icon-circle mb-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
                <span class="section-label">NILAI</span>
                <ul class="mt-2 space-y-2">
                    @foreach(['Ikhlas & Amanah', 'Ukhuwah Islamiyah', 'Transparansi', 'Inklusif & Melayani', 'Inovatif & Modern'] as $nilai)
                    <li class="flex items-center gap-2 text-sm text-neutral-600">
                        <svg class="w-4 h-4 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ $nilai }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FASILITAS
     ============================================================ --}}
<section class="section-padding bg-neutral-50">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">INFRASTRUKTUR</span>
            <h2 class="font-heading text-3xl font-bold text-neutral-800">Fasilitas Masjid</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach([
                ['icon' => 'M3 10h18M3 14h18M10 6v12M14 6v12', 'label' => 'Ruang Shalat', 'desc' => 'Ber-AC, wangi & bersih'],
                ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13', 'label' => 'Perpustakaan', 'desc' => 'Koleksi buku & Al-Quran'],
                ['icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'label' => 'Wudhu Pria', 'desc' => 'Bersih & terpisah'],
                ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'label' => 'Wudhu Wanita', 'desc' => 'Bersih & terpisah'],
                ['icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z', 'label' => 'Toilet', 'desc' => 'Pria & wanita'],
                ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138', 'label' => 'Al-Quran', 'desc' => 'Tersedia untuk jamaah'],
                ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Ruang TPA', 'desc' => 'Tahsin & TPA anak'],
                ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257', 'label' => 'Sekretariat DKM', 'desc' => 'Layanan administrasi'],
            ] as $fasilitas)
            <div class="bg-white rounded-xl p-5 text-center border border-neutral-200 hover:border-primary-200 hover:shadow-md transition-all group cursor-default" style="border-radius: 12px;">
                <div class="icon-circle mx-auto mb-3 group-hover:bg-primary-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $fasilitas['icon'] }}"/></svg>
                </div>
                <p class="text-sm font-bold text-neutral-800 group-hover:text-primary-600 transition-colors">{{ $fasilitas['label'] }}</p>
                <p class="text-xs text-neutral-500 mt-1">{{ $fasilitas['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     TIM PENGURUS
     ============================================================ --}}
<section class="section-padding bg-white">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">KEPENGURUSAN</span>
            <h2 class="font-heading text-3xl font-bold text-neutral-800">Susunan Pengurus</h2>
            <p class="text-neutral-500 text-sm mt-2">Mereka yang amanah mengelola masjid untuk kepentingan umat.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @forelse($pengurusList ?? [] as $p)
            <div class="card p-5 text-center group" style="border-radius: 12px;">
                @if($p->foto)
                    <img src="{{ asset('storage/'.$p->foto) }}" alt="{{ $p->nama }}"
                         class="w-16 h-16 rounded-full object-cover border-2 border-neutral-100 group-hover:border-primary-200 transition-colors mx-auto mb-3">
                @else
                    <div class="w-16 h-16 rounded-full bg-primary-50 border-2 border-primary-100 flex items-center justify-center mx-auto mb-3 group-hover:border-primary-300 transition-colors">
                        <svg class="w-8 h-8 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                @endif
                <p class="text-xs font-bold text-neutral-800 leading-snug">{{ $p->nama }}</p>
                <p class="text-xs text-primary-600 font-semibold mt-1">{{ $p->jabatan }}</p>
            </div>
            @empty
                @foreach(['Ketua Umum — Agus Supriyono', 'Pembina — Aji Ali Sabana', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Bid. Ibadah', 'Bid. Pendidikan', 'Bid. Sosial'] as $jabatan)
                <div class="card p-5 text-center" style="border-radius: 12px;">
                    <div class="w-16 h-16 rounded-full bg-primary-50 border-2 border-primary-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    @php $parts = explode(' — ', $jabatan, 2); @endphp
                    @if(count($parts) === 2)
                        <p class="text-xs font-bold text-neutral-800 leading-snug">{{ $parts[1] }}</p>
                        <p class="text-xs text-primary-600 font-semibold mt-1">{{ $parts[0] }}</p>
                    @else
                        <p class="text-xs font-bold text-neutral-500">— Akan diisi —</p>
                        <p class="text-xs text-primary-600 font-semibold mt-1">{{ $jabatan }}</p>
                    @endif
                </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

@endsection
