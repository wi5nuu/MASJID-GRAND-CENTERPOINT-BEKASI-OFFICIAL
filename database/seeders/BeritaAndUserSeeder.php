<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Berita;
use App\Models\Kategori;
use Carbon\Carbon;

class BeritaAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin User: Wisnu Ashar ──────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'wisnu.ashar@centerpoint.com'],
            [
                'name'      => 'Wisnu Ashar',
                'password'  => Hash::make('wisnu.ashar01'),
                'role_id'   => 2, // admin
                'is_active' => true,
            ]
        );

        $userId = User::where('email', 'wisnu.ashar@centerpoint.com')->value('id');

        // Pastikan kategori "Kegiatan Sosial" ada
        $kategori = Kategori::firstOrCreate(
            ['slug' => 'kegiatan-sosial'],
            [
                'nama'  => 'Kegiatan Sosial',
                'tipe'  => 'berita',
                'warna' => '#16a34a',
            ]
        );

        // Kategori "Liputan Media"
        $kategoriOpini = Kategori::firstOrCreate(
            ['slug' => 'liputan-media'],
            [
                'nama'  => 'Liputan Media',
                'tipe'  => 'berita',
                'warna' => '#d97706',
            ]
        );

        // ─── Berita 1 ─────────────────────────────────────────────────────────────
        // Sumber: inijabar.com — 18 September 2025
        // DKM Grand Center Point Santuni 150 Anak Yatim Piatu dan Janda
        Berita::updateOrCreate(
            ['slug' => 'dkm-grand-center-point-santuni-150-anak-yatim-piatu-dan-janda'],
            [
                'kategori_id'      => $kategori->id,
                'user_id'          => $userId,
                'judul'            => 'DKM Grand Center Point Santuni 150 Anak Yatim Piatu dan Janda',
                'slug'             => 'dkm-grand-center-point-santuni-150-anak-yatim-piatu-dan-janda',
                'ringkasan'        => 'Dewan Kemakmuran Masjid (DKM) Grand Center Point menggelar program santunan untuk 150 anak yatim piatu dan janda warga lingkungan Kayuringin, Kota Bekasi, pada Kamis 18 September 2025.',
                'konten'           => '<p>Dewan Kemakmuran Masjid (DKM) Grand Center Point menggelar program santunan untuk 150 anak yatim piatu dan janda warga lingkungan Kayuringin, Kota Bekasi, Kamis (18/9/2025).</p>

<p>Kegiatan yang berlangsung khidmat ini merupakan wujud kepedulian DKM Grand Center Point terhadap masyarakat sekitar, khususnya mereka yang membutuhkan perhatian dan dukungan. Acara santunan ini dihadiri oleh pengurus DKM, warga setempat, serta tokoh-tokoh masyarakat Kayuringin.</p>

<p>Ketua DKM Grand Center Point menyampaikan bahwa kegiatan sosial semacam ini merupakan bagian dari program rutin masjid untuk mempererat tali silaturahmi sekaligus meringankan beban saudara-saudara yang membutuhkan. "Masjid bukan sekadar tempat ibadah, tapi juga pusat kegiatan sosial kemasyarakatan," ujarnya.</p>

<p>Setiap anak yatim piatu dan janda yang hadir mendapatkan santunan berupa uang tunai serta paket sembako. Kegiatan ini disambut hangat oleh para penerima manfaat yang merasa terbantu dengan adanya program santunan tersebut.</p>

<p>Program santunan ini merupakan salah satu dari sekian banyak kegiatan sosial yang secara konsisten dijalankan oleh DKM Grand Center Point sebagai bentuk kontribusi nyata masjid terhadap kesejahteraan masyarakat lingkungan sekitar.</p>

<p><em>Sumber: inijabar.com, 18 September 2025</em></p>',
                'status'           => 'published',
                'is_featured'      => true,
                'views'            => 0,
                'published_at'     => Carbon::parse('2025-09-18 19:58:00'),
                'meta_title'       => 'DKM Grand Center Point Santuni 150 Anak Yatim Piatu dan Janda',
                'meta_description' => 'DKM Grand Center Point menggelar santunan untuk 150 anak yatim piatu dan janda warga Kayuringin, Kota Bekasi.',
                'meta_keywords'    => 'DKM Grand Center Point, santunan, yatim piatu, Kayuringin, Bekasi',
            ]
        );

        // ─── Berita 2 ─────────────────────────────────────────────────────────────
        // Sumber: fkubkotabekasi.com — 18 September 2025
        // Ketua FKUB dan Wali Kota Bekasi Hadiri Santunan Yatim Piatu
        Berita::updateOrCreate(
            ['slug' => 'ketua-fkub-dan-wali-kota-bekasi-hadiri-santunan-yatim-piatu-di-masjid-grand-center-point'],
            [
                'kategori_id'      => $kategori->id,
                'user_id'          => $userId,
                'judul'            => 'Ketua FKUB dan Wali Kota Bekasi Hadiri Santunan Yatim Piatu di Masjid Grand Center Point',
                'slug'             => 'ketua-fkub-dan-wali-kota-bekasi-hadiri-santunan-yatim-piatu-di-masjid-grand-center-point',
                'ringkasan'        => 'Ketua FKUB Kota Bekasi H. Abdul Manan bersama Wali Kota Bekasi Dr. Tri Adhianto Tjahyono menghadiri acara santunan yatim piatu di Masjid Grand Center Point pada 18 September 2025.',
                'konten'           => '<p>Ketua Forum Kerukunan Umat Beragama (FKUB) Kota Bekasi H. Abdul Manan bersama Wali Kota Bekasi, Dr. Tri Adhianto Tjahyono, menghadiri acara santunan yatim piatu yang digelar di Masjid Grand Center Point. Acara yang berlangsung pada Kamis, 18 September 2025 ini menjadi momentum penuh makna bagi masyarakat sekitar.</p>

<p>Kehadiran para pemimpin daerah tersebut menegaskan komitmen Pemerintah Kota Bekasi dalam mendukung kegiatan sosial keagamaan yang diinisiasi oleh lembaga-lembaga keagamaan di wilayahnya. Wali Kota Bekasi, Dr. Tri Adhianto Tjahyono, dalam sambutannya mengapresiasi peran aktif DKM Grand Center Point dalam memberikan santunan kepada anak yatim piatu.</p>

<p>Ketua FKUB Kota Bekasi H. Abdul Manan juga menyampaikan rasa bangganya atas sinergi antara masjid dan masyarakat dalam mewujudkan kepedulian sosial. Beliau menekankan bahwa kegiatan seperti ini merupakan cerminan nilai-nilai luhur agama yang harus terus dijaga dan dikembangkan.</p>

<p>Acara santunan yang digelar oleh DKM Grand Center Point ini mendapatkan respons positif dari seluruh hadirin. Kehadiran pemimpin daerah turut memberikan semangat dan motivasi bagi pengurus DKM untuk terus berkontribusi bagi masyarakat.</p>

<p>Masjid Grand Center Point sekali lagi membuktikan perannya tidak hanya sebagai tempat ibadah, tetapi juga sebagai pusat kegiatan sosial yang memberikan manfaat nyata bagi masyarakat luas.</p>

<p><em>Sumber: FKUB Kota Bekasi, 18 September 2025</em></p>',
                'status'           => 'published',
                'is_featured'      => true,
                'views'            => 0,
                'published_at'     => Carbon::parse('2025-09-18 20:00:00'),
                'meta_title'       => 'Ketua FKUB dan Wali Kota Bekasi Hadiri Santunan Yatim Piatu di Masjid Grand Center Point',
                'meta_description' => 'Ketua FKUB H. Abdul Manan dan Wali Kota Bekasi Dr. Tri Adhianto Tjahyono menghadiri santunan yatim piatu di Masjid Grand Center Point Bekasi.',
                'meta_keywords'    => 'FKUB Bekasi, Wali Kota Bekasi, santunan yatim piatu, Masjid Grand Center Point',
            ]
        );

        // ─── Berita 3 ─────────────────────────────────────────────────────────────
        // Sumber: suarakarya.id — Maret 2026 (Ramadhan)
        // Ramadhan Penuh Berkah: Masjid Grand Center Point Bekasi Gelar Santunan Anak Yatim
        Berita::updateOrCreate(
            ['slug' => 'ramadhan-penuh-berkah-masjid-grand-center-point-bekasi-gelar-santunan-anak-yatim'],
            [
                'kategori_id'      => $kategori->id,
                'user_id'          => $userId,
                'judul'            => 'Ramadhan Penuh Berkah: Masjid Grand Center Point Bekasi Gelar Santunan untuk Anak Yatim',
                'slug'             => 'ramadhan-penuh-berkah-masjid-grand-center-point-bekasi-gelar-santunan-anak-yatim',
                'ringkasan'        => 'Dalam suasana Ramadhan yang penuh berkah, Masjid Grand Center Point Bekasi menggelar kegiatan santunan untuk anak yatim sebagai bentuk kepedulian sosial di bulan suci.',
                'konten'           => '<p>Dalam suasana Ramadhan yang penuh berkah, Masjid Grand Center Point Bekasi kembali menunjukkan komitmennya sebagai pusat kegiatan sosial keagamaan dengan menggelar santunan untuk anak-anak yatim di sekitar wilayah Bekasi.</p>

<p>Kegiatan yang digelar pada bulan Ramadhan ini merupakan wujud nyata semangat berbagi yang selalu dikobarkan oleh DKM Grand Center Point. Ratusan anak yatim dari berbagai wilayah di Kota Bekasi hadir untuk menerima santunan yang telah disiapkan oleh panitia.</p>

<p>Pengurus DKM Grand Center Point menyatakan bahwa kegiatan santunan di bulan Ramadhan ini sudah menjadi agenda tahunan masjid. "Ramadhan adalah momen terbaik untuk berbagi. Kami berharap kegiatan ini dapat memberikan kebahagiaan kepada anak-anak yatim dan keluarga mereka," ungkap salah satu pengurus DKM.</p>

<p>Santunan yang diberikan meliputi uang tunai, paket sembako, serta perlengkapan belajar bagi anak-anak yatim. Selain santunan, acara juga dimeriahkan dengan berbagai kegiatan keagamaan seperti pembacaan Al-Quran, ceramah, dan doa bersama.</p>

<p>Antusiasme masyarakat yang hadir sangat tinggi, mencerminkan besarnya kepercayaan warga sekitar kepada Masjid Grand Center Point sebagai lembaga yang aktif dalam kegiatan sosial kemasyarakatan.</p>

<p><em>Sumber: Suara Karya, Maret 2026</em></p>',
                'status'           => 'published',
                'is_featured'      => false,
                'views'            => 0,
                'published_at'     => Carbon::parse('2026-03-06 19:37:00'),
                'meta_title'       => 'Ramadhan Penuh Berkah: Masjid Grand Center Point Bekasi Gelar Santunan Anak Yatim',
                'meta_description' => 'Masjid Grand Center Point Bekasi menggelar santunan anak yatim di bulan Ramadhan sebagai wujud kepedulian sosial.',
                'meta_keywords'    => 'Ramadhan, santunan anak yatim, Masjid Grand Center Point, Bekasi, kegiatan sosial',
            ]
        );

        // ─── Berita 4 ─────────────────────────────────────────────────────────────
        // Sumber: inijabar.com — 12 Desember 2025
        // Masjid Grand Centerpoint: Dari Bisik-Bisik 'Esek-Esek' ke Suara Azan yang Menggema
        Berita::updateOrCreate(
            ['slug' => 'masjid-grand-centerpoint-dari-bisik-bisik-ke-suara-azan-yang-menggema'],
            [
                'kategori_id'      => $kategoriOpini->id,
                'user_id'          => $userId,
                'judul'            => 'Masjid Grand Centerpoint: Dari Bisik-Bisik ke Suara Azan yang Menggema',
                'slug'             => 'masjid-grand-centerpoint-dari-bisik-bisik-ke-suara-azan-yang-menggema',
                'ringkasan'        => 'Sebuah liputan menarik tentang transformasi Masjid Grand Centerpoint Bekasi — dari kawasan yang dulunya dikenal negatif, kini menjelma menjadi pusat ibadah yang ramai dengan jamaah shalat Jumat yang membludak.',
                'konten'           => '<p>Tak terasa jam mulai menunjukkan pukul 11.30 WIB di dinding warung kopi di Apartemen Center Point yang terletak di Jalan Ahmad Yani Kota Bekasi. Teringat hari ini Jumat, yang bagi lelaki muslim merupakan kewajiban menunaikan shalat Jumat.</p>

<p>Seorang teman memberi saran: "Shalat Jumat di sini aja," seraya mengajak ke Basement gedung D. Di situlah letak masjid yang dimaksud — Masjid Grand Centerpoint.</p>

<p>Nampak jamaah shalat Jumat sudah duduk rapi mendengarkan khutbah. Yang mengejutkan, jamaah terlihat cukup membludak memenuhi ruangan masjid yang terletak di basement apartemen tersebut. Pemandangan yang sungguh menggembirakan.</p>

<p>Kisah transformasi ini menarik untuk disimak. Kawasan Centerpoint yang dahulu sempat dikenal dengan berbagai bisik-bisik negatif, kini telah berubah wajah. Kehadiran Masjid Grand Centerpoint menjadi salah satu katalis perubahan yang nyata di kawasan ini.</p>

<p>Suara azan yang menggema dari masjid ini menjadi penanda bahwa tempat ini kini telah menjadi pusat spiritual yang ramai dikunjungi. Ratusan jamaah memenuhi shaf-shaf shalat, membuktikan bahwa masyarakat Bekasi menyambut hangat kehadiran masjid ini.</p>

<p>DKM Grand Centerpoint terus berupaya menghadirkan program-program yang relevan dan bermanfaat bagi jamaah, mulai dari kajian rutin, kegiatan sosial, hingga pemberdayaan masyarakat sekitar. Transformasi ini menjadi inspirasi bahwa masjid memiliki peran strategis dalam mengubah wajah suatu kawasan.</p>

<p><em>Sumber: inijabar.com, 12 Desember 2025</em></p>',
                'status'           => 'published',
                'is_featured'      => true,
                'views'            => 0,
                'published_at'     => Carbon::parse('2025-12-12 14:14:00'),
                'meta_title'       => 'Masjid Grand Centerpoint: Dari Bisik-Bisik ke Suara Azan yang Menggema',
                'meta_description' => 'Liputan transformasi Masjid Grand Centerpoint Bekasi yang kini menjadi pusat ibadah ramai dengan jamaah shalat Jumat membludak.',
                'meta_keywords'    => 'Masjid Grand Centerpoint, transformasi, Bekasi, shalat Jumat, Jalan Ahmad Yani',
            ]
        );

        $this->command->info('BeritaAndUserSeeder selesai: 4 berita + user wisnu.ashar@centerpoint.com berhasil ditambahkan.');
    }
}
