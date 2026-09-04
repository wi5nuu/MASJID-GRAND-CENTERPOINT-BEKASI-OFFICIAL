<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DonasiProgram extends Model
{
    protected $fillable = [
        'nama', 'slug', 'deskripsi', 'thumbnail', 'target', 'terkumpul',
        'tanggal_mulai', 'tanggal_selesai', 'is_active', 'is_featured',
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
            if (empty($model->slug)) $model->slug = Str::slug($model->nama);
        });
    }

    public function donasis() { return $this->hasMany(Donasi::class, 'program_id'); }
    public function scopeActive($q) { return $q->where('is_active', true); }

    public function getPersentaseAttribute()
    {
        if (!$this->target || $this->target == 0) return 0;
        return min(100, round(($this->terkumpul / $this->target) * 100));
    }
}
