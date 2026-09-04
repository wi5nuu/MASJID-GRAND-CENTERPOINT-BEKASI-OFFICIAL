<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TvDisplay extends Model
{
    protected $fillable = ['tipe', 'judul', 'konten', 'file', 'durasi', 'urutan', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('urutan'); }
}
