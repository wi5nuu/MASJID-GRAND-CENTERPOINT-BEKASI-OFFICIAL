@extends('layouts.admin')

@section('title', 'Manajemen Galeri')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Galeri</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Manajemen Galeri</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Kelola foto dan album galeri masjid</p>
    </div>
    <a href="{{ route('admin.galeri.create') }}"
        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Foto
    </a>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
    @forelse($galeris as $galeri)
    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden group">
        <div class="relative aspect-square bg-neutral-100">
            @if($galeri->file)
            <img src="{{ Storage::url($galeri->file) }}" alt="{{ $galeri->judul }}"
                class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
            {{-- Status badge --}}
            @if(!$galeri->is_active)
            <span class="absolute top-2 left-2 bg-neutral-800/70 text-white text-xs px-2 py-0.5 rounded-full">Nonaktif</span>
            @endif
        </div>
        <div class="p-3">
            <p class="text-xs font-medium text-neutral-700 line-clamp-1">{{ $galeri->judul }}</p>
            @if($galeri->album)
            <p class="text-xs text-neutral-400 mt-0.5">{{ $galeri->album }}</p>
            @endif
            <div class="flex items-center justify-end gap-1 mt-2">
                <a href="{{ route('admin.galeri.edit', $galeri) }}"
                    class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form action="{{ route('admin.galeri.destroy', $galeri) }}" method="POST"
                    onsubmit="return confirm('Hapus foto ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 text-center text-neutral-400 text-sm">
        <svg class="w-12 h-12 mx-auto mb-3 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Belum ada foto di galeri
    </div>
    @endforelse
</div>

@if(isset($galeris) && method_exists($galeris, 'hasPages') && $galeris->hasPages())
<div class="mt-6">{{ $galeris->links() }}</div>
@endif

@endsection
