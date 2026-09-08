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
            'program_id' => 'nullable|exists:donasi_programs,id',
            'nama'       => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'telepon'    => 'nullable|string|max:20',
            'jumlah'     => 'required|numeric|min:1000',
            'metode'     => 'required|in:transfer,qris,tunai,lainnya',
            'status'     => 'required|in:pending,confirmed,rejected',
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
        $request->validate([
            'status'   => 'required|in:pending,confirmed,rejected',
            'nama'     => 'nullable|string|max:255',
            'jumlah'   => 'required|numeric|min:1000',
            'metode'   => 'required|in:transfer,qris,tunai,lainnya',
            'program_id' => 'nullable|exists:donasi_programs,id',
        ]);

        $wasConfirmed = $donasi->status === 'confirmed';
        $nowConfirmed = $request->status === 'confirmed';

        // Only allow status/pesan changes when already confirmed (prevent amount tampering)
        if ($wasConfirmed) {
            $data = $request->only('status', 'pesan');
        } else {
            $data = $request->only('status', 'nama', 'jumlah', 'metode', 'program_id', 'pesan');
        }

        // Set confirmed_at saat pertama kali status di-set ke confirmed
        if ($nowConfirmed && !$donasi->confirmed_at) {
            $data['confirmed_at'] = now();
        }

        // Jika status berubah dari confirmed ke lain, hapus confirmed_at
        if ($wasConfirmed && !$nowConfirmed) {
            $data['confirmed_at'] = null;
            // Rollback increment terkumpul jika ada program
            if ($donasi->program_id && $donasi->program) {
                $donasi->program->decrement('terkumpul', $donasi->jumlah);
            }
        }

        // Jika baru confirmed (belum pernah) dan ada program, increment
        if ($nowConfirmed && !$wasConfirmed && $donasi->program_id && $donasi->program) {
            $donasi->program->increment('terkumpul', $donasi->jumlah);
        }

        $donasi->update($data);
        return redirect()->route('admin.donasi.index')->with('success', 'Donasi berhasil diperbarui.');
    }

    public function destroy(Donasi $donasi) { $donasi->delete(); return back()->with('success', 'Donasi dihapus.'); }

    public function konfirmasi(Donasi $donasi)
    {
        // Guard: jangan double-increment jika sudah confirmed sebelumnya
        if ($donasi->status === 'confirmed') {
            return back()->with('info', 'Donasi ini sudah dikonfirmasi sebelumnya.');
        }

        $donasi->update(['status' => 'confirmed', 'confirmed_at' => now()]);

        if ($donasi->program_id && $donasi->program) {
            $donasi->program->increment('terkumpul', $donasi->jumlah);
        }

        return back()->with('success', 'Donasi berhasil dikonfirmasi. Jazakallahu khairan.');
    }
}
