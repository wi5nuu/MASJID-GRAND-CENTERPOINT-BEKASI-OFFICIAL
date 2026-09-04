<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $fillable = ['nama', 'email', 'telepon', 'subjek', 'pesan', 'is_read', 'read_at'];
    protected $casts = ['is_read' => 'boolean', 'read_at' => 'datetime'];
    public function scopeUnread($q) { return $q->where('is_read', false); }
}
