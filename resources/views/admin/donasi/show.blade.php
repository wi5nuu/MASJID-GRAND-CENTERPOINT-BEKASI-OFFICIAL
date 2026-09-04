@extends('layouts.admin')

@section('title', 'Detail Donasi')
@section('breadcrumb')
    <a href="{{ route('admin.donasi.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Donasi</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">Detail</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">Detail Donasi</h1>
        <a href="{{ route('admin.donasi.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-6 py-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-primary-200 text-xs mb-1">Jumlah Donasi</p>
                    <p class="text-2xl font-bold text-white">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</p>
                </div>
                @php
                    $statusMap = [
                        'pending'   => 'bg-gold-400 text-white',
                        'confirmed' => 'bg-white text-primary-700',
                        'rejected'  => 'bg-red-400 text-white',
                    ];
                    $statusLabel = ['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','rejected'=>'Ditolak'];
                @endphp
                <span class="px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusMap[$donasi->status] ?? 'bg-white text-neutral-700' }}">
                    {{ $statusLabel[$donasi->status] ?? $donasi->status }}
                </span>
            </div>
        </div>

        {{-- Info --}}
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-neutral-400 mb-1">Nama Donatur</p>
                    <p class="text-sm font-semibold text-neutral-800">{{ $donasi->nama ?? 'Anonim' }}</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-400 mb-1">Email</p>
                    <p class="text-sm font-semibold text-neutral-800">{{ $donasi->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-400 mb-1">No. Telepon</p>
                    <p class="text-sm font-semibold text-neutral-800">{{ $donasi->telepon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-400 mb-1">Program</p>
                    <p class="text-sm font-semibold text-neutral-800">{{ $donasi->program->judul ?? 'Umum' }}</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-400 mb-1">Metode Bayar</p>
                    <p class="text-sm font-semibold text-neutral-800">{{ strtoupper($donasi->metode_bayar ?? '-') }}</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-400 mb-1">Tanggal</p>
                    <p class="text-sm font-semibold text-neutral-800">{{ $donasi->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>

            @if($donasi->pesan)
            <div class="pt-3 border-t border-neutral-100">
                <p class="text-xs text-neutral-400 mb-1">Pesan</p>
                <p class="text-sm text-neutral-700 italic">"{{ $donasi->pesan }}"</p>
            </div>
            @endif

            @if($donasi->bukti_transfer)
            <div class="pt-3 border-t border-neutral-100">
                <p class="text-xs text-neutral-400 mb-2">Bukti Transfer</p>
                <img src="{{ Storage::url($donasi->bukti_transfer) }}" alt="Bukti Transfer"
                    class="max-w-xs rounded-xl border border-neutral-200">
            </div>
            @endif
        </div>

        {{-- Action --}}
        @if($donasi->status === 'pending')
        <div class="px-6 pb-6 flex items-center gap-3">
            <form action="{{ route('admin.donasi.konfirmasi', $donasi) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="confirmed">
                <button type="submit" onclick="return confirm('Konfirmasi donasi ini?')"
                    class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                    Konfirmasi
                </button>
            </form>
            <form action="{{ route('admin.donasi.konfirmasi', $donasi) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="rejected">
                <button type="submit" onclick="return confirm('Tolak donasi ini?')"
                    class="bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                    Tolak
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
