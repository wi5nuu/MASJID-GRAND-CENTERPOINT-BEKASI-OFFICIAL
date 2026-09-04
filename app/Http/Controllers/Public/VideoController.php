<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Kategori;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::active()->with('kategori')->orderByDesc('published_at');
        if ($request->filled('kategori')) $query->whereHas('kategori', fn($q) => $q->where('slug', $request->kategori));
        $videos = $query->paginate(12)->withQueryString();
        $kategoris = Kategori::ofType('video')->get();
        return view('public.video.index', compact('videos', 'kategoris'));
    }

    public function show(Video $video)
    {
        if (!$video->is_active) abort(404);
        $video->increment('views');
        $related = Video::active()->where('id', '!=', $video->id)->limit(6)->get();
        return view('public.video.show', compact('video', 'related'));
    }
}
