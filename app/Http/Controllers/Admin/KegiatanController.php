<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::with('kategori')->orderByDesc('tanggal');
        if ($request->filled('cari')) $query->where('judul', 'like', '%'.$request->cari.'%');
        $kegiatans = $query->paginate(15)->withQueryString();
        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        $kategoris = Kategori::ofType('kegiatan')->get();
        return view('admin.kegiatan.form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'deskripsi'   => 'nullable|string',
            'tanggal'     => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai'=>'nullable',
            'lokasi'      => 'nullable|string|max:255',
            'narasumber'  => 'nullable|string|max:255',
            'jenis'       => 'required|in:rutin,khusus',
            'hari_rutin'  => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,ahad',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);
        $v['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('thumbnail')) {
            $v['thumbnail'] = $request->file('thumbnail')->store('kegiatan', 'public');
        }
        Kegiatan::create($v);
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan)
    {
        $kategoris = Kategori::ofType('kegiatan')->get();
        return view('admin.kegiatan.form', compact('kegiatan', 'kategoris'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $v = $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'deskripsi'   => 'nullable|string',
            'tanggal'     => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai'=>'nullable',
            'lokasi'      => 'nullable|string|max:255',
            'narasumber'  => 'nullable|string|max:255',
            'jenis'       => 'required|in:rutin,khusus',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);
        $v['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('thumbnail')) {
            if ($kegiatan->thumbnail) Storage::disk('public')->delete($kegiatan->thumbnail);
            $v['thumbnail'] = $request->file('thumbnail')->store('kegiatan', 'public');
        }
        $kegiatan->update($v);
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    // Public Event methods
    public function eventIndex() { return view('public.kegiatan.event-index', ['events' => Event::active()->upcoming()->orderBy('tanggal_mulai')->paginate(9)]); }
    public function eventShow(Event $event) { return view('public.kegiatan.event-show', compact('event')); }
    public function show(Kegiatan $kegiatan) { return view('public.kegiatan.show', compact('kegiatan')); }
}
