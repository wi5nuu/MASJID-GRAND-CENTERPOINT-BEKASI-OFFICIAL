@extends('layouts.admin')

@section('title', 'Manajemen Donasi')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Donasi</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Manajemen Donasi</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Daftar transaksi donasi masuk</p>
    </div>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-neutral-200 p-5">
        <p class="text-xs text-neutral-400 mb-1">Total Donasi Masuk</p>
        <p class="text-xl font-bold text-primary-700">Rp {{ number_format($donasis->sum('jumlah') ?? 0, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-neutral-200 p-5">
        <p class="text-xs text-neutral-400 mb-1">Transaksi Dikonfirmasi</p>
        <p class="text-xl font-bold text-primary-700">{{ $donasis->where('status','confirmed')->count() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-neutral-200 p-5">
        <p class="text-xs text-neutral-400 mb-1">Menunggu Konfirmasi</p>
        <p class="text-xl font-bold text-gold-600">{{ $donasis->where('status','pending')->count() }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-100 bg-neutral-50">
                    <th class="text-left px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Donatur</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden md:table-cell">Program</th>
                    <th class="text-right px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Jumlah</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Status</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden lg:table-cell">Tanggal</th>
                    <th class="text-right px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($donasis as $donasi)
                <tr class="hover:bg-neutral-50 transition-colors">
                    <td class="px-5 py-4">
                        <p class="font-medium text-neutral-800">{{ $donasi->nama ?? 'Anonim' }}</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $donasi->email ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <span class="text-sm text-neutral-600">{{ $donasi->program->judul ?? 'Umum' }}</span>
                    </td>
                    <td class="px-4 py-4 text-right">
                        <span class="font-semibold text-neutral-800">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @php
                            $statusMap = [
                                'pending'   => ['bg-gold-50 text-gold-700', 'Menunggu'],
                                'confirmed' => ['bg-primary-50 text-primary-700', 'Dikonfirmasi'],
                                'rejected'  => ['bg-red-50 text-red-600', 'Ditolak'],
                            ];
                            [$cls, $label] = $statusMap[$donasi->status] ?? ['bg-neutral-100 text-neutral-500', $donasi->status];
                        @endphp
                        <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full {{ $cls }}">{{ $label }}</span>
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell">
                        <span class="text-xs text-neutral-500">{{ $donasi->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <a href="{{ route('admin.donasi.show', $donasi) }}"
                            class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-600 hover:text-primary-800 transition-colors">
                            Detail
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-neutral-400 text-sm">
                        <svg class="w-10 h-10 mx-auto mb-3 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        Belum ada donasi masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($donasis) && method_exists($donasis, 'hasPages') && $donasis->hasPages())
    <div class="px-5 py-4 border-t border-neutral-100">{{ $donasis->links() }}</div>
    @endif
</div>

@endsection
