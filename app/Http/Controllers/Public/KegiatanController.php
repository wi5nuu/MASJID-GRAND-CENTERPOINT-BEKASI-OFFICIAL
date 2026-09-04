<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::active()->with('kategori')->orderBy('tanggal')->orderBy('waktu_mulai');
        if ($request->filled('kategori')) $query->whereHas('kategori', fn($q) => $q->where('slug', $request->kategori));
        $kegiatans = $query->paginate(12)->withQueryString();
        $kategoris = Kategori::ofType('kegiatan')->get();
        return view('public.kegiatan.index', compact('kegiatans', 'kategoris'));
    }

    public function show(Kegiatan $kegiatan)
    {
        return view('public.kegiatan.show', compact('kegiatan'));
    }

    public function eventIndex()
    {
        $events = \App\Models\Event::active()->upcoming()->orderBy('tanggal_mulai')->paginate(9);
        return view('public.kegiatan.event-index', compact('events'));
    }

    public function eventShow(\App\Models\Event $event)
    {
        return view('public.kegiatan.event-show', compact('event'));
    }
}
