<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    protected $fillable = ['user_id','nama','file_path','file_name','mime_type','file_size','disk','koleksi'];
    public function user() { return $this->belongsTo(User::class); }
}
