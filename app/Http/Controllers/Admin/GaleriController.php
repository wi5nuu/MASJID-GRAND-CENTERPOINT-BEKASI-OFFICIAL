<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::with('kategori')->orderByDesc('created_at')->paginate(20);
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        $kategoris = Kategori::ofType('galeri')->get();
        return view('admin.galeri.form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'files.*'     => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'album'       => 'nullable|string|max:255',
        ]);

        foreach ($request->file('files', []) as $file) {
            Galeri::create([
                'judul'       => $request->judul,
                'file'        => $file->store('galeri', 'public'),
                'kategori_id' => $request->kategori_id,
                'keterangan'  => $request->keterangan,
                'album'       => $request->album,
                'is_active'   => true,
            ]);
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil diunggah.');
    }

    public function edit(Galeri $galeri)
    {
        $kategoris = Kategori::ofType('galeri')->get();
        return view('admin.galeri.form', compact('galeri', 'kategoris'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate(['judul' => 'required|string|max:255']);
        $galeri->update($request->only('judul', 'keterangan', 'album', 'kategori_id'));
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        Storage::disk('public')->delete($galeri->file);
        $galeri->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function show(Galeri $galeri) { return view('admin.galeri.show', compact('galeri')); }
}
