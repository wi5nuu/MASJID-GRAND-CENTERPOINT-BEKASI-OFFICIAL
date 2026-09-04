<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::published()->with('kategori')->orderByDesc('published_at');

        if ($request->filled('kategori')) {
            $query->whereHas('kategori', fn($q) => $q->where('slug', $request->kategori));
        }

        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }

        $beritas = $query->paginate(9)->withQueryString();
        $kategoris = Kategori::ofType('berita')->get();
        $featured = Berita::published()->featured()->orderByDesc('published_at')->limit(3)->get();

        return view('public.berita.index', compact('beritas', 'kategoris', 'featured'));
    }

    public function show(Berita $berita)
    {
        if ($berita->status !== 'published') abort(404);

        $berita->increment('views');

        $related = Berita::published()
            ->where('id', '!=', $berita->id)
            ->where('kategori_id', $berita->kategori_id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('public.berita.show', compact('berita', 'related'));
    }
}
