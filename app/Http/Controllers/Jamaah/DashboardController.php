<?php

namespace App\Http\Controllers\Jamaah;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\DonasiProgram;
use App\Models\JadwalShalat;
use App\Models\Kegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Jadwal shalat hari ini — fallback ke array default jika belum ada
        $defaultTimes = [
            ['name' => 'Subuh',   'time' => '04:45'],
            ['name' => 'Syuruq',  'time' => '06:00'],
            ['name' => 'Dzuhur',  'time' => '12:00'],
            ['name' => 'Ashar',   'time' => '15:15'],
            ['name' => 'Maghrib', 'time' => '18:02'],
            ['name' => 'Isya',    'time' => '19:15'],
        ];
        $shalatHariIni = JadwalShalat::whereDate('tanggal', today())->first();
        $prayerTimes   = $defaultTimes;
        if ($shalatHariIni) {
            $map = ['subuh' => 'subuh', 'syuruq' => 'syuruq', 'dzuhur' => 'dzuhur', 'ashar' => 'ashar', 'maghrib' => 'maghrib', 'isya' => 'isya'];
            foreach ($prayerTimes as $i => $row) {
                $column = $map[strtolower($row['name'])] ?? null;
                if ($column && !empty($shalatHariIni->{$column})) {
                    $prayerTimes[$i]['time'] = substr((string) $shalatHariIni->{$column}, 0, 5);
                }
            }
        }

        // Kegiatan hari ini & mendatang (esok ke atas agar tidak duplikat)
        $todayKegiatan    = Kegiatan::active()->today()->orderBy('waktu_mulai')->get();
        $upcomingKegiatan = Kegiatan::active()->whereDate('tanggal', '>', today())
            ->orderBy('tanggal')->orderBy('waktu_mulai')->limit(5)->get();

        // Berita terbaru
        $recentBerita = Berita::with('kategori')->orderByDesc('created_at')->limit(5)->get();

        // Program donasi aktif (bukan transaksi donasi)
        $donasiPrograms = DonasiProgram::active()->orderByDesc('is_featured')->orderByDesc('created_at')->limit(3)->get();

        return view('jamaah.dashboard.index', compact(
            'user', 'prayerTimes', 'todayKegiatan', 'upcomingKegiatan', 'recentBerita', 'donasiPrograms'
        ));
    }
}
