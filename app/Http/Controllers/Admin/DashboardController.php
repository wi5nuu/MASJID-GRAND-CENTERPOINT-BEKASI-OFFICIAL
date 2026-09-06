<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Donasi;
use App\Models\JadwalShalat;
use App\Models\Kegiatan;
use App\Models\Kontak;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();

        $jamaahQuery = User::whereHas('role', fn ($q) => $q->where('name', 'jamaah'));

        $stats = [
            'berita'           => Berita::count(),
            'beritaBulanIni'   => Berita::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)->count(),
            'kegiatan'         => Kegiatan::active()->count(),
            'kegiatanBulanIni' => Kegiatan::active()
                ->whereYear('tanggal', $now->year)->whereMonth('tanggal', $now->month)->count(),
            'donasi'           => (float) Donasi::confirmed()
                ->whereYear('confirmed_at', $now->year)->whereMonth('confirmed_at', $now->month)->sum('jumlah'),
            'donasiTransaksi'  => Donasi::confirmed()
                ->whereYear('confirmed_at', $now->year)->whereMonth('confirmed_at', $now->month)->count(),
            'users'            => (clone $jamaahQuery)->count(),
            'usersPending'     => (clone $jamaahQuery)->whereNull('approved_at')->count(),
        ];

        // Hal yang perlu perhatian admin
        $attention = [
            'pendingUsers'  => (clone $jamaahQuery)->whereNull('approved_at')->count(),
            'pendingDonasi' => Donasi::pending()->count(),
            'unreadKontak'  => Kontak::unread()->count(),
        ];
        $attention['total'] = $attention['pendingUsers'] + $attention['pendingDonasi'] + $attention['unreadKontak'];

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

        $recentBerita      = Berita::with('kategori')->orderByDesc('created_at')->limit(5)->get();
        $recentDonasi      = Donasi::with('program')->orderByDesc('created_at')->limit(5)->get();
        $todayKegiatanList = Kegiatan::active()->today()->orderBy('waktu_mulai')->get();

        // Status database dicek betulan, bukan statis
        try {
            DB::connection()->getPdo();
            $dbOnline = true;
        } catch (\Throwable $e) {
            $dbOnline = false;
        }

        return view('admin.dashboard.index', compact(
            'stats', 'attention', 'prayerTimes', 'recentBerita', 'recentDonasi', 'todayKegiatanList', 'dbOnline'
        ));
    }
}
