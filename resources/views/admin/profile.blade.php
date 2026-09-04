@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Profil</span>
@endsection

@section('content')

<div class="max-w-2xl">
    <h1 class="text-xl font-bold text-neutral-900 mb-6">Profil Saya</h1>

    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl border border-neutral-200 p-6 mb-5">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                <span class="text-2xl font-bold text-primary-600">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div>
                <p class="font-bold text-neutral-900 text-lg">{{ auth()->user()->name }}</p>
                <p class="text-sm text-neutral-500">{{ auth()->user()->email }}</p>
                <span class="inline-block bg-primary-100 text-primary-700 text-xs font-medium px-2.5 py-0.5 rounded-full mt-1 capitalize">
                    {{ auth()->user()->role->label ?? 'Admin' }}
                </span>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="pt-1">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-2xl border border-neutral-200 p-6">
        <h2 class="font-semibold text-neutral-800 text-sm mb-4">Ubah Password</h2>
        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Password Lama</label>
                    <input type="password" name="current_password" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('current_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div class="pt-1">
                    <button type="submit" class="bg-neutral-800 hover:bg-neutral-900 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                        Ubah Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
