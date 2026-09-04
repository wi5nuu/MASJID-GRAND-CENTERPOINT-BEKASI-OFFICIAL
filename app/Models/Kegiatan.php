<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_id', 'judul', 'deskripsi', 'tanggal', 'waktu_mulai',
        'waktu_selesai', 'lokasi', 'narasumber', 'jenis', 'hari_rutin',
        'is_active', 'thumbnail',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean',
    ];

    public function kategori() { return $this->belongsTo(Kategori::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeUpcoming($q) { return $q->where('tanggal', '>=', now()->toDateString()); }
    public function scopeToday($q) { return $q->whereDate('tanggal', today()); }
}
