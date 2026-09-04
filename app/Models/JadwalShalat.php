<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalShalat extends Model
{
    protected $fillable = [
        'tanggal', 'subuh', 'syuruq', 'dzuhur', 'ashar',
        'maghrib', 'isya', 'jumat', 'hijri_date',
    ];

    protected $casts = ['tanggal' => 'date'];

    public static function today()
    {
        return static::where('tanggal', now()->toDateString())->first();
    }

    public function toArray()
    {
        return [
            ['name' => 'Subuh', 'time' => $this->subuh],
            ['name' => 'Dzuhur', 'time' => $this->dzuhur],
            ['name' => 'Ashar', 'time' => $this->ashar],
            ['name' => 'Maghrib', 'time' => $this->maghrib],
            ['name' => 'Isya', 'time' => $this->isya],
        ];
    }
}
