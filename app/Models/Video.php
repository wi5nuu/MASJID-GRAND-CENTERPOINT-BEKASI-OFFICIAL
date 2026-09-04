<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_id', 'judul', 'slug', 'deskripsi', 'url_youtube',
        'file_video', 'thumbnail', 'views', 'is_active', 'is_featured', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
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

    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function scopeActive($q) { return $q->where('is_active', true); }
    public function getRouteKeyName() { return 'slug'; }

    public function getYoutubeIdAttribute()
    {
        if (!$this->url_youtube) return null;
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->url_youtube, $matches);
        return $matches[1] ?? null;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) return \Storage::url($this->thumbnail);
        if ($this->youtube_id) return "https://img.youtube.com/vi/{$this->youtube_id}/mqdefault.jpg";
        return null;
    }
}
