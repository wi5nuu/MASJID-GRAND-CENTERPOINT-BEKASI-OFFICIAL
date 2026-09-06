@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Pengguna</span>
@endsection

@section('content')

<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Manajemen Pengguna</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Kelola akun admin, editor, dan jamaah</p>
    </div>
    <a href="{{ route('admin.users.create') }}"
        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Pengguna
    </a>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2 mb-4">
    <div class="relative flex-1 min-w-44">
        <svg class="w-4 h-4 text-neutral-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, WA, unit..."
            class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-neutral-300 bg-white text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
    </div>
    <select name="role"
        class="px-3 py-2.5 rounded-xl border border-neutral-300 bg-white text-sm text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
        <option value="">Semua Role</option>
        @foreach($roles ?? [] as $role)
        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>{{ $role->label ?? ucfirst($role->name) }}</option>
        @endforeach
    </select>
    <select name="status"
        class="px-3 py-2.5 rounded-xl border border-neutral-300 bg-white text-sm text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
        <option value="">Semua Status</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    <button type="submit" class="inline-flex items-center gap-1.5 bg-neutral-900 hover:bg-neutral-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
        Filter
    </button>
    @if(request()->hasAny(['search', 'role', 'status']))
    <a href="{{ route('admin.users.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700 px-2 py-2.5 transition-colors">Reset</a>
    @endif
</form>

<div x-data="{ selected: [], pageIds: {{ $selectableIds ?? '[]' }} }">
    {{-- Bulk action bar --}}
    <div x-show="selected.length > 0" x-cloak class="mb-3 flex flex-wrap items-center gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-2.5">
        <span class="text-sm text-red-700 font-medium"><span x-text="selected.length"></span> pengguna dipilih</span>
        <button type="button" @click="$refs.bulkForm.requestSubmit()"
            class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Hapus yang dipilih
        </button>
        <button type="button" @click="selected = []" class="text-xs text-neutral-500 hover:text-neutral-700 transition-colors">Batalkan pilihan</button>
    </div>

    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="px-4 py-3.5 w-10">
                            <input type="checkbox" @change="selected = $event.target.checked ? pageIds.map(String) : []"
                                :checked="pageIds.length > 0 && selected.length === pageIds.length"
                                class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500 align-middle" aria-label="Pilih semua">
                        </th>
                        <th class="text-left px-3 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Pengguna</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden sm:table-cell">Unit / Kontak</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden md:table-cell">Role</th>
                        <th class="text-center px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Status</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide hidden lg:table-cell">Bergabung</th>
                        <th class="text-right px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($users ?? [] as $user)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-4 py-4">
                            <input type="checkbox" x-model="selected" value="{{ $user->id }}"
                                @if($user->id === auth()->id()) disabled title="Tidak dapat menghapus akun sendiri" @endif
                                class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500 align-middle disabled:opacity-30" aria-label="Pilih {{ $user->name }}">
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                    <span class="text-sm font-semibold text-primary-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-neutral-800 hover:text-primary-600 truncate block transition-colors">{{ $user->name }}</a>
                                    <p class="text-xs text-neutral-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 hidden sm:table-cell">
                            @if($user->unit_no)
                            <p class="text-xs font-semibold text-neutral-800">Unit {{ $user->unit_no }}</p>
                            @endif
                            @if($user->phone)
                            <p class="text-xs text-neutral-400 mt-0.5">{{ $user->phone }}</p>
                            @endif
                            @if(!$user->unit_no && !$user->phone)
                            <span class="text-xs text-neutral-300">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 hidden md:table-cell">
                            <span class="inline-block bg-neutral-100 text-neutral-600 text-xs font-medium px-2.5 py-1 rounded-full capitalize">
                                {{ $user->role->label ?? $user->role->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($user->hasRole('jamaah') && !$user->approved_at)
                            <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap">
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
                        </td>
                        <td class="px-4 py-4 hidden lg:table-cell">
                            <span class="text-xs text-neutral-500 whitespace-nowrap">{{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($user->hasRole('jamaah') && !$user->approved_at)
                                <form action="{{ route('admin.users.approve', $user) }}" method="POST"
                                    data-confirm="Akun jamaah ini akan diaktifkan dan bisa masuk ke portal jamaah." data-confirm-title="Setujui Pendaftaran?" data-confirm-ok="Ya, Setujui" data-confirm-variant="success">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-medium transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Setujui
                                    </button>
                                </form>
                                @endif
                                @if($user->id !== auth()->id())
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    data-confirm="Akun pengguna ini akan dihapus permanen dan tidak dapat dikembalikan." data-confirm-title="Hapus Pengguna?" data-confirm-ok="Ya, Hapus" data-confirm-variant="danger">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-colors" title="Hapus">
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
                        <td colspan="7" class="px-5 py-12 text-center text-neutral-400 text-sm">Belum ada pengguna yang cocok dengan filter</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($users) && $users->hasPages())
        <div class="px-5 py-4 border-t border-neutral-100">{{ $users->links() }}</div>
        @endif
    </div>

    {{-- Form hapus massal (hidden inputs diisi Alpine) --}}
    <form x-ref="bulkForm" action="{{ route('admin.users.bulk-destroy') }}" method="POST"
        :data-confirm="'Hapus ' + selected.length + ' pengguna terpilih? Tindakan ini tidak dapat dibatalkan.'"
        data-confirm-title="Hapus Massal?" data-confirm-ok="Ya, Hapus Semua" data-confirm-variant="danger">
        @csrf
        <template x-for="id in selected" :key="id">
            <input type="hidden" name="ids[]" :value="id">
        </template>
    </form>
</div>

@endsection
