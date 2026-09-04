@extends('layouts.public')

@section('title', 'Tentang Masjid — Masjid Grand Centerpoint Bekasi')
@section('meta_description', 'Mengenal lebih dekat Masjid Grand Centerpoint Bekasi — sejarah, visi misi, dan susunan pengurus.')

@section('content')

{{-- Page Header --}}
<section class="bg-gradient-to-br from-primary-800 to-primary-900 relative overflow-hidden py-16 lg:py-24">
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block text-xs font-semibold text-primary-200 uppercase tracking-widest mb-3">Profil Masjid</span>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">Tentang Masjid Grand<br>Centerpoint Bekasi</h1>
        <p class="text-primary-200 text-sm max-w-lg mx-auto">Mengenal lebih dekat masjid kami — tempat ibadah, ilmu, dan ukhuwah.</p>
    </div>
</section>

{{-- Sejarah --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="section-badge mb-4">Sejarah</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-5">Perjalanan Masjid Kami</h2>
                <div class="prose prose-sm prose-neutral max-w-none text-neutral-600 space-y-4">
                    <p>Masjid Grand Centerpoint Bekasi berdiri sejak tahun 2010 sebagai bagian dari kompleks Grand Centerpoint. Masjid ini didirikan untuk memenuhi kebutuhan ibadah dan kegiatan keislaman bagi masyarakat di kawasan tersebut.</p>
                    <p>Sejak awal berdirinya, masjid ini telah menjadi pusat kegiatan keislaman yang aktif, menyelenggarakan berbagai program kajian, pendidikan Al-Quran, dan kegiatan sosial kemasyarakatan.</p>
                    <p>Dengan kapasitas yang memadai dan fasilitas yang terus dikembangkan, Masjid Grand Centerpoint Bekasi terus berupaya menjadi masjid yang makmur dan bermanfaat bagi umat Islam di Bekasi dan sekitarnya.</p>
                </div>
            </div>
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-primary-100 to-primary-200 aspect-video flex items-center justify-center">
                <svg class="w-16 h-16 text-primary-400" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                </svg>
            </div>
        </div>
    </div>
</section>

{{-- Visi Misi --}}
<section class="py-14 bg-neutral-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="section-badge mb-3">Arah & Tujuan</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900">Visi & Misi</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl border border-neutral-100 p-6">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 mb-3">Visi</h3>
                <p class="text-sm text-neutral-600 leading-relaxed">Menjadi masjid yang makmur, modern, dan menjadi pusat peradaban Islam yang memberikan manfaat nyata bagi umat dan masyarakat sekitar.</p>
            </div>
            <div class="bg-white rounded-2xl border border-neutral-100 p-6">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 mb-3">Misi</h3>
                <ul class="space-y-2">
                    @foreach(['Menyelenggarakan ibadah yang tertib dan berkualitas', 'Mengembangkan pendidikan Islam yang komprehensif', 'Membina ukhuwah islamiyah di tengah masyarakat', 'Mengelola masjid secara profesional dan transparan', 'Memberdayakan jamaah melalui program sosial dan ekonomi'] as $misi)
                    <li class="flex items-start gap-2 text-sm text-neutral-600">
                        <svg class="w-4 h-4 text-primary-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ $misi }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- Fasilitas --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="section-badge mb-3">Fasilitas</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900">Fasilitas Masjid</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @php $fasilitas = [
                ['nama'=>'Ruang Shalat Utama', 'kapasitas'=>'2.000 jamaah', 'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5'],
                ['nama'=>'Tempat Wudhu', 'kapasitas'=>'Putra & putri', 'icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['nama'=>'Perpustakaan', 'kapasitas'=>'Koleksi Islam', 'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['nama'=>'Ruang Kajian', 'kapasitas'=>'200 peserta', 'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['nama'=>'Parkir', 'kapasitas'=>'Luas', 'icon'=>'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                ['nama'=>'Kantin Halal', 'kapasitas'=>'Area makan', 'icon'=>'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                ['nama'=>'Sound System', 'kapasitas'=>'Digital', 'icon'=>'M15.536 8.464a5 5 0 010 7.072M12 18.364l-3.536-3.536m0 0a5 5 0 010-7.072M12 5.636L15.536 9.17'],
                ['nama'=>'CCTV & Keamanan', 'kapasitas'=>'24 jam', 'icon'=>'M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z'],
            ]; @endphp
            @foreach($fasilitas as $item)
            <div class="bg-neutral-50 rounded-2xl p-5 text-center">
                <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                </div>
                <p class="font-semibold text-neutral-900 text-sm mb-0.5">{{ $item['nama'] }}</p>
                <p class="text-xs text-neutral-400">{{ $item['kapasitas'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Pengurus --}}
<section class="py-14 bg-neutral-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="section-badge mb-3">Kepengurusan</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900">Susunan Pengurus</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($pengurusList ?? [] as $pengurus)
            <div class="bg-white rounded-2xl border border-neutral-100 p-5 text-center card-hover">
                <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    @if($pengurus->foto)
                    <img src="{{ Storage::url($pengurus->foto) }}" alt="{{ $pengurus->nama }}" class="w-full h-full object-cover">
                    @else
                    <span class="text-primary-700 text-xl font-bold">{{ strtoupper(substr($pengurus->nama, 0, 2)) }}</span>
                    @endif
                </div>
                <h3 class="font-semibold text-neutral-900 text-sm">{{ $pengurus->nama }}</h3>
                <p class="text-xs text-primary-600 font-medium mt-0.5">{{ $pengurus->jabatan }}</p>
                @if($pengurus->bio)
                <p class="text-xs text-neutral-500 mt-2 line-clamp-2">{{ $pengurus->bio }}</p>
                @endif
            </div>
            @empty
            @foreach(['Ketua Umum', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Ketua Bid. Ibadah', 'Ketua Bid. Pendidikan'] as $jabatan)
            <div class="bg-white rounded-2xl border border-neutral-100 p-5 text-center">
                <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <p class="text-xs text-neutral-400 text-sm">Nama Pengurus</p>
                <p class="text-xs text-primary-600 font-medium mt-0.5">{{ $jabatan }}</p>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

@endsection
