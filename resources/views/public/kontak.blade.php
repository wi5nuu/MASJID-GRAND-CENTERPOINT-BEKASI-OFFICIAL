@extends('layouts.public')

@section('title', 'Kontak — Masjid Grand Centerpoint Bekasi')

@section('content')

<section class="bg-gradient-to-br from-primary-800 to-primary-900 relative overflow-hidden py-16">
    <div class="absolute inset-0 pattern-islamic opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block text-xs font-semibold text-primary-200 uppercase tracking-widest mb-3">Hubungi Kami</span>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">Kontak & Lokasi</h1>
        <p class="text-primary-200 text-sm max-w-lg mx-auto">Kami dengan senang hati menerima pertanyaan dan masukan dari Anda.</p>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Info Kontak --}}
            <div>
                <h2 class="text-xl font-bold text-neutral-900 mb-6">Informasi Kontak</h2>
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-neutral-900 text-sm mb-1">Alamat</p>
                            <p class="text-neutral-600 text-sm">Grand Centerpoint, Jl. Ahmad Yani<br>Bekasi, Jawa Barat 17143</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-neutral-900 text-sm mb-1">Telepon</p>
                            <a href="tel:+62211234567" class="text-neutral-600 text-sm hover:text-primary-600 transition-colors">(021) 1234-5678</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-neutral-900 text-sm mb-1">Email</p>
                            <a href="mailto:info@masjidgcp.com" class="text-neutral-600 text-sm hover:text-primary-600 transition-colors">info@masjidgcp.com</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-neutral-900 text-sm mb-1">Jam Operasional Sekretariat</p>
                            <p class="text-neutral-600 text-sm">Senin – Jumat: 08.00 – 17.00 WIB</p>
                            <p class="text-neutral-600 text-sm">Sabtu: 08.00 – 12.00 WIB</p>
                            <p class="text-primary-600 text-xs mt-1 font-medium">Masjid buka 24 jam</p>
                        </div>
                    </div>
                </div>

                {{-- Map --}}
                <div class="mt-8 rounded-2xl overflow-hidden h-56 bg-neutral-200">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.99218031476878!3d-6.208763395493066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMzEuNiJTIDEwNsKwNTknMjMuMiJF!5e0!3m2!1sen!2sid!4v1234567890"
                        class="w-full h-full border-0" allowfullscreen loading="lazy" title="Lokasi Masjid"></iframe>
                </div>
            </div>

            {{-- Form --}}
            <div>
                <h2 class="text-xl font-bold text-neutral-900 mb-6">Kirim Pesan</h2>
                @if(session('success'))
                <div class="mb-5 bg-primary-50 border border-primary-200 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm text-primary-800">{{ session('success') }}</p>
                </div>
                @endif
                <form action="{{ route('kontak.kirim') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="Nama Anda">
                            @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nomor HP/WA</label>
                            <input type="tel" name="telepon" value="{{ old('telepon') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="08xx-xxxx-xxxx">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="email@anda.com">
                        @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Subjek</label>
                        <select name="subjek" class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all bg-white">
                            <option value="">Pilih subjek...</option>
                            <option value="Informasi Kegiatan" {{ old('subjek') == 'Informasi Kegiatan' ? 'selected' : '' }}>Informasi Kegiatan</option>
                            <option value="Donasi" {{ old('subjek') == 'Donasi' ? 'selected' : '' }}>Donasi</option>
                            <option value="Kerja Sama" {{ old('subjek') == 'Kerja Sama' ? 'selected' : '' }}>Kerja Sama</option>
                            <option value="Saran & Masukan" {{ old('subjek') == 'Saran & Masukan' ? 'selected' : '' }}>Saran & Masukan</option>
                            <option value="Lainnya" {{ old('subjek') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Pesan</label>
                        <textarea name="pesan" rows="5" required
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all resize-none"
                            placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
                        @error('pesan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
