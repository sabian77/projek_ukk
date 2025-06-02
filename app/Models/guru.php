<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasRoles;
    protected $table = 'gurus';
    protected $fillable = ['nama', 'nip', 'gender', 'alamat', 'kontak', 'email'];

    public function Pkl()
    {
        return $this->hasMany(Pkl::class);
    }

    public function Industri()
    {
        return $this->hasMany(Industri::class);
    }
}