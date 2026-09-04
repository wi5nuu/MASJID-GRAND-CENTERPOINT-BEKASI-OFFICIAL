# Platform Digital Masjid Grand Centerpoint Bekasi

Platform digital resmi **Masjid Grand Centerpoint Bekasi** — sistem informasi terpadu untuk pengelolaan konten, informasi jamaah, dan operasional masjid.

---

## Tentang Sistem

Platform ini dibangun sebagai solusi digital terpusat yang menghubungkan pengurus DKM dengan jamaah melalui website publik, panel manajemen admin, dan layar informasi masjid (TV Display). Seluruh konten dikelola secara real-time oleh pengurus yang berwenang.

---

## Arsitektur Sistem

### Website Publik
Halaman yang dapat diakses oleh seluruh jamaah dan masyarakat umum:

- **Beranda** — Jadwal shalat hari ini, berita terkini, pengumuman, dan informasi umum masjid
- **Berita & Artikel** — Publikasi berita, artikel islami, dan liputan kegiatan
- **Jadwal Kegiatan** — Kegiatan rutin mingguan dan event khusus masjid
- **Galeri** — Dokumentasi foto kegiatan dan momen masjid
- **Video** — Rekaman kajian, khutbah, dan kegiatan masjid
- **Donasi** — Informasi program donasi dan pembangunan masjid
- **Pengurus** — Profil struktur kepengurusan DKM
- **Kontak** — Informasi kontak dan lokasi masjid

### Panel Admin
Sistem manajemen konten (CMS) berbasis web yang dapat diakses oleh pengurus berwenang:

- **Dashboard** — Ringkasan statistik dan aktivitas terkini
- **Manajemen Konten** — Berita, kegiatan, event, galeri foto, dan video
- **Jadwal Shalat** — Pengelolaan jadwal waktu shalat harian dengan sinkronisasi otomatis dari API
- **Donasi** — Pencatatan dan pengelolaan program donasi
- **Pengurus** — Manajemen data dan profil pengurus DKM
- **TV Display** — Pengaturan konten layar informasi masjid
- **Pengguna** — Manajemen akun dan hak akses admin
- **SEO** — Pengaturan metadata untuk setiap halaman
- **Pengaturan** — Konfigurasi umum sistem

### TV Display
Layar informasi digital yang terpasang di area masjid, menampilkan:

- Jadwal waktu shalat hari ini
- Running text pengumuman
- Popup informasi penting
- Konten yang dikelola langsung dari panel admin

---

## Jadwal Shalat

Waktu shalat diambil secara otomatis dari **Aladhan API** berdasarkan koordinat Kota Bekasi menggunakan metode perhitungan MUIS/Singapore yang relevan untuk wilayah Indonesia. Data diperbarui setiap hari secara otomatis oleh sistem scheduler, dan dapat diperbarui secara manual oleh admin melalui panel.

---

## Teknologi

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Tailwind CSS v4, Alpine.js |
| Database | MySQL |
| API Eksternal | Aladhan Prayer Times API |
| Editor Konten | Quill.js |

---

## Keamanan

- Seluruh akses panel admin dilindungi autentikasi dan sistem role-based access control (RBAC)
- Sesi terenkripsi dan CSRF protection aktif pada seluruh form
- File environment (`.env`) tidak disertakan dalam repositori
- `APP_DEBUG` dinonaktifkan di environment production
- Upload file dibatasi tipe dan ukurannya

---

## Lisensi

Hak cipta &copy; 2026 DKM Masjid Grand Centerpoint Bekasi. Seluruh hak dilindungi.
