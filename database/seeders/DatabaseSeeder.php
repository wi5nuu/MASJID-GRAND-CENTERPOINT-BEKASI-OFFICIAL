<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use App\Models\Kategori;
use App\Models\JadwalShalat;
use App\Models\DonasiProgram;
use App\Models\Pengurus;
use App\Models\TvDisplay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Roles ──────────────────────────────────────────────────────────────
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'superadmin', 'label' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'admin',      'label' => 'Admin',       'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'editor',     'label' => 'Editor',      'created_at' => now(), 'updated_at' => now()],
        ]);

        // ─── Default Admin User ──────────────────────────────────────────────────
        User::create([
            'name'      => 'Super Admin',
            'email'     => 'admin@masjidgcp.com',
            'password'  => Hash::make('password'),
            'role_id'   => 1,
            'is_active' => true,
        ]);

        // ─── Settings ────────────────────────────────────────────────────────────
        $settings = [
            ['key' => 'site_name',        'value' => 'Masjid Grand Centerpoint Bekasi', 'group' => 'general'],
            ['key' => 'site_tagline',      'value' => 'Pusat Ibadah, Ilmu, dan Ukhuwah', 'group' => 'general'],
            ['key' => 'site_email',        'value' => 'info@masjidgcp.com', 'group' => 'contact'],
            ['key' => 'site_phone',        'value' => '(021) 1234-5678', 'group' => 'contact'],
            ['key' => 'site_address',      'value' => 'Grand Centerpoint, Jl. Ahmad Yani, Bekasi, Jawa Barat', 'group' => 'contact'],
            ['key' => 'whatsapp_number',   'value' => '6281234567890', 'group' => 'contact'],
            ['key' => 'facebook_url',      'value' => '', 'group' => 'social'],
            ['key' => 'instagram_url',     'value' => '', 'group' => 'social'],
            ['key' => 'youtube_url',       'value' => '', 'group' => 'social'],
            ['key' => 'donasi_rekening',   'value' => 'Bank Syariah Indonesia\nNo. Rek: 1234567890\na.n. Masjid Grand Centerpoint', 'group' => 'donasi'],
            ['key' => 'donasi_qris',       'value' => '', 'group' => 'donasi'],
            ['key' => 'running_text',      'value' => 'Selamat datang di Masjid Grand Centerpoint Bekasi. Marilah kita makmurkan masjid bersama-sama.', 'group' => 'tv'],
        ];
        foreach ($settings as $s) {
            Setting::create(array_merge($s, ['created_at' => now(), 'updated_at' => now()]));
        }

        // ─── Kategoris ───────────────────────────────────────────────────────────
        $kategoris = [
            // Berita
            ['nama' => 'Khutbah', 'slug' => 'khutbah', 'tipe' => 'berita', 'warna' => '#16a34a'],
            ['nama' => 'Kajian', 'slug' => 'kajian-berita', 'tipe' => 'berita', 'warna' => '#16a34a'],
            ['nama' => 'Laporan Kegiatan', 'slug' => 'laporan-kegiatan', 'tipe' => 'berita', 'warna' => '#16a34a'],
            ['nama' => 'Pengumuman', 'slug' => 'pengumuman', 'tipe' => 'berita', 'warna' => '#d97706'],
            ['nama' => 'Umum', 'slug' => 'umum', 'tipe' => 'berita', 'warna' => '#16a34a'],
            // Kegiatan
            ['nama' => 'Kajian Rutin', 'slug' => 'kajian-rutin', 'tipe' => 'kegiatan', 'warna' => '#16a34a'],
            ['nama' => 'Ibadah', 'slug' => 'ibadah', 'tipe' => 'kegiatan', 'warna' => '#16a34a'],
            ['nama' => 'Pendidikan', 'slug' => 'pendidikan', 'tipe' => 'kegiatan', 'warna' => '#0284c7'],
            ['nama' => 'Sosial', 'slug' => 'sosial', 'tipe' => 'kegiatan', 'warna' => '#7c3aed'],
            // Galeri
            ['nama' => 'Kegiatan Masjid', 'slug' => 'kegiatan-masjid', 'tipe' => 'galeri', 'warna' => '#16a34a'],
            ['nama' => 'Ramadan', 'slug' => 'ramadan', 'tipe' => 'galeri', 'warna' => '#16a34a'],
            // Video
            ['nama' => 'Kajian Video', 'slug' => 'kajian-video', 'tipe' => 'video', 'warna' => '#16a34a'],
            ['nama' => 'Khutbah Video', 'slug' => 'khutbah-video', 'tipe' => 'video', 'warna' => '#16a34a'],
            // Donasi
            ['nama' => 'Operasional', 'slug' => 'operasional', 'tipe' => 'donasi', 'warna' => '#16a34a'],
            ['nama' => 'Pembangunan', 'slug' => 'pembangunan', 'tipe' => 'donasi', 'warna' => '#16a34a'],
            ['nama' => 'Sosial', 'slug' => 'donasi-sosial', 'tipe' => 'donasi', 'warna' => '#7c3aed'],
        ];
        foreach ($kategoris as $k) {
            Kategori::create(array_merge($k, ['created_at' => now(), 'updated_at' => now()]));
        }

        // ─── Jadwal Shalat (30 hari ke depan) ────────────────────────────────────
        $shalatBase = [
            ['subuh' => '04:45', 'dzuhur' => '12:00', 'ashar' => '15:15', 'maghrib' => '18:02', 'isya' => '19:15'],
        ];
        for ($i = 0; $i < 30; $i++) {
            JadwalShalat::create([
                'tanggal'  => Carbon::today()->addDays($i)->toDateString(),
                'subuh'    => '04:' . str_pad(44 + ($i % 3), 2, '0', STR_PAD_LEFT),
                'dzuhur'   => '12:00',
                'ashar'    => '15:1' . ($i % 5),
                'maghrib'  => '18:0' . ($i % 5),
                'isya'     => '19:1' . ($i % 3),
                'jumat'    => '12:00',
                'hijri_date' => '',
            ]);
        }

        // ─── Program Donasi ───────────────────────────────────────────────────────
        DonasiProgram::insert([
            [
                'nama'          => 'Operasional Masjid',
                'slug'          => 'operasional-masjid',
                'deskripsi'     => 'Mendukung operasional harian masjid termasuk listrik, air, kebersihan, dan perawatan fasilitas.',
                'target'        => 50000000,
                'terkumpul'     => 23450000,
                'is_active'     => true,
                'is_featured'   => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama'          => 'Renovasi Tempat Wudhu',
                'slug'          => 'renovasi-tempat-wudhu',
                'deskripsi'     => 'Program renovasi dan perluasan tempat wudhu untuk kenyamanan jamaah.',
                'target'        => 150000000,
                'terkumpul'     => 87500000,
                'is_active'     => true,
                'is_featured'   => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama'          => 'Beasiswa Tahfidz',
                'slug'          => 'beasiswa-tahfidz',
                'deskripsi'     => 'Program beasiswa untuk santri tahfidz Al-Quran yang berprestasi namun kurang mampu.',
                'target'        => 30000000,
                'terkumpul'     => 12750000,
                'is_active'     => true,
                'is_featured'   => false,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        // ─── Pengurus ─────────────────────────────────────────────────────────────
        $pengurusList = [
            ['nama' => 'H. Ahmad Fauzi, M.Ag.', 'jabatan' => 'Ketua Umum', 'urutan' => 1],
            ['nama' => 'Ir. Muhammad Rizki', 'jabatan' => 'Wakil Ketua', 'urutan' => 2],
            ['nama' => 'Drs. Abdullah Hakim', 'jabatan' => 'Sekretaris Umum', 'urutan' => 3],
            ['nama' => 'H. Ismail Saleh, S.E.', 'jabatan' => 'Bendahara', 'urutan' => 4],
            ['nama' => 'Ustadz Ahmad Yusuf, Lc.', 'jabatan' => 'Ketua Bid. Ibadah & Dakwah', 'urutan' => 5],
            ['nama' => 'Dr. Fatimah Zahra', 'jabatan' => 'Ketua Bid. Pendidikan', 'urutan' => 6],
        ];
        foreach ($pengurusList as $p) {
            Pengurus::create(array_merge($p, [
                'is_active'  => true,
                'periode'    => '2023-2026',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // ─── TV Display ───────────────────────────────────────────────────────────
        TvDisplay::insert([
            ['tipe' => 'running_text', 'judul' => 'Selamat Datang', 'konten' => 'Selamat datang di Masjid Grand Centerpoint Bekasi. Marilah kita makmurkan masjid bersama-sama.', 'durasi' => 15, 'urutan' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['tipe' => 'pengumuman', 'judul' => 'Kajian Rutin', 'konten' => 'Kajian Tafsir Al-Quran setiap Ahad pagi pukul 08.00 WIB bersama Ustadz Ahmad Yusuf, Lc.', 'durasi' => 10, 'urutan' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['tipe' => 'pengumuman', 'judul' => 'Donasi', 'konten' => 'Donasi operasional masjid dapat diserahkan ke sekretariat atau melalui transfer ke rekening masjid.', 'durasi' => 10, 'urutan' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
