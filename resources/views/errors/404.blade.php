@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan — Masjid Grand Centerpoint Bekasi')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20 bg-neutral-50">
    <div class="text-center max-w-md">
        <div class="w-24 h-24 rounded-2xl bg-primary-100 flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-6xl font-bold text-primary-600 mb-3">404</p>
        <h1 class="text-xl font-bold text-neutral-900 mb-3">Halaman Tidak Ditemukan</h1>
        <p class="text-neutral-500 text-sm mb-8">
            Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin telah dipindahkan atau dihapus.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Kembali ke Beranda
            </a>
            <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center gap-2 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
                Hubungi Kami
            </a>
        </div>
    </div>
</div>
@endsection
