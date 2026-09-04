<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('public.kontak');
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'telepon'=> 'nullable|string|max:20',
            'subjek' => 'nullable|string|max:255',
            'pesan'  => 'required|string|min:10|max:2000',
        ]);

        Kontak::create($request->only('nama', 'email', 'telepon', 'subjek', 'pesan'));

        return back()->with('success', 'Pesan Anda berhasil dikirim. Kami akan menghubungi Anda segera. Jazakallahu khairan.');
    }
}
