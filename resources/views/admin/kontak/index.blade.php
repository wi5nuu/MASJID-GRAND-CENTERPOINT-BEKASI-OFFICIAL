@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Kontak</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Pesan Masuk</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Pesan dari form kontak website</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-100 bg-neutral-50">
                    <th class="text-left px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Pengirim</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden md:table-cell">Subjek</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Status</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden lg:table-cell">Tanggal</th>
                    <th class="text-right px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($kontaks ?? [] as $kontak)
                <tr class="hover:bg-neutral-50 transition-colors {{ !($kontak->is_read ?? false) ? 'font-medium' : '' }}">
                    <td class="px-5 py-4">
                        <p class="text-neutral-800 text-sm">{{ $kontak->nama }}</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $kontak->email }}</p>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <p class="text-sm text-neutral-700 line-clamp-1">{{ $kontak->subjek ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($kontak->is_read ?? false)
                        <span class="inline-block bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full">Dibaca</span>
                        @else
                        <span class="inline-flex items-center gap-1 bg-gold-50 text-gold-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-gold-500"></span>Baru
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell">
                        <span class="text-xs text-neutral-500">{{ $kontak->created_at->format('d M Y, H:i') }}</span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.kontak.show', $kontak) }}"
                                class="inline-flex items-center gap-1 text-xs font-medium text-primary-600 hover:text-primary-800 transition-colors">
                                Baca
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <form action="{{ route('admin.kontak.destroy', $kontak) }}" method="POST"
                                onsubmit="return confirm('Hapus pesan ini?')">
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
                        <svg class="w-10 h-10 mx-auto mb-3 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Belum ada pesan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($kontaks) && method_exists($kontaks, 'hasPages') && $kontaks->hasPages())
    <div class="px-5 py-4 border-t border-neutral-100">{{ $kontaks->links() }}</div>
    @endif
</div>

@endsection
