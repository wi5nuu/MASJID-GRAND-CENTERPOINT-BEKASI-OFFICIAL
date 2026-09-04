<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Donasi;
use App\Models\User;
use App\Models\JadwalShalat;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita'  => Berita::count(),
            'kegiatan'=> Kegiatan::active()->count(),
            'donasi'  => Donasi::confirmed()->whereMonth('confirmed_at', now()->month)->sum('jumlah'),
            'users'   => User::count(),
        ];

        $prayerTimes = JadwalShalat::today()?->toArray()
            ?? [
                ['name' => 'Subuh',   'time' => '04:45'],
                ['name' => 'Dzuhur',  'time' => '12:00'],
                ['name' => 'Ashar',   'time' => '15:15'],
                ['name' => 'Maghrib', 'time' => '18:02'],
                ['name' => 'Isya',    'time' => '19:15'],
            ];

        $recentBerita = Berita::with('kategori')->orderByDesc('created_at')->limit(5)->get();
        $recentDonasi = Donasi::orderByDesc('created_at')->limit(5)->get();
        $todayKegiatanList = Kegiatan::active()->today()->orderBy('waktu_mulai')->get();

        return view('admin.dashboard.index', compact(
            'stats', 'prayerTimes', 'recentBerita', 'recentDonasi', 'todayKegiatanList'
        ));
    }
}
