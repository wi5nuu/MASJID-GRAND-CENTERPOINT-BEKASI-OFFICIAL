@extends('layouts.public')
@section('title', 'Donasi '.$program->nama.' — Masjid Grand Centerpoint Bekasi')
@section('content')
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-neutral-400 mb-6">
            <a href="{{ route('donasi.index') }}" class="hover:text-primary-600">Donasi</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-neutral-600">{{ $program->nama }}</span>
        </nav>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                @if($program->thumbnail)
                <div class="rounded-2xl overflow-hidden aspect-video mb-4"><img src="{{ Storage::url($program->thumbnail) }}" alt="{{ $program->nama }}" class="w-full h-full object-cover"></div>
                @endif
                <h1 class="text-2xl font-bold text-neutral-900 mb-3">{{ $program->nama }}</h1>
                @if($program->deskripsi)<p class="text-neutral-600 text-sm leading-relaxed mb-4">{{ $program->deskripsi }}</p>@endif
                @if($program->target)
                <div class="bg-primary-50 rounded-xl p-4 mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-neutral-600">Terkumpul</span>
                        <span class="font-bold text-primary-700">{{ $program->persentase }}%</span>
                    </div>
                    <div class="h-3 bg-primary-100 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-primary-600 rounded-full" style="width:{{ min(100,$program->persentase) }}%"></div>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="font-semibold text-primary-700">Rp {{ number_format($program->terkumpul,0,',','.') }}</span>
                        <span class="text-neutral-500">Target: Rp {{ number_format($program->target,0,',','.') }}</span>
                    </div>
                </div>
                @endif
                @if($recentDonasi->isNotEmpty())
                <h3 class="font-semibold text-neutral-900 text-sm mb-2">Donatur Terbaru</h3>
                <div class="space-y-2">
                    @foreach($recentDonasi->take(5) as $d)
                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center shrink-0"><span class="text-primary-700 text-xs font-bold">{{ strtoupper(substr($d->nama,0,1)) }}</span></div>
                        <span class="text-neutral-700">{{ $d->nama }}</span>
                        <span class="ml-auto font-semibold text-primary-700 text-xs">Rp {{ number_format($d->jumlah,0,',','.') }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div>
                <div class="bg-white rounded-2xl border border-neutral-200 p-6">
                    <h2 class="font-bold text-neutral-900 mb-5">Form Donasi</h2>
                    <form action="{{ route('donasi.store') }}" method="POST" x-data="donationForm()">
                        @csrf
                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama (opsional)</label>
                                <input type="text" name="nama" placeholder="Hamba Allah"
                                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Jumlah Donasi</label>
                                <div class="grid grid-cols-2 gap-2 mb-2">
                                    @foreach([50000,100000,250000,500000] as $preset)
                                    <button type="button" @click="selectPreset({{ $preset }})"
                                        :class="amount == {{ $preset }} ? 'border-primary-600 bg-primary-50 text-primary-700' : 'border-neutral-300 text-neutral-600'"
                                        class="border-2 rounded-xl py-2 text-sm font-medium transition-colors hover:border-primary-400">
                                        Rp {{ number_format($preset,0,',','.') }}
                                    </button>
                                    @endforeach
                                </div>
                                <input type="number" name="jumlah" x-model="customAmount" placeholder="Nominal lainnya (min. Rp 10.000)"
                                    min="10000" :required="!amount"
                                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <input type="hidden" name="jumlah_hidden" :value="finalAmount">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Metode Pembayaran</label>
                                <select name="metode" class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="qris">QRIS</option>
                                    <option value="tunai">Tunai</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Pesan (opsional)</label>
                                <textarea name="pesan" rows="2" placeholder="Doa atau pesan..."
                                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-xl transition-colors">
                                Donasi Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
