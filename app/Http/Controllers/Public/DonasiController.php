<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DonasiProgram;
use App\Models\Donasi;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function index()
    {
        $programs = DonasiProgram::active()
            ->withCount('donasis')
            ->orderByDesc('is_featured')
            ->get();

        $totalTerkumpul = Donasi::confirmed()->sum('jumlah');

        return view('public.donasi.index', compact('programs', 'totalTerkumpul'));
    }

    public function show(DonasiProgram $program)
    {
        $recentDonasi = $program->donasis()
            ->confirmed()
            ->orderByDesc('confirmed_at')
            ->limit(10)
            ->get();

        return view('public.donasi.show', compact('program', 'recentDonasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'nullable|exists:donasi_programs,id',
            'nama'       => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'telepon'    => 'nullable|string|max:20',
            'jumlah'     => 'required|numeric|min:10000',
            'metode'     => 'required|in:transfer,qris,tunai,lainnya',
            'pesan'      => 'nullable|string|max:500',
        ]);

        $kodeUnik = rand(100, 999);

        $donasi = Donasi::create([
            'program_id' => $request->program_id,
            'nama'       => $request->nama ?? 'Hamba Allah',
            'email'      => $request->email,
            'telepon'    => $request->telepon,
            'jumlah'     => $request->jumlah,
            'metode'     => $request->metode,
            'pesan'      => $request->pesan,
            'kode_unik'  => $kodeUnik,
            'status'     => 'pending',
        ]);

        return redirect()->route('donasi.konfirmasi', $donasi->id)
            ->with('success', 'Terima kasih atas niat baik Anda. Silakan selesaikan proses donasi.');
    }

    public function konfirmasi(Donasi $donasi)
    {
        return view('public.donasi.konfirmasi', compact('donasi'));
    }
}
