@extends('layouts.admin')

@section('title', 'Manajemen SEO')
@section('breadcrumb')
    <span class="text-neutral-600 text-sm font-medium">Manajemen SEO</span>
@endsection

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div>
        <h1 class="text-xl font-bold text-neutral-900">Manajemen SEO</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Kelola meta title, description, dan keyword untuk setiap halaman</p>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Info card --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 flex items-start gap-3">
        <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-xs text-blue-700 leading-relaxed">
            Meta title disarankan <strong>50–60 karakter</strong>, meta description <strong>120–160 karakter</strong>.
            Gunakan kata kunci yang relevan untuk meningkatkan peringkat di mesin pencari.
        </p>
    </div>

    {{-- SEO Pages --}}
    @forelse($pages as $page)
    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100 bg-neutral-50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-900">{{ $page->nama ?? ucfirst(str_replace('-', ' ', $page->page ?? $page->id)) }}</p>
                    <p class="text-xs text-neutral-400">{{ $page->page ?? 'page-' . $page->id }}</p>
                </div>
            </div>
            {{-- Google preview toggle --}}
            <button type="button" x-data="{}" @click="$el.closest('.bg-white').querySelector('.seo-preview').classList.toggle('hidden')"
                class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Pratinjau Google
            </button>
        </div>

        {{-- Google preview --}}
        <div class="seo-preview hidden px-5 py-3 bg-neutral-50 border-b border-neutral-100">
            <p class="text-xs text-neutral-400 mb-2 font-medium uppercase tracking-wide">Pratinjau di Google</p>
            <p class="text-blue-600 text-sm font-medium truncate">{{ $page->meta_title ?? 'Meta title belum diisi' }}</p>
            <p class="text-green-700 text-xs mt-0.5">masjidgcp.com › {{ $page->page ?? '' }}</p>
            <p class="text-neutral-500 text-xs mt-1 leading-relaxed line-clamp-2">{{ $page->meta_description ?? 'Meta description belum diisi.' }}</p>
        </div>

        <form action="{{ route('admin.seo.update', $page) }}" method="POST" class="p-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-medium text-neutral-700">Meta Title</label>
                        <span class="text-xs text-neutral-400" id="title-count-{{ $page->id }}">
                            {{ strlen($page->meta_title ?? '') }}/60
                        </span>
                    </div>
                    <input type="text" name="meta_title"
                        value="{{ old('meta_title', $page->meta_title ?? '') }}"
                        maxlength="80"
                        oninput="document.getElementById('title-count-{{ $page->id }}').textContent = this.value.length + '/60'; this.style.borderColor = this.value.length > 60 ? '#ef4444' : ''"
                        class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                        placeholder="Judul halaman untuk mesin pencari">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-medium text-neutral-700">Meta Keywords</label>
                        <span class="text-xs text-neutral-400">pisahkan dengan koma</span>
                    </div>
                    <input type="text" name="meta_keywords"
                        value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}"
                        class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                        placeholder="masjid, bekasi, jadwal shalat">
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-medium text-neutral-700">Meta Description</label>
                        <span class="text-xs text-neutral-400" id="desc-count-{{ $page->id }}">
                            {{ strlen($page->meta_description ?? '') }}/160
                        </span>
                    </div>
                    <textarea name="meta_description" rows="2" maxlength="200"
                        oninput="document.getElementById('desc-count-{{ $page->id }}').textContent = this.value.length + '/160'; this.style.borderColor = this.value.length > 160 ? '#ef4444' : ''"
                        class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all resize-none"
                        placeholder="Deskripsi singkat halaman untuk mesin pencari...">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs font-medium text-neutral-700 mb-1.5 block">OG Image URL</label>
                    <input type="url" name="og_image"
                        value="{{ old('og_image', $page->og_image ?? '') }}"
                        class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                        placeholder="https://...">
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-neutral-200 py-16 text-center">
        <div class="w-14 h-14 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-7 h-7 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <p class="text-sm font-medium text-neutral-500">Belum ada data SEO</p>
        <p class="text-xs text-neutral-400 mt-1">Data SEO akan muncul setelah migration dan seeder dijalankan</p>
    </div>
    @endforelse

</div>
@endsection
