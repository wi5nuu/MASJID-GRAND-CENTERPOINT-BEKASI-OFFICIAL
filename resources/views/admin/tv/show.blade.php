@extends('layouts.admin')

@section('title', 'Detail Tayangan TV')
@section('breadcrumb')
    <a href="{{ route('admin.tv.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">TV Display</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">Detail</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">Detail Tayangan TV</h1>
        <a href="{{ route('admin.tv.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        @if($tv->file)
        <img src="{{ Storage::url($tv->file) }}" alt="{{ $tv->judul }}" class="w-full max-h-96 object-cover bg-neutral-100">
        @endif
        <div class="px-6 py-5">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="min-w-0">
                    <span class="inline-block bg-neutral-100 text-neutral-600 text-xs font-medium px-2.5 py-1 rounded-full capitalize mb-2">{{ str_replace('_', ' ', $tv->tipe) }}</span>
                    <h2 class="font-bold text-neutral-900 text-lg">{{ $tv->judul ?: '(Tanpa judul)' }}</h2>
                </div>
                @if($tv->is_active)
                <span class="inline-flex items-center gap-1 bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-1 rounded-full shrink-0">Aktif</span>
                @else
                <span class="inline-flex items-center gap-1 bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full shrink-0">Nonaktif</span>
                @endif
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Durasi (detik)</dt>
                    <dd class="text-sm text-neutral-800">{{ $tv->durasi ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Urutan</dt>
                    <dd class="text-sm text-neutral-800">{{ $tv->urutan ?? 0 }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Konten</dt>
                    <dd class="text-sm text-neutral-700 leading-relaxed whitespace-pre-line">{{ $tv->konten ?: '-' }}</dd>
                </div>
            </dl>
        </div>
        <div class="px-6 py-4 border-t border-neutral-100 flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.tv.edit', $tv) }}"
                class="inline-flex items-center gap-1.5 border border-neutral-300 hover:bg-neutral-50 text-neutral-700 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">Edit</a>
            <form action="{{ route('admin.tv.destroy', $tv) }}" method="POST"
                data-confirm="Item ini akan dihapus permanen dan tidak dapat dikembalikan." data-confirm-title="Hapus Item?" data-confirm-ok="Ya, Hapus" data-confirm-variant="danger">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
