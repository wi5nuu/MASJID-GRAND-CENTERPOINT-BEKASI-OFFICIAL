<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->timestamps();
        });

        // Add role_id to users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->default(2)->constrained('roles');
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
        });

        // Settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Kategori (shared)
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('tipe'); // berita, kegiatan, galeri, video, donasi
            $table->string('warna')->default('#16a34a');
            $table->timestamps();
        });

        // Berita / Artikel
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan')->nullable();
            $table->longText('konten');
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Kegiatan (jadwal rutin)
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai')->nullable();
            $table->string('lokasi')->nullable()->default('Masjid Grand Centerpoint');
            $table->string('narasumber')->nullable();
            $table->enum('jenis', ['rutin', 'khusus'])->default('rutin');
            $table->enum('hari_rutin', ['senin','selasa','rabu','kamis','jumat','sabtu','ahad'])->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('thumbnail')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Events
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->longText('konten')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('kuota')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Galeri Foto
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
            $table->string('judul');
            $table->string('file');
            $table->text('keterangan')->nullable();
            $table->string('album')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Video
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('url_youtube')->nullable();
            $table->string('file_video')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Donasi
        Schema::create('donasi_programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable();
            $table->decimal('target', 15, 2)->nullable();
            $table->decimal('terkumpul', 15, 2)->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->nullable()->constrained('donasi_programs')->nullOnDelete();
            $table->string('nama')->default('Hamba Allah');
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->decimal('jumlah', 15, 2);
            $table->enum('metode', ['transfer', 'qris', 'tunai', 'lainnya'])->default('transfer');
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->text('pesan')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->string('kode_unik', 10)->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });

        // Pengurus
        Schema::create('pengurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('periode')->nullable();
            $table->string('foto')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Jadwal Shalat
        Schema::create('jadwal_shalats', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->string('subuh');
            $table->string('syuruq')->nullable();
            $table->string('dzuhur');
            $table->string('ashar');
            $table->string('maghrib');
            $table->string('isya');
            $table->string('jumat')->nullable();
            $table->string('hijri_date')->nullable();
            $table->timestamps();
        });

        // Kontak / Pesan masuk
        Schema::create('kontaks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('subjek')->nullable();
            $table->text('pesan');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Newsletter
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        // TV Display / Teks berjalan
        Schema::create('tv_displays', function (Blueprint $table) {
            $table->id();
            $table->string('tipe'); // running_text, pengumuman, jadwal, gambar
            $table->string('judul')->nullable();
            $table->text('konten');
            $table->string('file')->nullable();
            $table->unsignedInteger('durasi')->default(10); // detik
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // SEO pages
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('halaman')->unique();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });

        // Media files
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('nama');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->string('disk')->default('public');
            $table->string('koleksi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_files');
        Schema::dropIfExists('seo_pages');
        Schema::dropIfExists('tv_displays');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('kontaks');
        Schema::dropIfExists('jadwal_shalats');
        Schema::dropIfExists('pengurus');
        Schema::dropIfExists('donasis');
        Schema::dropIfExists('donasi_programs');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('galeris');
        Schema::dropIfExists('events');
        Schema::dropIfExists('kegiatans');
        Schema::dropIfExists('beritas');
        Schema::dropIfExists('kategoris');
        Schema::dropIfExists('settings');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'avatar', 'is_active']);
        });
        Schema::dropIfExists('roles');
    }
};
