<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $fillable = [
        'program_id', 'nama', 'email', 'telepon', 'jumlah', 'metode',
        'status', 'pesan', 'bukti_transfer', 'kode_unik', 'confirmed_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function program() { return $this->belongsTo(DonasiProgram::class, 'program_id'); }

    public function scopePending($q) { return $q->where('status', 'pending'); }
    public function scopeConfirmed($q) { return $q->where('status', 'confirmed'); }
}
