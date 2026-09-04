<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('kategori', 'user')->orderByDesc('created_at');

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('cari')) $query->where('judul', 'like', '%'.$request->cari.'%');

        $beritas = $query->paginate(15)->withQueryString();
        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        $kategoris = Kategori::ofType('berita')->get();
        return view('admin.berita.form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255',
            'kategori_id'      => 'nullable|exists:kategoris,id',
            'ringkasan'        => 'nullable|string|max:500',
            'konten'           => 'required|string',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,published,archived',
            'is_featured'      => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords'    => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($request->judul);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        }

        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Berita::create($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        $kategoris = Kategori::ofType('berita')->get();
        return view('admin.berita.form', compact('berita', 'kategoris'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255',
            'kategori_id'      => 'nullable|exists:kategoris,id',
            'ringkasan'        => 'nullable|string|max:500',
            'konten'           => 'required|string',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,published,archived',
            'is_featured'      => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail) Storage::disk('public')->delete($berita->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        }

        if ($validated['status'] === 'published' && !$berita->published_at) {
            $validated['published_at'] = now();
        }

        $berita->update($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();
        return back()->with('success', 'Berita berhasil dihapus.');
    }
}
