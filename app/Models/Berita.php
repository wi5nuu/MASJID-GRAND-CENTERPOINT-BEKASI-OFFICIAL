<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Berita extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_id', 'user_id', 'judul', 'slug', 'ringkasan', 'konten',
        'thumbnail', 'status', 'is_featured', 'views', 'published_at',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $casts = [
        'published_at' => 'datetime',
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
    public function user() { return $this->belongsTo(User::class); }

    public function scopePublished($q) { return $q->where('status', 'published')->whereNotNull('published_at'); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }

    public function getRouteKeyName() { return 'slug'; }
}
