<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $table = 'pengurus';

    protected $fillable = [
        'nama', 'jabatan', 'periode', 'foto', 'bio',
        'email', 'telepon', 'urutan', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('urutan'); }
}
