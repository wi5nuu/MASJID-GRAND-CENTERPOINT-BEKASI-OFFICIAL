<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Kegiatan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_id', 'judul', 'slug', 'deskripsi', 'tanggal', 'waktu_mulai',
        'waktu_selesai', 'lokasi', 'narasumber', 'jenis', 'hari_rutin',
        'is_active', 'thumbnail',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean',
    ];

    public function kategori() { return $this->belongsTo(Kategori::class); }

    public function getRouteKeyName(): string { return 'slug'; }

    protected static function booted(): void
    {
        static::creating(function ($kegiatan) {
            if (empty($kegiatan->slug)) {
                $kegiatan->slug = Str::slug($kegiatan->judul);
            }
        });

        static::updating(function ($kegiatan) {
            if ($kegiatan->isDirty('judul') && empty($kegiatan->slug)) {
                $kegiatan->slug = Str::slug($kegiatan->judul);
            }
        });
    }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeUpcoming($q) { return $q->where('tanggal', '>=', now()->toDateString()); }
    public function scopeToday($q) { return $q->whereDate('tanggal', today()); }

    /**
     * Accessor: otomatis resolving URL thumbnail.
     * - Path diawali 'images/' → dari public/images/ (asset)
     * - Lainnya → dari Laravel storage
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail) return null;

        if (str_starts_with($this->thumbnail, 'images/')) {
            return asset($this->thumbnail);
        }

        return Storage::url($this->thumbnail);
    }
}
