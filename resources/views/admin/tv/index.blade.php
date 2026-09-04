@extends('layouts.admin')

@section('title', 'TV Display')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">TV Display</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">TV Display</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Kelola konten running text, popup, dan pengumuman</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('tv.display') }}" target="_blank"
            class="inline-flex items-center gap-2 border border-neutral-300 text-neutral-600 hover:bg-neutral-50 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Pratinjau TV
        </a>
        <a href="{{ route('admin.tv.layout') }}"
            class="inline-flex items-center gap-2 border border-primary-600 text-primary-600 hover:bg-primary-50 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
            Pengaturan Layout
        </a>
        <a href="{{ route('admin.tv.create') }}"
            class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Konten
        </a>
    </div>
</div>

@foreach(['running_text'=>'Running Text / Teks Berjalan','popup'=>'Popup Pengumuman','pengumuman'=>'Pengumuman Layar TV'] as $tipe => $label)
@php $items = $displays->where('tipe', $tipe); @endphp
<div class="mb-6">
    <h2 class="text-sm font-semibold text-neutral-700 mb-3 flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-primary-500"></span>{{ $label }}
        <span class="text-xs font-normal text-neutral-400">({{ $items->count() }} item)</span>
    </h2>
    @if($items->count() > 0)
    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        <table class="w-full text-sm">
            <tbody class="divide-y divide-neutral-100">
                @foreach($items->sortBy('urutan') as $item)
                <tr class="hover:bg-neutral-50 transition-colors">
                    <td class="px-5 py-3.5 w-8">
                        <span class="text-xs text-neutral-400 font-mono">{{ $item->urutan }}</span>
                    </td>
                    <td class="px-4 py-3.5">
                        <p class="font-medium text-neutral-800 text-sm">{{ $item->judul }}</p>
                        <p class="text-xs text-neutral-400 mt-0.5 line-clamp-1">{{ Str::limit($item->konten, 80) }}</p>
                    </td>
                    <td class="px-4 py-3.5 text-center">
                        @if($item->is_active)
                        <span class="inline-flex items-center gap-1 bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-neutral-400"></span>Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.tv.edit', $item) }}"
                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.tv.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Hapus item ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="bg-neutral-50 rounded-2xl border border-neutral-200 py-8 text-center text-neutral-400 text-sm">
        Belum ada konten {{ strtolower($label) }}
    </div>
    @endif
</div>
@endforeach

@endsection
