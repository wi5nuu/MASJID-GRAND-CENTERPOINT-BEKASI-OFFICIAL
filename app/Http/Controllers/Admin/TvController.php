<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvDisplay;
use App\Models\JadwalShalat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TvController extends Controller
{
    public function index() { return view('admin.tv.index', ['displays' => TvDisplay::orderBy('urutan')->paginate(20)]); }
    public function create() { return view('admin.tv.form'); }

    public function store(Request $request)
    {
        $request->validate(['tipe' => 'required|string', 'konten' => 'required|string']);
        $data = $request->only('tipe','judul','konten','durasi','urutan');
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('file')) $data['file'] = $request->file('file')->store('tv', 'public');
        TvDisplay::create($data);
        return redirect()->route('admin.tv.index')->with('success', 'Konten TV berhasil ditambahkan.');
    }

    public function edit(TvDisplay $tv) { return view('admin.tv.form', compact('tv')); }

    public function update(Request $request, TvDisplay $tv)
    {
        $data = $request->only('tipe','judul','konten','durasi','urutan');
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('file')) {
            if ($tv->file) Storage::disk('public')->delete($tv->file);
            $data['file'] = $request->file('file')->store('tv', 'public');
        }
        $tv->update($data);
        return redirect()->route('admin.tv.index')->with('success', 'Konten TV berhasil diperbarui.');
    }

    public function destroy(TvDisplay $tv) { $tv->delete(); return back()->with('success', 'Konten TV dihapus.'); }
    public function show(TvDisplay $tv) { return view('admin.tv.show', compact('tv')); }

    public function display()
    {
        $shalat   = JadwalShalat::whereDate('tanggal', today())->first();

        // Jika tidak ada data hari ini, auto-fetch dari API
        if (!$shalat) {
            \App\Http\Controllers\Admin\ShalatController::fetchToday();
            $shalat = JadwalShalat::whereDate('tanggal', today())->first();
        }

        $displays = TvDisplay::where('is_active', true)->orderBy('urutan')->get();

        return view('tv.display', compact('shalat', 'displays'));
    }
}
