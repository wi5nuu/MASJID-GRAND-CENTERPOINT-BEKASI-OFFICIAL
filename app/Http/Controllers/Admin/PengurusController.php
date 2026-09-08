<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Traits\OptimizesImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    use OptimizesImages;

    public function index() { return view('admin.pengurus.index', ['pengurusList' => Pengurus::orderBy('urutan')->paginate(20)]); }

    public function create() { return view('admin.pengurus.form'); }

    public function store(Request $request)
    {
        $v = $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto'    => 'nullable|image|max:2048',
            'bio'     => 'nullable|string',
            'urutan'  => 'nullable|integer',
        ]);
        if ($request->hasFile('foto')) $v['foto'] = $this->optimizeImage($request->file('foto'), 'pengurus');
        $v['is_active'] = $request->boolean('is_active', true);
        Pengurus::create($v);
        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function edit(Pengurus $pengurus) { return view('admin.pengurus.form', compact('pengurus')); }

    public function update(Request $request, Pengurus $pengurus)
    {
        $v = $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto'    => 'nullable|image|max:2048',
            'bio'     => 'nullable|string',
            'periode' => 'nullable|string|max:100',
            'email'   => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'urutan'  => 'nullable|integer|min:0',
        ]);
        if ($request->hasFile('foto')) {
            if ($pengurus->foto) Storage::disk('public')->delete($pengurus->foto);
            $v['foto'] = $this->optimizeImage($request->file('foto'), 'pengurus');
        }
        $v['is_active'] = $request->boolean('is_active', true);
        $pengurus->update($v);
        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil diperbarui.');
    }

    public function destroy(Pengurus $pengurus) { $pengurus->delete(); return back()->with('success', 'Pengurus dihapus.'); }
    public function show(Pengurus $pengurus) { return view('admin.pengurus.show', compact('pengurus')); }
}
