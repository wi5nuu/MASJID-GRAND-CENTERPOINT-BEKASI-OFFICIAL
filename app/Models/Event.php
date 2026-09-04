<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'judul', 'slug', 'deskripsi', 'konten', 'tanggal_mulai',
        'tanggal_selesai', 'waktu_mulai', 'lokasi', 'thumbnail',
        'is_active', 'is_featured', 'kuota',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
        });
    }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeUpcoming($q) { return $q->where('tanggal_mulai', '>=', now()->toDateString()); }
    public function getRouteKeyName() { return 'slug'; }
}
