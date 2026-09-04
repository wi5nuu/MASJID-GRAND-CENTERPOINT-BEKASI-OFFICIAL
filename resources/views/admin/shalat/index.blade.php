@extends('layouts.admin')

@section('title', 'Jadwal Shalat')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Jadwal Shalat</span>
@endsection

@section('content')
<div class="space-y-5" x-data="shalatManager()">

    {{-- Header --}}
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">Jadwal Shalat</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Kelola jadwal waktu shalat harian · Kota Bekasi</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            {{-- Fetch dari API --}}
            <button @click="showFetch = true"
                class="inline-flex items-center gap-2 border border-primary-600 text-primary-600 hover:bg-primary-50 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Impor dari API
            </button>
            <button @click="showAdd = true"
                class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Manual
            </button>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Today highlight --}}
    @php $today = $jadwals->firstWhere('tanggal', now()->toDateString()); @endphp
    @if($today)
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl p-5 text-white">
        <p class="text-primary-200 text-xs mb-3">Jadwal Hari Ini — {{ \Carbon\Carbon::today()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
            @foreach(['subuh','syuruq','dzuhur','ashar','maghrib','isya'] as $waktu)
            <div class="text-center">
                <p class="text-primary-200 text-xs capitalize mb-1">{{ $waktu }}</p>
                <p class="font-bold text-lg">{{ $today->$waktu ?? '--:--' }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Tanggal</th>
                        <th class="text-center px-3 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Subuh</th>
                        <th class="text-center px-3 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Syuruq</th>
                        <th class="text-center px-3 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Dzuhur</th>
                        <th class="text-center px-3 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Ashar</th>
                        <th class="text-center px-3 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Maghrib</th>
                        <th class="text-center px-3 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Isya</th>
                        <th class="text-right px-5 py-3.5 font-semibold text-neutral-600 text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($jadwals as $jadwal)
                    @php $isToday = $jadwal->tanggal == now()->toDateString(); @endphp
                    <tr class="{{ $isToday ? 'bg-primary-50' : 'hover:bg-neutral-50' }} transition-colors">
                        <td class="px-5 py-3">
                            <p class="font-medium {{ $isToday ? 'text-primary-700' : 'text-neutral-800' }} text-sm">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                            </p>
                            @if($isToday)<span class="text-xs text-primary-500 font-medium">Hari ini</span>@endif
                        </td>
                        @foreach(['subuh','syuruq','dzuhur','ashar','maghrib','isya'] as $waktu)
                        <td class="px-3 py-3 text-center text-sm {{ $isToday ? 'text-primary-700 font-semibold' : 'text-neutral-600' }}">
                            {{ $jadwal->$waktu ?? '-' }}
                        </td>
                        @endforeach
                        <td class="px-5 py-3 text-right">
                            <button
                                @click="openEdit({
                                    id: {{ $jadwal->id }},
                                    tanggal: '{{ $jadwal->tanggal }}',
                                    subuh: '{{ $jadwal->subuh ?? '' }}',
                                    syuruq: '{{ $jadwal->syuruq ?? '' }}',
                                    dzuhur: '{{ $jadwal->dzuhur ?? '' }}',
                                    ashar: '{{ $jadwal->ashar ?? '' }}',
                                    maghrib: '{{ $jadwal->maghrib ?? '' }}',
                                    isya: '{{ $jadwal->isya ?? '' }}'
                                })"
                                class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors inline-flex" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-12 text-center text-neutral-400 text-sm">Belum ada data jadwal shalat</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jadwals->hasPages())
        <div class="px-5 py-4 border-t border-neutral-100">{{ $jadwals->links() }}</div>
        @endif
    </div>

    {{-- ── Edit Modal ── --}}
    <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="showEdit = false">
        <div class="absolute inset-0 bg-black/50" @click="showEdit = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 z-10">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-bold text-neutral-900">Edit Jadwal Shalat</h2>
                    <p class="text-xs text-neutral-500 mt-0.5" x-text="editData.tanggal"></p>
                </div>
                <button @click="showEdit = false" class="p-1 rounded-lg text-neutral-400 hover:bg-neutral-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form :action="`/admin/shalat/${editData.id}`" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-5">
                    @foreach(['subuh','syuruq','dzuhur','ashar','maghrib','isya'] as $w)
                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1.5 capitalize">{{ $w }}</label>
                        <input type="time" name="{{ $w }}" x-model="editData.{{ $w }}"
                            class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    @endforeach
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                        Simpan
                    </button>
                    <button type="button" @click="showEdit = false"
                        class="px-4 py-2.5 rounded-xl border border-neutral-300 text-neutral-600 text-sm hover:bg-neutral-50 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Tambah Modal ── --}}
    <div x-show="showAdd" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="showAdd = false">
        <div class="absolute inset-0 bg-black/50" @click="showAdd = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 z-10">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-neutral-900">Tambah Jadwal Shalat</h2>
                <button @click="showAdd = false" class="p-1 rounded-lg text-neutral-400 hover:bg-neutral-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('admin.shalat.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium text-neutral-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" required
                        class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-5">
                    @foreach(['subuh','syuruq','dzuhur','ashar','maghrib','isya'] as $w)
                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1.5 capitalize">{{ $w }}</label>
                        <input type="time" name="{{ $w }}"
                            class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    @endforeach
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                        Simpan
                    </button>
                    <button type="button" @click="showAdd = false"
                        class="px-4 py-2.5 rounded-xl border border-neutral-300 text-neutral-600 text-sm hover:bg-neutral-50 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- ── Fetch API Modal ── --}}
    <div x-show="showFetch" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="showFetch = false">
        <div class="absolute inset-0 bg-black/50" @click="showFetch = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 z-10">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-bold text-neutral-900">Impor dari API</h2>
                    <p class="text-xs text-neutral-500 mt-0.5">Aladhan API · Kota Bekasi</p>
                </div>
                <button @click="showFetch = false" class="p-1 rounded-lg text-neutral-400 hover:bg-neutral-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('admin.shalat.fetch') }}" method="POST">
                @csrf
                <div class="space-y-4 mb-5">
                    <div class="bg-primary-50 rounded-xl px-4 py-3 text-xs text-primary-700">
                        Akan mengimpor jadwal shalat untuk seluruh bulan yang dipilih dari Aladhan API secara otomatis.
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1.5">Bulan <span class="text-red-500">*</span></label>
                        <select name="bulan" required class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                            <option value="{{ $i+1 }}" {{ ($i+1) == now()->month ? 'selected' : '' }}>{{ $bln }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1.5">Tahun <span class="text-red-500">*</span></label>
                        <select name="tahun" required class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @for($y = now()->year - 1; $y <= now()->year + 2; $y++)
                            <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Impor Sekarang
                    </button>
                    <button type="button" @click="showFetch = false" class="px-4 py-2.5 rounded-xl border border-neutral-300 text-neutral-600 text-sm hover:bg-neutral-50 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function shalatManager() {
    return {
        showEdit: false,
        showAdd: false,
        showFetch: false,
        editData: { id: null, tanggal: '', subuh: '', syuruq: '', dzuhur: '', ashar: '', maghrib: '', isya: '' },
        openEdit(data) {
            this.editData = { ...data };
            this.showEdit = true;
        }
    }
}
</script>
@endpush
