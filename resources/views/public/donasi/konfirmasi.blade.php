@extends('layouts.public')
@section('title', 'Konfirmasi Donasi — Masjid Grand Centerpoint Bekasi')
@section('content')
<section class="min-h-screen py-16 bg-neutral-50 flex items-center">
    <div class="max-w-lg mx-auto px-4 w-full">
        <div class="bg-white rounded-2xl border border-neutral-200 p-8 text-center">
            <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-neutral-900 mb-2">Terima Kasih!</h1>
            <p class="font-arabic text-xl text-gold-600 mb-2" dir="rtl">جَزَاكَ اللَّهُ خَيْرًا</p>
            <p class="text-neutral-500 text-sm mb-6">Donasi Anda telah kami terima. Semoga Allah membalas kebaikan Anda dengan yang lebih baik.</p>

            <div class="bg-neutral-50 rounded-xl p-4 text-left space-y-2 mb-6">
                <div class="flex justify-between text-sm">
                    <span class="text-neutral-500">Nama</span>
                    <span class="font-medium text-neutral-900">{{ $donasi->nama }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-neutral-500">Program</span>
                    <span class="font-medium text-neutral-900">{{ $donasi->program->nama ?? 'Umum' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-neutral-500">Jumlah</span>
                    <span class="font-bold text-primary-700">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-neutral-500">Metode</span>
                    <span class="font-medium text-neutral-900 capitalize">{{ $donasi->metode }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-neutral-500">Status</span>
                    <span class="text-yellow-600 font-medium">Menunggu Konfirmasi</span>
                </div>
            </div>

            @if($donasi->metode === 'transfer')
            <div class="bg-primary-50 rounded-xl p-4 text-sm text-left mb-6">
                <p class="font-semibold text-primary-800 mb-2">Info Rekening Transfer:</p>
                <div class="text-primary-700 text-xs space-y-0.5">
                    {!! nl2br(e(\App\Models\Setting::get('donasi_rekening', 'Hubungi sekretariat.'))) !!}
                </div>
            </div>
            @endif

            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection
