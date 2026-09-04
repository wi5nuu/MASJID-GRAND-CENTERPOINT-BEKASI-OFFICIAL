@extends('layouts.admin')

@section('title', 'Manajemen Kegiatan')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Kegiatan</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Manajemen Kegiatan</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Kelola jadwal kegiatan rutin masjid</p>
    </div>
    <a href="{{ route('admin.kegiatan.create') }}"
        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Kegiatan
    </a>
</div>

<div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-100 bg-neutral-50">
                    <th class="text-left px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Kegiatan</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden md:table-cell">Tanggal</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden lg:table-cell">Lokasi</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Status</th>
                    <th class="text-right px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($kegiatans as $kegiatan)
                <tr class="hover:bg-neutral-50 transition-colors">
                    <td class="px-5 py-4">
                        <p class="font-medium text-neutral-800">{{ $kegiatan->judul }}</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $kegiatan->narasumber ?? 'Umum' }}</p>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <p class="text-sm text-neutral-700">{{ $kegiatan->tanggal ? $kegiatan->tanggal->format('d M Y') : '-' }}</p>
                        @if($kegiatan->waktu_mulai)
                        <p class="text-xs text-neutral-400">{{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} WIB</p>
                        @endif
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell">
                        <span class="text-sm text-neutral-600">{{ $kegiatan->lokasi ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($kegiatan->is_active)
                        <span class="inline-flex items-center gap-1 bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-neutral-400"></span>Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.kegiatan.edit', $kegiatan) }}"
                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.kegiatan.destroy', $kegiatan) }}" method="POST"
                                onsubmit="return confirm('Hapus kegiatan ini?')">
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
                        <svg class="w-10 h-10 mx-auto mb-3 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Belum ada kegiatan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($kegiatans) && method_exists($kegiatans, 'hasPages') && $kegiatans->hasPages())
    <div class="px-5 py-4 border-t border-neutral-100">{{ $kegiatans->links() }}</div>
    @endif
</div>

@endsection
