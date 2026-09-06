<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Support\Str;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori kegiatan ada
        $kategori = Kategori::firstOrCreate(
            ['slug' => 'program-rutin'],
            [
                'nama'  => 'Program Rutin',
                'tipe'  => 'kegiatan',
                'warna' => '#2563eb',
            ]
        );

        $kegiatan = [
            [
                'judul'        => 'Kajian Malam Jumat',
                'deskripsi'    => 'Kajian rutin setiap Kamis malam untuk seluruh jamaah. Membahas tafsir Al-Quran, hadits, dan fiqih kehidupan sehari-hari bersama ustadz pilihan.',
                'tanggal'      => Carbon::now()->next('thursday')->toDateString(),
                'waktu_mulai'  => '19:30:00',
                'waktu_selesai'=> '21:00:00',
                'lokasi'       => 'Masjid Grand Centerpoint',
                'narasumber'   => 'Ustadz DKM Masjid GCP',
                'jenis'        => 'rutin',
                'hari_rutin'   => 'kamis',
                'is_active'    => true,
                'thumbnail'    => 'images/mosque/kajianmalamjumat.png',
                'kategori_id'  => $kategori->id,
            ],
            [
                'judul'        => 'Tahsin & TPA',
                'deskripsi'    => 'Belajar membaca Al-Quran dengan tajwid yang benar untuk anak-anak dan dewasa. Program ini terbuka untuk semua kalangan jamaah.',
                'tanggal'      => Carbon::now()->next('saturday')->toDateString(),
                'waktu_mulai'  => '16:00:00',
                'waktu_selesai'=> '17:30:00',
                'lokasi'       => 'Masjid Grand Centerpoint',
                'narasumber'   => 'Pengajar Tahsin DKM',
                'jenis'        => 'rutin',
                'hari_rutin'   => 'sabtu',
                'is_active'    => true,
                'thumbnail'    => 'images/mosque/tahsindantpa.png',
                'kategori_id'  => $kategori->id,
            ],
            [
                'judul'        => 'Yasinan & Makan Bersama',
                'deskripsi'    => 'Kegiatan yasinan rutin yang diikuti seluruh warga, dilanjutkan dengan makan bersama sebagai bentuk mempererat ukhuwah jamaah.',
                'tanggal'      => Carbon::now()->next('friday')->toDateString(),
                'waktu_mulai'  => '18:00:00',
                'waktu_selesai'=> '19:00:00',
                'lokasi'       => 'Masjid Grand Centerpoint',
                'narasumber'   => null,
                'jenis'        => 'rutin',
                'hari_rutin'   => 'jumat',
                'is_active'    => true,
                'thumbnail'    => 'images/mosque/yasinan.png',
                'kategori_id'  => $kategori->id,
            ],
            [
                'judul'        => 'Santunan Anak Yatim',
                'deskripsi'    => 'Program sosial tahunan yang menyentuh 150–200 penerima manfaat dari warga sekitar kawasan Grand Centerpoint dan 3 kelurahan di Bekasi Selatan.',
                'tanggal'      => Carbon::now()->next('sunday')->toDateString(),
                'waktu_mulai'  => '09:00:00',
                'waktu_selesai'=> '12:00:00',
                'lokasi'       => 'Masjid Grand Centerpoint',
                'narasumber'   => null,
                'jenis'        => 'khusus',
                'hari_rutin'   => null,
                'is_active'    => true,
                'thumbnail'    => 'images/mosque/santunananakyatim.png',
                'kategori_id'  => $kategori->id,
            ],
            [
                'judul'        => 'Kajian Ramadhan',
                'deskripsi'    => 'Kajian intensif selama bulan Ramadhan yang membahas tema-tema keislaman, tadarus Al-Quran, dan siraman rohani bersama jamaah Masjid Grand Centerpoint.',
                'tanggal'      => Carbon::now()->next('monday')->toDateString(),
                'waktu_mulai'  => '08:00:00',
                'waktu_selesai'=> '09:30:00',
                'lokasi'       => 'Masjid Grand Centerpoint',
                'narasumber'   => 'Ustadz DKM Masjid GCP',
                'jenis'        => 'khusus',
                'hari_rutin'   => null,
                'is_active'    => true,
                'thumbnail'    => 'images/mosque/kajianramadhan.png',
                'kategori_id'  => $kategori->id,
            ],
            [
                'judul'        => 'Bakti Sosial',
                'deskripsi'    => 'Kegiatan bakti sosial DKM Grand Centerpoint — berbagi kepada warga sekitar melalui pembagian sembako, santunan, dan layanan kesehatan gratis.',
                'tanggal'      => Carbon::now()->next('sunday')->toDateString(),
                'waktu_mulai'  => '08:00:00',
                'waktu_selesai'=> '12:00:00',
                'lokasi'       => 'Masjid Grand Centerpoint',
                'narasumber'   => null,
                'jenis'        => 'khusus',
                'hari_rutin'   => null,
                'is_active'    => true,
                'thumbnail'    => 'images/mosque/baktisosial.png',
                'kategori_id'  => $kategori->id,
            ],
            [
                'judul'        => 'Kajian Ibu-Ibu',
                'deskripsi'    => 'Kajian rutin khusus ibu-ibu jamaah Masjid Grand Centerpoint — membahas fiqih wanita, parenting Islami, dan pembacaan Al-Quran bersama.',
                'tanggal'      => Carbon::now()->next('wednesday')->toDateString(),
                'waktu_mulai'  => '09:00:00',
                'waktu_selesai'=> '11:00:00',
                'lokasi'       => 'Masjid Grand Centerpoint',
                'narasumber'   => 'Ustadzah DKM Masjid GCP',
                'jenis'        => 'rutin',
                'hari_rutin'   => 'rabu',
                'is_active'    => true,
                'thumbnail'    => 'images/mosque/kajian_ibuibu.png',
                'kategori_id'  => $kategori->id,
            ],
        ];

        foreach ($kegiatan as $data) {
            Kegiatan::firstOrCreate(
                ['judul' => $data['judul']],
                $data
            );
        }

        // Update slug untuk data yang sudah ada tapi belum punya slug
        Kegiatan::whereNull('slug')->orWhere('slug', '')->get()->each(function ($k) {
            $k->update(['slug' => Str::slug($k->judul)]);
        });
    }
}
