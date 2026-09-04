<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama', 'slug', 'tipe', 'warna'];

    public function beritas() { return $this->hasMany(Berita::class); }
    public function kegiatans() { return $this->hasMany(Kegiatan::class); }
    public function galeris() { return $this->hasMany(Galeri::class); }
    public function videos() { return $this->hasMany(Video::class); }

    public function scopeOfType($q, $tipe) { return $q->where('tipe', $tipe); }
}
