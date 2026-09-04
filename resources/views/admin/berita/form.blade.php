@extends('layouts.admin')

@section('title', isset($berita) ? 'Edit Berita' : 'Tulis Berita Baru')

@section('breadcrumb')
    <a href="{{ route('admin.berita.index') }}" class="text-neutral-500 hover:text-primary-600 text-sm transition-colors">Berita</a>
    <svg class="w-4 h-4 text-neutral-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 text-sm font-medium">{{ isset($berita) ? 'Edit' : 'Tulis Baru' }}</span>
@endsection

@push('head')
{{-- Quill --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<style>
    /* ── Editor container ── */
    #quill-editor {
        min-height: 480px;
        font-size: 1rem;
        line-height: 1.8;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1a1a1a;
    }
    #quill-editor p { margin-bottom: 0.75em; }
    #quill-editor h1 { font-size: 1.875rem; font-weight: 700; margin: 1.25em 0 0.5em; }
    #quill-editor h2 { font-size: 1.5rem; font-weight: 700; margin: 1.25em 0 0.5em; }
    #quill-editor h3 { font-size: 1.25rem; font-weight: 600; margin: 1em 0 0.5em; }
    #quill-editor blockquote {
        border-left: 4px solid #16a34a;
        padding-left: 1rem;
        color: #6b7280;
        font-style: italic;
        margin: 1.25em 0;
    }
    #quill-editor pre.ql-syntax {
        background: #1e293b;
        color: #e2e8f0;
        padding: 1rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        overflow-x: auto;
    }
    #quill-editor img { max-width: 100%; border-radius: 0.75rem; margin: 0.75em 0; }
    #quill-editor ul, #quill-editor ol { padding-left: 1.5rem; margin-bottom: 0.75em; }

    /* ── Quill toolbar styling ── */
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 10px 12px;
        background: #f9fafb;
        border-radius: 1rem 1rem 0 0;
        flex-wrap: wrap;
        gap: 2px;
    }
    .ql-container.ql-snow {
        border: none !important;
        border-radius: 0 0 1rem 1rem;
    }
    .ql-toolbar .ql-formats { margin-right: 8px; }
    .ql-snow .ql-picker-label { font-size: 0.8rem; }
    .ql-snow.ql-toolbar button:hover,
    .ql-snow .ql-toolbar button:hover,
    .ql-snow.ql-toolbar button.ql-active,
    .ql-snow .ql-toolbar button.ql-active {
        color: #16a34a !important;
    }
    .ql-snow.ql-toolbar button:hover .ql-stroke,
    .ql-snow .ql-toolbar button:hover .ql-stroke,
    .ql-snow.ql-toolbar button.ql-active .ql-stroke,
    .ql-snow .ql-toolbar button.ql-active .ql-stroke {
        stroke: #16a34a !important;
    }
    .ql-snow.ql-toolbar button:hover .ql-fill,
    .ql-snow .ql-toolbar button:hover .ql-fill,
    .ql-snow.ql-toolbar button.ql-active .ql-fill {
        fill: #16a34a !important;
    }

    /* ── Thumbnail preview ── */
    #thumb-preview { display: none; }
    #thumb-preview.show { display: block; }

    /* ── Word count badge ── */
    #word-count { transition: all 0.2s; }

    /* ── Editor wrapper border ── */
    .editor-wrapper {
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        overflow: hidden;
    }
    .editor-wrapper:focus-within {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
</style>
@endpush

@section('content')

<div x-data="beritaForm()" class="max-w-5xl">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-neutral-900">{{ isset($berita) ? 'Edit Berita' : 'Tulis Berita Baru' }}</h1>
            <p class="text-sm text-neutral-500 mt-0.5">{{ isset($berita) ? 'Perbarui konten artikel' : 'Buat artikel berita baru untuk ditayangkan' }}</p>
        </div>
        <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form id="berita-form"
          action="{{ isset($berita) ? route('admin.berita.update', $berita) : route('admin.berita.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($berita)) @method('PUT') @endif

        {{-- Hidden input untuk konten Quill --}}
        <input type="hidden" name="konten" id="konten-input" value="{{ old('konten', $berita->konten ?? '') }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- ── Kolom kiri (konten utama) ── --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Judul & Ringkasan --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 mb-1.5">
                            Judul Artikel <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul-input"
                            value="{{ old('judul', $berita->judul ?? '') }}" required
                            @input="updateSlugPreview($event.target.value)"
                            class="w-full px-4 py-3 rounded-xl border border-neutral-300 text-base font-semibold focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all placeholder:font-normal"
                            placeholder="Tulis judul yang menarik dan informatif...">
                        @error('judul')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

                        {{-- Slug preview --}}
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs text-neutral-400">URL:</span>
                            <span class="text-xs text-primary-600 font-mono" id="slug-preview">
                                /berita/{{ $berita->slug ?? '...' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 mb-1.5">
                            Ringkasan
                            <span class="font-normal text-neutral-400 ml-1">(tampil di listing & SEO)</span>
                        </label>
                        <textarea name="ringkasan" rows="3" maxlength="300"
                            @input="ringkasanCount = $event.target.value.length"
                            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all resize-none"
                            placeholder="Tulis ringkasan singkat artikel ini (maks. 300 karakter)...">{{ old('ringkasan', $berita->ringkasan ?? '') }}</textarea>
                        <p class="text-xs text-neutral-400 mt-1 text-right">
                            <span x-text="ringkasanCount"></span>/300 karakter
                        </p>
                    </div>
                </div>

                {{-- ── Quill Editor ── --}}
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    <div class="flex items-center justify-between px-5 pt-4 pb-3 border-b border-neutral-100">
                        <label class="text-sm font-semibold text-neutral-700">
                            Konten Artikel <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <span id="word-count" class="text-xs text-neutral-400 bg-neutral-100 px-2.5 py-1 rounded-full">
                                0 kata
                            </span>
                            <span class="text-xs text-neutral-400 bg-neutral-100 px-2.5 py-1 rounded-full" id="read-time">
                                ~0 menit baca
                            </span>
                        </div>
                    </div>

                    {{-- Toolbar + Editor wrapper --}}
                    <div class="editor-wrapper mx-5 mb-5 mt-4">
                        <div id="quill-toolbar">
                            <span class="ql-formats">
                                <select class="ql-header">
                                    <option value="1">Heading 1</option>
                                    <option value="2">Heading 2</option>
                                    <option value="3">Heading 3</option>
                                    <option selected>Normal</option>
                                </select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold" title="Bold"></button>
                                <button class="ql-italic" title="Italic"></button>
                                <button class="ql-underline" title="Underline"></button>
                                <button class="ql-strike" title="Strikethrough"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color" title="Warna teks"></select>
                                <select class="ql-background" title="Highlight"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered" title="Daftar bernomor"></button>
                                <button class="ql-list" value="bullet" title="Daftar bullet"></button>
                                <button class="ql-indent" value="-1" title="Kurangi indent"></button>
                                <button class="ql-indent" value="+1" title="Tambah indent"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-align" title="Perataan teks">
                                    <option selected></option>
                                    <option value="center"></option>
                                    <option value="right"></option>
                                    <option value="justify"></option>
                                </select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-blockquote" title="Blockquote"></button>
                                <button class="ql-code-block" title="Code block"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link" title="Tambah link"></button>
                                <button class="ql-image" title="Tambah gambar"></button>
                                <button class="ql-video" title="Tambah video"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean" title="Hapus format"></button>
                            </span>
                        </div>
                        <div id="quill-editor"></div>
                    </div>

                    @error('konten')<p class="text-xs text-red-500 mx-5 mb-4">{{ $message }}</p>@enderror
                </div>

                {{-- SEO --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="font-semibold text-neutral-900 text-sm">Pengaturan SEO</h3>
                    </div>

                    {{-- Google preview --}}
                    <div class="bg-neutral-50 rounded-xl p-4 mb-4 border border-neutral-200">
                        <p class="text-xs text-neutral-400 mb-2 font-medium uppercase tracking-wide">Pratinjau Google</p>
                        <p class="text-blue-600 text-sm font-medium truncate" id="seo-title-preview">
                            {{ $berita->meta_title ?? $berita->judul ?? 'Judul artikel Anda...' }}
                        </p>
                        <p class="text-green-700 text-xs mt-0.5">masjidgcp.com › berita › <span id="seo-slug-preview">{{ $berita->slug ?? 'slug-artikel' }}</span></p>
                        <p class="text-neutral-500 text-xs mt-1 leading-relaxed line-clamp-2" id="seo-desc-preview">
                            {{ $berita->meta_description ?? $berita->ringkasan ?? 'Deskripsi meta artikel Anda akan muncul di sini...' }}
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Meta Title</label>
                                <span class="text-xs" id="meta-title-count"
                                    :class="metaTitleLen > 60 ? 'text-red-500' : 'text-neutral-400'"
                                    x-text="metaTitleLen + '/60'"></span>
                            </div>
                            <input type="text" name="meta_title" maxlength="80"
                                value="{{ old('meta_title', $berita->meta_title ?? '') }}"
                                @input="metaTitleLen = $event.target.value.length; document.getElementById('seo-title-preview').textContent = $event.target.value || document.getElementById('judul-input').value || 'Judul artikel Anda...'"
                                class="w-full px-4 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                                placeholder="Kosongkan untuk menggunakan judul artikel">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-neutral-700">Meta Description</label>
                                <span class="text-xs" id="meta-desc-count"
                                    :class="metaDescLen > 160 ? 'text-red-500' : 'text-neutral-400'"
                                    x-text="metaDescLen + '/160'"></span>
                            </div>
                            <textarea name="meta_description" rows="2" maxlength="200"
                                @input="metaDescLen = $event.target.value.length; document.getElementById('seo-desc-preview').textContent = $event.target.value || 'Deskripsi meta artikel Anda akan muncul di sini...'"
                                class="w-full px-4 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all resize-none"
                                placeholder="Kosongkan untuk menggunakan ringkasan">{{ old('meta_description', $berita->meta_description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Sidebar kanan ── --}}
            <div class="space-y-5">

                {{-- Publish card --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5 sticky top-5">
                    <h3 class="font-semibold text-neutral-900 text-sm mb-4">Penerbitan</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-neutral-600 mb-1.5">Status</label>
                            <select name="status" class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                                <option value="draft"      {{ old('status', $berita->status ?? 'draft') === 'draft'     ? 'selected' : '' }}>Draft</option>
                                <option value="published"  {{ old('status', $berita->status ?? '') === 'published'      ? 'selected' : '' }}>Tayangkan</option>
                                <option value="archived"   {{ old('status', $berita->status ?? '') === 'archived'       ? 'selected' : '' }}>Arsip</option>
                            </select>
                        </div>
                        <label class="flex items-center gap-2.5 cursor-pointer py-1">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured', ($berita->is_featured ?? false)) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                            <div>
                                <span class="text-sm text-neutral-700 font-medium">Unggulan</span>
                                <p class="text-xs text-neutral-400">Tampil di hero section</p>
                            </div>
                        </label>
                    </div>
                    <div class="flex flex-col gap-2 mt-5">
                        <button type="submit"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-colors text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ isset($berita) ? 'Perbarui Artikel' : 'Simpan Artikel' }}
                        </button>
                        <a href="{{ route('admin.berita.index') }}"
                            class="w-full text-center px-4 py-2 rounded-xl border border-neutral-300 text-neutral-600 hover:bg-neutral-50 text-sm font-medium transition-colors">
                            Batal
                        </a>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h3 class="font-semibold text-neutral-900 text-sm mb-3">Kategori</h3>
                    <select name="kategori_id" class="w-full px-3 py-2 rounded-xl border border-neutral-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                        <option value="">Tanpa kategori</option>
                        @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_id', $berita->kategori_id ?? '') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Thumbnail --}}
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h3 class="font-semibold text-neutral-900 text-sm mb-3">Thumbnail Artikel</h3>

                    {{-- Preview --}}
                    <div id="thumb-preview" class="{{ isset($berita) && $berita->thumbnail ? 'show' : '' }} mb-3 rounded-xl overflow-hidden relative group">
                        <img id="thumb-img"
                            src="{{ isset($berita) && $berita->thumbnail ? Storage::url($berita->thumbnail) : '' }}"
                            alt="Thumbnail" class="w-full h-40 object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white text-xs font-medium">Klik area bawah untuk ganti</span>
                        </div>
                    </div>

                    <label class="block cursor-pointer" id="thumb-label">
                        <div class="border-2 border-dashed border-neutral-300 rounded-xl p-5 text-center hover:border-primary-400 hover:bg-primary-50 transition-colors">
                            <svg class="w-8 h-8 text-neutral-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-neutral-500 font-medium">Klik untuk unggah</p>
                            <p class="text-xs text-neutral-400 mt-0.5">JPG, PNG, WEBP · maks. 2MB</p>
                            <p class="text-xs text-neutral-400">Disarankan 1200×630px</p>
                        </div>
                        <input type="file" name="thumbnail" id="thumb-input" accept="image/*" class="hidden"
                            onchange="previewThumbnail(this)">
                    </label>
                    @error('thumbnail')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tags / info artikel --}}
                @if(isset($berita))
                <div class="bg-white rounded-2xl border border-neutral-200 p-5">
                    <h3 class="font-semibold text-neutral-900 text-sm mb-3">Info Artikel</h3>
                    <div class="space-y-2 text-xs text-neutral-500">
                        <div class="flex justify-between">
                            <span>Dibuat</span>
                            <span class="font-medium text-neutral-700">{{ $berita->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diperbarui</span>
                            <span class="font-medium text-neutral-700">{{ $berita->updated_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Penulis</span>
                            <span class="font-medium text-neutral-700">{{ $berita->author->name ?? auth()->user()->name }}</span>
                        </div>
                        @if($berita->views ?? false)
                        <div class="flex justify-between">
                            <span>Dibaca</span>
                            <span class="font-medium text-neutral-700">{{ number_format($berita->views) }}x</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// ── Alpine component ──────────────────────────────────────────────
function beritaForm() {
    return {
        ringkasanCount: {{ strlen(old('ringkasan', $berita->ringkasan ?? '')) }},
        metaTitleLen:   {{ strlen(old('meta_title', $berita->meta_title ?? '')) }},
        metaDescLen:    {{ strlen(old('meta_description', $berita->meta_description ?? '')) }},

        updateSlugPreview(val) {
            const slug = val.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
            document.getElementById('slug-preview').textContent = '/berita/' + (slug || '...');
            document.getElementById('seo-slug-preview').textContent = slug || 'slug-artikel';
            // Sync seo title preview if meta_title empty
            const metaTitle = document.querySelector('[name="meta_title"]');
            if (!metaTitle.value) {
                document.getElementById('seo-title-preview').textContent = val || 'Judul artikel Anda...';
            }
        }
    }
}

// ── Thumbnail preview ─────────────────────────────────────────────
function previewThumbnail(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('thumb-preview');
            const img = document.getElementById('thumb-img');
            img.src = e.target.result;
            preview.classList.add('show');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── Quill init ────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: '#quill-toolbar',
            history: { delay: 1000, maxStack: 100 }
        },
        placeholder: 'Mulai menulis artikel Anda di sini...\n\nGunakan toolbar di atas untuk memformat teks, menambahkan gambar, link, dan lainnya.',
    });

    // Load existing content
    const existing = document.getElementById('konten-input').value;
    if (existing) {
        quill.clipboard.dangerouslyPasteHTML(existing);
    }

    // Sync ke hidden input saat form submit
    document.getElementById('berita-form').addEventListener('formdata', function () {
        document.getElementById('konten-input').value = quill.root.innerHTML;
    });

    // Fallback: sync sebelum submit
    document.getElementById('berita-form').addEventListener('submit', function () {
        document.getElementById('konten-input').value = quill.root.innerHTML;
    });

    // Word count & read time
    function updateStats() {
        const text = quill.getText().trim();
        const words = text ? text.split(/\s+/).filter(w => w.length > 0).length : 0;
        const readTime = Math.max(1, Math.ceil(words / 200));
        document.getElementById('word-count').textContent = words.toLocaleString('id') + ' kata';
        document.getElementById('read-time').textContent = '~' + readTime + ' menit baca';
    }

    quill.on('text-change', updateStats);
    updateStats();
});
</script>
@endpush
