@extends('layouts.admin')

@section('title', 'Manajemen Event')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Event Khusus</span>
@endsection

@section('content')
<div class="space-y-5">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">Event Khusus</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Kelola event, seminar, bazaar, dan acara khusus masjid</p>
        </div>
        <a href="{{ route('admin.event.create') }}"
            class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Event
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wide">Event</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wide hidden md:table-cell">Tanggal</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wide hidden lg:table-cell">Lokasi</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-neutral-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($events as $event)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if($event->thumbnail)
                                <img src="{{ Storage::url($event->thumbnail) }}" class="w-10 h-10 rounded-lg object-cover shrink-0" alt="">
                                @else
                                <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-medium text-neutral-900 truncate max-w-xs">{{ $event->judul }}</p>
                                    @if($event->is_featured)
                                    <span class="text-xs text-gold-600 font-medium">★ Unggulan</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 hidden md:table-cell">
                            <p class="text-sm text-neutral-700">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->locale('id')->isoFormat('D MMM Y') }}</p>
                            @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                            <p class="text-xs text-neutral-400">s/d {{ \Carbon\Carbon::parse($event->tanggal_selesai)->locale('id')->isoFormat('D MMM Y') }}</p>
                            @endif
                            @if($event->waktu_mulai)
                            <p class="text-xs text-neutral-400">{{ $event->waktu_mulai }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 hidden lg:table-cell">
                            <p class="text-sm text-neutral-600 truncate max-w-[150px]">{{ $event->lokasi ?? '—' }}</p>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($event->is_active)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-neutral-100 text-neutral-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-neutral-400"></span>Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.event.edit', $event) }}"
                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.event.destroy', $event) }}" method="POST" onsubmit="return confirm('Hapus event ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 rounded-lg text-neutral-400 hover:text-red-600 hover:bg-red-50 transition-colors">
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
                                <svg class="w-7 h-7 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-neutral-500">Belum ada event</p>
                            <a href="{{ route('admin.event.create') }}" class="inline-flex items-center gap-1.5 mt-3 text-sm text-primary-600 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Event
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($events->hasPages())
        <div class="px-5 py-4 border-t border-neutral-100">{{ $events->links() }}</div>
        @endif
    </div>
</div>
@endsection
