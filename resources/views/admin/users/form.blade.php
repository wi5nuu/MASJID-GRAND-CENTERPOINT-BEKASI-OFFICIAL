@extends('layouts.admin')

@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Pengguna</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($user) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="max-w-xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-neutral-900">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h1>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}"
          method="POST">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                    Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '*' }}
                </label>
                <input type="password" name="password" {{ isset($user) ? '' : 'required' }}
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Min. 8 karakter">
                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            @if(isset($user))
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                <select name="role_id" required
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @foreach($roles ?? [] as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                        {{ $role->label }}
                    </option>
                    @endforeach
                </select>
                @error('role_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                <label for="is_active" class="text-sm text-neutral-700">Akun aktif</label>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                {{ isset($user) ? 'Simpan Perubahan' : 'Tambah Pengguna' }}
            </button>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700 px-4 py-2.5 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
