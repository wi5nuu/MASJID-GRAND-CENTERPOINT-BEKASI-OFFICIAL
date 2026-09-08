<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Traits\OptimizesImages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    use OptimizesImages;

    public function index() { return view('admin.event.index', ['events' => Event::orderByDesc('tanggal_mulai')->paginate(15)]); }
    public function create() { return view('admin.event.form'); }

    public function store(Request $request)
    {
        $v = $request->validate([
            'judul'        => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'  => 'nullable|date_format:H:i',
            'lokasi'       => 'nullable|string|max:255',
            'kuota'        => 'nullable|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'konten'       => 'nullable|string',
            'thumbnail'    => 'nullable|image|max:2048',
        ]);
        $slug = Str::slug($request->judul);
        $originalSlug = $slug;
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $v['slug'] = $slug;
        $v['is_active'] = $request->boolean('is_active', true);
        $v['is_featured'] = $request->boolean('is_featured');
        if ($request->hasFile('thumbnail')) $v['thumbnail'] = $this->optimizeImage($request->file('thumbnail'), 'event');
        Event::create($v);
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event) { return view('admin.event.form', compact('event')); }

    public function update(Request $request, Event $event)
    {
        $v = $request->validate([
            'judul'        => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'  => 'nullable|date_format:H:i',
            'lokasi'       => 'nullable|string|max:255',
            'kuota'        => 'nullable|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'konten'       => 'nullable|string',
            'thumbnail'    => 'nullable|image|max:2048',
        ]);
        $v['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail) Storage::disk('public')->delete($event->thumbnail);
            $v['thumbnail'] = $this->optimizeImage($request->file('thumbnail'), 'event');
        }
        $event->update($v);
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->thumbnail) Storage::disk('public')->delete($event->thumbnail);
        $event->delete();
        return back()->with('success', 'Event dihapus.');
    }
    public function show(Event $event) { return view('admin.event.show', compact('event')); }
}
