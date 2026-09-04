<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Kategori;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $query = Galeri::active()->with('kategori')->orderByDesc('created_at');
        if ($request->filled('album')) $query->where('album', $request->album);
        $galeris = $query->paginate(24)->withQueryString();
        $albums = Galeri::active()->distinct()->pluck('album')->filter();
        return view('public.galeri.index', compact('galeris', 'albums'));
    }
}
