@extends('layouts.admin')

@section('title', 'Pengaturan Situs')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Pengaturan</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Pengaturan Situs</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Konfigurasi umum website masjid</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Umum --}}
        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
            <h3 class="font-semibold text-neutral-800 text-sm border-b border-neutral-100 pb-3">Informasi Umum</h3>
            @foreach(['site_name'=>'Nama Situs','site_tagline'=>'Tagline'] as $key=>$label)
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">{{ $label }}</label>
                <input type="text" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            @endforeach
        </div>

        {{-- Kontak --}}
        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
            <h3 class="font-semibold text-neutral-800 text-sm border-b border-neutral-100 pb-3">Informasi Kontak</h3>
            @foreach(['site_email'=>'Email','site_phone'=>'Telepon','whatsapp_number'=>'WhatsApp'] as $key=>$label)
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">{{ $label }}</label>
                <input type="text" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            @endforeach
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Alamat</label>
                <textarea name="site_address" rows="2"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ old('site_address', $settings['site_address'] ?? '') }}</textarea>
            </div>
        </div>

        {{-- Media Sosial --}}
        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
            <h3 class="font-semibold text-neutral-800 text-sm border-b border-neutral-100 pb-3">Media Sosial</h3>
            @foreach(['facebook_url'=>'Facebook URL','instagram_url'=>'Instagram URL','youtube_url'=>'YouTube URL'] as $key=>$label)
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">{{ $label }}</label>
                <input type="url" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}"
                    placeholder="https://..."
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            @endforeach
        </div>

        {{-- Donasi --}}
        <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
            <h3 class="font-semibold text-neutral-800 text-sm border-b border-neutral-100 pb-3">Pengaturan Donasi</h3>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Info Rekening Bank</label>
                <textarea name="donasi_rekening" rows="3"
                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                    placeholder="Nama Bank&#10;No. Rekening&#10;Atas Nama">{{ old('donasi_rekening', $settings['donasi_rekening'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">QRIS (Gambar)</label>
                @if(!empty($settings['donasi_qris']))
                <div class="mb-2">
                    <img src="{{ Storage::url($settings['donasi_qris']) }}" class="w-32 h-32 object-contain rounded-xl border border-neutral-200">
                </div>
                @endif
                <input type="file" name="donasi_qris" accept="image/*"
                    class="w-full text-sm text-neutral-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700 file:font-medium hover:file:bg-primary-100">
            </div>
        </div>

    </div>

    <div class="mt-5">
        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
            Simpan Pengaturan
        </button>
    </div>
</form>

@endsection
