<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $fillable = [
        'kategori_id', 'judul', 'file', 'keterangan', 'album', 'urutan', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function scopeActive($q) { return $q->where('is_active', true); }
}
