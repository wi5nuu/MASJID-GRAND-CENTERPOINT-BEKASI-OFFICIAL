<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\DonasiProgram;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Donasi::with('program')->orderByDesc('created_at');
        if ($request->filled('status')) $query->where('status', $request->status);
        $donasis = $query->paginate(20)->withQueryString();
        $programs = DonasiProgram::all();
        $totalBulanIni = Donasi::confirmed()->whereMonth('confirmed_at', now()->month)->sum('jumlah');
        return view('admin.donasi.index', compact('donasis', 'programs', 'totalBulanIni'));
    }

    public function create()
    {
        $programs = DonasiProgram::active()->get();
        return view('admin.donasi.form', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'nullable|string|max:255',
            'jumlah' => 'required|numeric|min:1000',
            'metode' => 'required|in:transfer,qris,tunai,lainnya',
            'status' => 'required|in:pending,confirmed,rejected',
        ]);
        Donasi::create($request->only('program_id','nama','email','telepon','jumlah','metode','status','pesan'));
        return redirect()->route('admin.donasi.index')->with('success', 'Donasi berhasil ditambahkan.');
    }

    public function show(Donasi $donasi) { return view('admin.donasi.show', compact('donasi')); }

    public function edit(Donasi $donasi)
    {
        $programs = DonasiProgram::all();
        return view('admin.donasi.form', compact('donasi', 'programs'));
    }

    public function update(Request $request, Donasi $donasi)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,rejected']);
        $donasi->update($request->only('status','nama','jumlah','metode','pesan'));
        return redirect()->route('admin.donasi.index')->with('success', 'Donasi berhasil diperbarui.');
    }

    public function destroy(Donasi $donasi) { $donasi->delete(); return back()->with('success', 'Donasi dihapus.'); }

    public function konfirmasi(Donasi $donasi)
    {
        $donasi->update(['status' => 'confirmed', 'confirmed_at' => now()]);
        if ($donasi->program_id) {
            $donasi->program->increment('terkumpul', $donasi->jumlah);
        }
        return back()->with('success', 'Donasi berhasil dikonfirmasi. Jazakallahu khairan.');
    }
}
