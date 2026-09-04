<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('kategori')->orderByDesc('created_at')->paginate(15);
        return view('admin.video.index', compact('videos'));
    }

    public function create()
    {
        $kategoris = Kategori::ofType('video')->get();
        return view('admin.video.form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'deskripsi'   => 'nullable|string',
            'url_youtube' => 'nullable|url',
            'thumbnail'   => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
        ]);
        $v['slug'] = Str::slug($request->judul);
        $v['is_active'] = $request->boolean('is_active', true);
        $v['is_featured'] = $request->boolean('is_featured');
        $v['published_at'] = now();
        if ($request->hasFile('thumbnail')) {
            $v['thumbnail'] = $request->file('thumbnail')->store('video', 'public');
        }
        Video::create($v);
        return redirect()->route('admin.video.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        $kategoris = Kategori::ofType('video')->get();
        return view('admin.video.form', compact('video', 'kategoris'));
    }

    public function update(Request $request, Video $video)
    {
        $v = $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'deskripsi'   => 'nullable|string',
            'url_youtube' => 'nullable|url',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);
        $v['is_active'] = $request->boolean('is_active', true);
        $v['is_featured'] = $request->boolean('is_featured');
        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) Storage::disk('public')->delete($video->thumbnail);
            $v['thumbnail'] = $request->file('thumbnail')->store('video', 'public');
        }
        $video->update($v);
        return redirect()->route('admin.video.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return back()->with('success', 'Video berhasil dihapus.');
    }

    public function show(Video $video) { return view('admin.video.show', compact('video')); }
}
