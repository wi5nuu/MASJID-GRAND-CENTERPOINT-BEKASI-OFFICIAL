@extends('layouts.admin')

@section('title', 'Manajemen Berita')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Berita</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Manajemen Berita</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Kelola semua artikel berita masjid</p>
    </div>
    <a href="{{ route('admin.berita.create') }}"
        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Berita
    </a>
</div>

{{-- Filter --}}
<form method="GET" class="bg-white rounded-2xl border border-neutral-200 p-4 mb-5 flex flex-col sm:flex-row gap-3">
    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul berita..."
        class="flex-1 px-4 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
    <select name="status" class="px-4 py-2 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
        <option value="">Semua Status</option>
        <option value="published" {{ request('status')=='published'?'selected':'' }}>Published</option>
        <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
    </select>
    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2 rounded-xl text-sm font-medium transition-colors">Cari</button>
    @if(request()->hasAny(['cari','status']))
    <a href="{{ route('admin.berita.index') }}" class="px-5 py-2 rounded-xl border border-neutral-300 text-sm text-neutral-600 hover:bg-neutral-50 transition-colors text-center">Reset</a>
    @endif
</form>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-100 bg-neutral-50">
                    <th class="text-left px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Berita</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden md:table-cell">Kategori</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden lg:table-cell">Tanggal</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Status</th>
                    <th class="text-right px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($beritas as $berita)
                <tr class="hover:bg-neutral-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if($berita->thumbnail)
                            <img src="{{ Storage::url($berita->thumbnail) }}" alt="" class="w-10 h-10 rounded-lg object-cover shrink-0">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                            @endif
                            <div>
                                <p class="font-medium text-neutral-800 line-clamp-1">{{ $berita->judul }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $berita->views ?? 0 }} views</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <span class="text-xs text-neutral-600">{{ $berita->kategori->nama ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell">
                        <span class="text-xs text-neutral-500">
                            {{ $berita->published_at ? $berita->published_at->format('d M Y') : '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($berita->status === 'published')
                        <span class="inline-flex items-center gap-1 bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>Published
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-neutral-400"></span>Draft
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.berita.edit', $berita) }}"
                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST"
                                onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-neutral-400 text-sm">
                        <svg class="w-10 h-10 mx-auto mb-3 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        Belum ada berita
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($beritas->hasPages())
    <div class="px-5 py-4 border-t border-neutral-100">
        {{ $beritas->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection
