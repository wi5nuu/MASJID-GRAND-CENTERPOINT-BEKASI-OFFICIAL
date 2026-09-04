<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\MediaFile::orderByDesc('created_at');
        if ($request->filled('tipe')) $query->where('mime_type', 'like', $request->tipe.'%');
        $files = $query->paginate(30)->withQueryString();
        return view('admin.media.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate(['file' => 'required|file|max:10240', 'koleksi' => 'nullable|string|max:100']);
        $file = $request->file('file');
        $path = $file->store('media', 'public');
        \App\Models\MediaFile::create([
            'user_id'   => auth()->id(),
            'nama'      => $request->nama ?? $file->getClientOriginalName(),
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'koleksi'   => $request->koleksi,
        ]);
        return back()->with('success', 'File berhasil diunggah.');
    }

    public function destroy(\App\Models\MediaFile $media)
    {
        Storage::disk('public')->delete($media->file_path);
        $media->delete();
        return back()->with('success', 'File berhasil dihapus.');
    }
}
