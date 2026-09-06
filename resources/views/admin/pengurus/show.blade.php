@extends('layouts.admin')

@section('title', 'Detail Pengurus')
@section('breadcrumb')
    <a href="{{ route('admin.pengurus.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Pengurus Masjid</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">Detail</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">Detail Pengurus</h1>
        <a href="{{ route('admin.pengurus.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-neutral-100 flex items-center gap-4">
            @if($pengurus->foto)
            <img src="{{ Storage::url($pengurus->foto) }}" alt="{{ $pengurus->nama }}" class="w-16 h-16 rounded-full object-cover shrink-0">
            @else
            <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                <span class="text-2xl font-bold text-primary-600">{{ strtoupper(substr($pengurus->nama, 0, 1)) }}</span>
            </div>
            @endif
            <div class="min-w-0">
                <p class="font-bold text-neutral-900 text-lg truncate">{{ $pengurus->nama }}</p>
                <p class="text-sm text-primary-600 font-medium">{{ $pengurus->jabatan }}</p>
            </div>
            <div class="ml-auto shrink-0">
                @if($pengurus->is_active)
                <span class="inline-flex items-center gap-1 bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-1 rounded-full">Aktif</span>
                @else
                <span class="inline-flex items-center gap-1 bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full">Nonaktif</span>
                @endif
            </div>
        </div>
        <dl class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Periode</dt>
                <dd class="text-sm text-neutral-800">{{ $pengurus->periode ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Urutan</dt>
                <dd class="text-sm text-neutral-800">{{ $pengurus->urutan ?? 0 }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Email</dt>
                <dd class="text-sm text-neutral-800">{{ $pengurus->email ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Telepon</dt>
                <dd class="text-sm text-neutral-800">{{ $pengurus->telepon ?: '-' }}</dd>
            </div>
            @if($pengurus->bio)
            <div class="sm:col-span-2">
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Bio</dt>
                <dd class="text-sm text-neutral-700 leading-relaxed whitespace-pre-line">{{ $pengurus->bio }}</dd>
            </div>
            @endif
        </dl>
        <div class="px-6 py-4 border-t border-neutral-100 flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.pengurus.edit', $pengurus) }}"
                class="inline-flex items-center gap-1.5 border border-neutral-300 hover:bg-neutral-50 text-neutral-700 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">Edit</a>
            <form action="{{ route('admin.pengurus.destroy', $pengurus) }}" method="POST"
                data-confirm="Data pengurus ini akan dihapus permanen dan tidak dapat dikembalikan." data-confirm-title="Hapus Pengurus?" data-confirm-ok="Ya, Hapus" data-confirm-variant="danger">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
