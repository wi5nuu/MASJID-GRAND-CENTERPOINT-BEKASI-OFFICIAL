@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Pengguna</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">Detail</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">Detail Pengguna</h1>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        {{-- Header identitas --}}
        <div class="px-6 py-5 border-b border-neutral-100 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                <span class="text-xl font-bold text-primary-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <div class="min-w-0">
                <p class="font-bold text-neutral-900 text-lg truncate">{{ $user->name }}</p>
                <p class="text-sm text-neutral-400 truncate">{{ $user->email }}</p>
            </div>
            <div class="ml-auto shrink-0">
                @if($user->hasRole('jamaah') && !$user->approved_at)
                <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Menunggu Persetujuan
                </span>
                @elseif($user->is_active)
                <span class="inline-flex items-center gap-1 bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>Aktif
                </span>
                @else
                <span class="inline-flex items-center gap-1 bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-neutral-400"></span>Nonaktif
                </span>
                @endif
            </div>
        </div>

        {{-- Semua data pendaftaran --}}
        <dl class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Role</dt>
                <dd class="text-sm text-neutral-800 capitalize">{{ $user->role->label ?? $user->role->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">No. WhatsApp</dt>
                <dd class="text-sm text-neutral-800">{{ $user->phone ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Nomor Unit</dt>
                <dd class="text-sm font-semibold text-neutral-800">{{ $user->unit_no ? 'Unit ' . $user->unit_no : '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Bergabung</dt>
                <dd class="text-sm text-neutral-800">{{ $user->created_at->format('d M Y, H:i') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Disetujui Pada</dt>
                <dd class="text-sm text-neutral-800">{{ $user->approved_at ? $user->approved_at->format('d M Y, H:i') : '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-neutral-400 uppercase tracking-wide mb-1">Status Akun</dt>
                <dd class="text-sm text-neutral-800">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</dd>
            </div>
        </dl>

        {{-- Aksi --}}
        <div class="px-6 py-4 border-t border-neutral-100 flex flex-wrap items-center gap-3">
            @if($user->hasRole('jamaah') && !$user->approved_at)
            <form action="{{ route('admin.users.approve', $user) }}" method="POST"
                data-confirm="Akun jamaah ini akan diaktifkan dan bisa masuk ke portal jamaah." data-confirm-title="Setujui Pendaftaran?" data-confirm-ok="Ya, Setujui" data-confirm-variant="success">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Setujui
                </button>
            </form>
            @endif
            @if($user->id !== auth()->id())
            <a href="{{ route('admin.users.edit', $user) }}"
                class="inline-flex items-center gap-1.5 border border-neutral-300 hover:bg-neutral-50 text-neutral-700 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                Edit
            </a>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                data-confirm="Akun pengguna ini akan dihapus permanen dan tidak dapat dikembalikan." data-confirm-title="Hapus Pengguna?" data-confirm-ok="Ya, Hapus" data-confirm-variant="danger">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                    Hapus
                </button>
            </form>
            @else
            <span class="text-xs text-neutral-400 italic">Ini akun Anda sendiri</span>
            @endif
        </div>
    </div>
</div>
@endsection
