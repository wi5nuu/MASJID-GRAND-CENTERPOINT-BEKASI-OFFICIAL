@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Pengguna</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Manajemen Pengguna</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Kelola akun admin dan editor</p>
    </div>
    <a href="{{ route('admin.users.create') }}"
        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-100 bg-neutral-50">
                    <th class="text-left px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Pengguna</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden md:table-cell">Role</th>
                    <th class="text-center px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Status</th>
                    <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden lg:table-cell">Bergabung</th>
                    <th class="text-right px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($users ?? [] as $user)
                <tr class="hover:bg-neutral-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                <span class="text-sm font-semibold text-primary-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-neutral-800">{{ $user->name }}</p>
                                <p class="text-xs text-neutral-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <span class="inline-block bg-neutral-100 text-neutral-600 text-xs font-medium px-2.5 py-1 rounded-full capitalize">
                            {{ $user->role->label ?? $user->role->name ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($user->is_active)
                        <span class="inline-flex items-center gap-1 bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 bg-neutral-100 text-neutral-500 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-neutral-400"></span>Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell">
                        <span class="text-xs text-neutral-500">{{ $user->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($user->id !== auth()->id())
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-neutral-400 italic">Anda</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-neutral-400 text-sm">Belum ada pengguna</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
