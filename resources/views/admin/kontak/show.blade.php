@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('breadcrumb')
    <a href="{{ route('admin.kontak.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Pesan Masuk</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">Detail</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">Detail Pesan</h1>
        <a href="{{ route('admin.kontak.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-neutral-100 flex items-start justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                    <span class="text-sm font-semibold text-primary-600">{{ strtoupper(substr($kontak->nama ?? '?', 0, 1)) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-neutral-900 truncate">{{ $kontak->nama }}</p>
                    <p class="text-xs text-neutral-400 truncate">{{ $kontak->email }}</p>
                </div>
            </div>
            <span class="text-xs text-neutral-400 whitespace-nowrap">{{ $kontak->created_at->format('d M Y, H:i') }}</span>
        </div>

        <div class="px-6 py-5 space-y-4">
            @if($kontak->telepon)
            <div>
                <p class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Telepon</p>
                <p class="text-sm text-neutral-800">{{ $kontak->telepon }}</p>
            </div>
            @endif
            <div>
                <p class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Subjek</p>
                <p class="text-sm font-medium text-neutral-800">{{ $kontak->subjek ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Pesan</p>
                <p class="text-sm text-neutral-700 leading-relaxed whitespace-pre-line">{{ $kontak->pesan }}</p>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-neutral-100 flex items-center gap-3">
            <a href="mailto:{{ $kontak->email }}?subject=Re: {{ $kontak->subjek }}"
                class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                Balas via Email
            </a>
            <form action="{{ route('admin.kontak.destroy', $kontak) }}" method="POST"
                data-confirm="Pesan ini akan dihapus permanen dan tidak dapat dikembalikan." data-confirm-title="Hapus Pesan?" data-confirm-ok="Ya, Hapus" data-confirm-variant="danger">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
