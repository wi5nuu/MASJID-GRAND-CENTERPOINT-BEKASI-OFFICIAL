<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        $fotos = [
            [
                'judul'      => 'Jamaah di Dalam Masjid',
                'file'       => 'galeri/jamaat_dalam_masjid.png',
                'keterangan' => 'Suasana jamaah di dalam Masjid Grand Centerpoint Bekasi.',
                'album'      => 'Dokumentasi Masjid',
                'urutan'     => 1,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Jamaah di Luar Masjid',
                'file'       => 'galeri/jamaat_diluar_masjid.png',
                'keterangan' => 'Suasana jamaah di luar Masjid Grand Centerpoint Bekasi.',
                'album'      => 'Dokumentasi Masjid',
                'urutan'     => 2,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Area Kanan dan Kiri Masjid',
                'file'       => 'galeri/daerahkanandankirimasjid.png',
                'keterangan' => 'Area kanan dan kiri Masjid Grand Centerpoint Bekasi.',
                'album'      => 'Dokumentasi Masjid',
                'urutan'     => 3,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Tempat Wudhu Pria',
                'file'       => 'galeri/tempatwudhupria.png',
                'keterangan' => 'Fasilitas tempat wudhu pria di Masjid Grand Centerpoint Bekasi.',
                'album'      => 'Dokumentasi Masjid',
                'urutan'     => 4,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Syukuran Pasca Banjir 2025',
                'file'       => 'galeri/syukuranpascabanjir2025.png',
                'keterangan' => 'Kegiatan syukuran pasca banjir 2025 di Masjid Grand Centerpoint Bekasi.',
                'album'      => 'Kegiatan 2025',
                'urutan'     => 5,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Tim Kurban 2025',
                'file'       => 'galeri/timkurban2025.png',
                'keterangan' => 'Tim pelaksana kurban Idul Adha 2025 Masjid Grand Centerpoint Bekasi.',
                'album'      => 'Kegiatan 2025',
                'urutan'     => 6,
                'is_active'  => true,
            ],
        ];

        foreach ($fotos as $foto) {
            Galeri::create($foto);
        }
    }
}
