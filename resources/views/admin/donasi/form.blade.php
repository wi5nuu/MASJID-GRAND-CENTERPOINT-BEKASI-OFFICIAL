@extends('layouts.admin')

@section('title', isset($donasi) ? 'Edit Donasi' : 'Tambah Donasi')
@section('breadcrumb')
    <a href="{{ route('admin.donasi.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Donasi</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($donasi) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div class="max-w-xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">{{ isset($donasi) ? 'Edit Donasi' : 'Tambah Donasi Manual' }}</h1>
            <p class="text-sm text-neutral-500 mt-0.5">{{ isset($donasi) ? 'Perbarui data donasi' : 'Input donasi yang diterima secara langsung/tunai' }}</p>
        </div>
        <a href="{{ route('admin.donasi.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l-7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($donasi) ? route('admin.donasi.update', $donasi) : route('admin.donasi.store') }}"
          method="POST">
        @csrf
        @if(isset($donasi)) @method('PUT') @endif

        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Program Donasi</label>
                <select name="program_id" class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">— Pilih Program —</option>
                    @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ old('program_id', $donasi->program_id ?? '') == $program->id ? 'selected' : '' }}>
                        {{ $program->judul }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Donatur</label>
                <input type="text" name="nama" value="{{ old('nama', $donasi->nama ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Kosongkan untuk hamba Allah">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $donasi->email ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        placeholder="opsional">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $donasi->telepon ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        placeholder="opsional">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Jumlah Donasi <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-sm text-neutral-500 font-medium">Rp</span>
                    <input type="number" name="jumlah" required min="1000"
                        value="{{ old('jumlah', $donasi->jumlah ?? '') }}"
                        class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        placeholder="50000">
                </div>
                @error('jumlah')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Metode <span class="text-red-500">*</span></label>
                    <select name="metode" required class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                        @foreach(['transfer'=>'Transfer Bank','qris'=>'QRIS','tunai'=>'Tunai','lainnya'=>'Lainnya'] as $val => $label)
                        <option value="{{ $val }}" {{ old('metode', $donasi->metode ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('metode')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                        @foreach(['pending'=>'Pending','confirmed'=>'Dikonfirmasi','rejected'=>'Ditolak'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $donasi->status ?? 'confirmed') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Pesan / Catatan</label>
                <textarea name="pesan" rows="2"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                    placeholder="Pesan dari donatur atau catatan admin...">{{ old('pesan', $donasi->pesan ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                {{ isset($donasi) ? 'Simpan Perubahan' : 'Tambah Donasi' }}
            </button>
            <a href="{{ route('admin.donasi.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700 px-4 py-2.5 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
