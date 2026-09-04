<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\JadwalShalat;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $prayerTimes = JadwalShalat::today()?->toArray()
            ?? [
                ['name' => 'Subuh',   'time' => '04:45'],
                ['name' => 'Dzuhur',  'time' => '12:00'],
                ['name' => 'Ashar',   'time' => '15:15'],
                ['name' => 'Maghrib', 'time' => '18:02'],
                ['name' => 'Isya',    'time' => '19:15'],
            ];

        $latestBerita = Berita::published()
            ->with('kategori')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $upcomingKegiatanList = Kegiatan::active()
            ->upcoming()
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->limit(6)
            ->get();

        $latestGaleri = Galeri::active()
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('public.home', compact(
            'prayerTimes',
            'latestBerita',
            'upcomingKegiatanList',
            'latestGaleri'
        ));
    }
}
