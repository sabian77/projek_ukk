<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    protected $fillable =['nama', 'website', 'bidang_usaha', 'alamat', 'kontak', 'email'];

    public function Pkl()
    {
        return $this->hasMany(Pkl::class);
    }

    // public function guru ()
    // {
    //     return $this->belongsTo(guru::class, 'guru_pembimbing');
    // }
}