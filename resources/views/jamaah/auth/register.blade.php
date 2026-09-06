<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Jamaah — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-neutral-50 antialiased min-h-screen flex">

    {{-- Left Panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-800 via-primary-700 to-primary-900 relative overflow-hidden flex-col items-center justify-center p-12">
        <div class="absolute inset-0 pattern-islamic opacity-20"></div>
        <div class="relative text-center">
            <div class="w-20 h-20 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-8 backdrop-blur-sm">
                <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                </svg>
            </div>
            <p class="font-arabic text-3xl text-gold-300 mb-2" dir="rtl">بِسْمِ اللَّهِ</p>
            <h1 class="text-3xl font-bold text-white mb-3" style="color: #ffffff !important;">Masjid Grand<br>Centerpoint Bekasi</h1>
            <p class="text-primary-200 text-sm max-w-xs mx-auto leading-relaxed">
                Bergabunglah menjadi bagian dari jamaah Masjid Grand Centerpoint Bekasi.
            </p>
        </div>
    </div>

    {{-- Right Panel: Form --}}
    <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-12 py-12">
        <div class="w-full max-w-md">

            {{-- Mobile Logo --}}
            <div class="flex flex-col items-center mb-8 lg:hidden">
                <img src="{{ asset('logo_apartemen_grand_centerpoint.png') }}"
                     alt="Logo Masjid Grand Centerpoint Bekasi"
                     class="h-12 w-auto object-contain mb-3">
                <p class="text-sm text-neutral-500">Registrasi Jamaah</p>
            </div>

            <h2 class="text-2xl font-bold text-neutral-900 mb-1">Daftar sebagai Jamaah</h2>
            <p class="text-neutral-500 text-sm mb-8">Lengkapi data diri Anda untuk menjadi bagian dari jamaah masjid.</p>

            @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    <ul class="text-xs text-red-700 space-y-0.5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('jamaah.register.post') }}" class="space-y-5" x-data="registrationForm()">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 bg-white text-neutral-900 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        placeholder="Masukkan nama lengkap">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 bg-white text-neutral-900 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        placeholder="email@contoh.com">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-neutral-700 mb-1.5">No. WhatsApp</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 bg-white text-neutral-900 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        placeholder="08xxxxxxxxxx">
                </div>

                {{-- Unit Info --}}
                <div class="p-4 bg-primary-50 rounded-xl border border-primary-100">
                    <p class="text-xs font-semibold text-primary-700 mb-3 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Informasi Unit
                    </p>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label for="building" class="block text-xs font-medium text-neutral-600 mb-1">Gedung</label>
                            <select id="building" name="building" x-model="building" required
                                class="w-full px-2.5 py-2 rounded-lg border border-neutral-300 bg-white text-neutral-900 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                                <option value="">Gedung</option>
                                <option value="C" {{ old('building') == 'C' ? 'selected' : '' }}>Gedung C</option>
                                <option value="D" {{ old('building') == 'D' ? 'selected' : '' }}>Gedung D</option>
                            </select>
                        </div>
                        <div>
                            <label for="floor" class="block text-xs font-medium text-neutral-600 mb-1">Lantai</label>
                            <select id="floor" name="floor" x-model="floor" required
                                class="w-full px-2.5 py-2 rounded-lg border border-neutral-300 bg-white text-neutral-900 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                                <option value="">Lantai</option>
                                @for($i = 1; $i <= 18; $i++)
                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ old('floor') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>Lantai {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="unit" class="block text-xs font-medium text-neutral-600 mb-1">Nomor Unit</label>
                            <input type="text" id="unit" name="unit" x-model="unit" maxlength="2" required
                                class="w-full px-2.5 py-2 rounded-lg border border-neutral-300 bg-white text-neutral-900 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="01" @input="unit = unit.replace(/[^0-9]/g, '').substring(0, 2)">
                        </div>
                    </div>

                    <p class="text-xs text-neutral-500 mt-2.5">
                        Contoh: Lantai 7 Gedung C, Unit 01 → <span class="font-semibold text-primary-600" x-text="unitNo"></span>
                    </p>
                    <input type="hidden" name="unit_no" :value="unitNo">
                </div>

                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium text-neutral-700 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 bg-white text-neutral-900 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all pr-12"
                            placeholder="Minimal 6 karakter">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-400 hover:text-primary-600 transition-colors" aria-label="Tampilkan/Sembunyikan kata sandi">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L3 3m18 18L3 3"/></svg>
                        </button>
                    </div>
                </div>

                <div x-data="{ showConfirmPassword: false }">
                    <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 bg-white text-neutral-900 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all pr-12"
                            placeholder="Ulangi kata sandi">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-400 hover:text-primary-600 transition-colors" aria-label="Tampilkan/Sembunyikan kata sandi">
                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L3 3m18 18L3 3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-xs text-neutral-400 mt-8">
                Sudah punya akun? <a href="{{ route('jamaah.login') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Masuk</a>
            </p>
        </div>
    </div>

    <script>
    function registrationForm() {
        return {
            building: '{{ old('building') }}',
            floor: '{{ old('floor') }}',
            unit: '{{ old('unit') }}',
            get unitNo() {
                if (this.building && this.floor && this.unit) {
                    return this.building + this.floor + this.unit.padStart(2, '0');
                }
                return '';
            }
        }
    }
    </script>
</body>
</html>
