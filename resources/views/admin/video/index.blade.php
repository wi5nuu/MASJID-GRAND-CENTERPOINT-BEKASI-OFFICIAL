@extends('layouts.admin')

@section('title', 'Manajemen Video')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Video</span>
@endsection

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">Manajemen Video</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Kelola video ceramah, kajian, dan dokumentasi masjid</p>
        </div>
        <a href="{{ route('admin.video.create') }}"
            class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Video
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wide">Video</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wide">Kategori</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wide">Tanggal</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($videos as $video)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                {{-- Thumbnail --}}
                                <div class="w-20 h-12 rounded-lg overflow-hidden bg-neutral-100 shrink-0 relative">
                                    @if($video->thumbnail)
                                        <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->judul }}" class="w-full h-full object-cover">
                                    @elseif($video->url_youtube)
                                        @php
                                            preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video->url_youtube, $m);
                                            $ytId = $m[1] ?? null;
                                        @endphp
                                        @if($ytId)
                                            <img src="https://img.youtube.com/vi/{{ $ytId }}/mqdefault.jpg" alt="{{ $video->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    {{-- Play overlay --}}
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-6 h-6 bg-black/50 rounded-full flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-neutral-900 truncate max-w-xs">{{ $video->judul }}</p>
                                    @if($video->url_youtube)
                                    <a href="{{ $video->url_youtube }}" target="_blank" class="text-xs text-primary-600 hover:underline truncate block max-w-xs">
                                        {{ $video->url_youtube }}
                                    </a>
                                    @endif
                                    @if($video->is_featured)
                                    <span class="inline-flex items-center gap-1 text-xs text-gold-600 font-medium mt-0.5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        Unggulan
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($video->kategori)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-700">
                                {{ $video->kategori->nama }}
                            </span>
                            @else
                            <span class="text-neutral-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($video->is_active)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-neutral-100 text-neutral-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-neutral-400"></span>Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-neutral-500 whitespace-nowrap">
                            {{ $video->created_at->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-1">
                                @if($video->url_youtube)
                                <a href="{{ $video->url_youtube }}" target="_blank"
                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Tonton">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                @endif
                                <a href="{{ route('admin.video.edit', $video) }}"
                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.video.destroy', $video) }}" method="POST"
                                    onsubmit="return confirm('Hapus video ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 rounded-lg text-neutral-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-neutral-500">Belum ada video</p>
                            <p class="text-xs text-neutral-400 mt-1">Tambahkan video ceramah atau kajian pertama</p>
                            <a href="{{ route('admin.video.create') }}" class="inline-flex items-center gap-1.5 mt-4 text-sm text-primary-600 hover:text-primary-700 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Video
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($videos->hasPages())
        <div class="px-5 py-4 border-t border-neutral-100">
            {{ $videos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
