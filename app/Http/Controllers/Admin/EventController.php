<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index() { return view('admin.event.index', ['events' => Event::orderByDesc('tanggal_mulai')->paginate(15)]); }
    public function create() { return view('admin.event.form'); }

    public function store(Request $request)
    {
        $v = $request->validate(['judul' => 'required|string|max:255', 'tanggal_mulai' => 'required|date', 'deskripsi' => 'nullable|string', 'thumbnail' => 'nullable|image|max:2048']);
        $v['slug'] = Str::slug($request->judul);
        $v['is_active'] = $request->boolean('is_active', true);
        $v['is_featured'] = $request->boolean('is_featured');
        if ($request->hasFile('thumbnail')) $v['thumbnail'] = $request->file('thumbnail')->store('event', 'public');
        Event::create(array_merge($v, $request->only('tanggal_selesai','waktu_mulai','lokasi','kuota','konten')));
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event) { return view('admin.event.form', compact('event')); }

    public function update(Request $request, Event $event)
    {
        $v = $request->validate(['judul' => 'required|string|max:255', 'tanggal_mulai' => 'required|date', 'thumbnail' => 'nullable|image|max:2048']);
        $v['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail) Storage::disk('public')->delete($event->thumbnail);
            $v['thumbnail'] = $request->file('thumbnail')->store('event', 'public');
        }
        $event->update(array_merge($v, $request->only('tanggal_selesai','waktu_mulai','lokasi','kuota','konten','deskripsi')));
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event) { $event->delete(); return back()->with('success', 'Event dihapus.'); }
    public function show(Event $event) { return view('admin.event.show', compact('event')); }
}
