<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class siswa extends Model
{
    use HasRoles;
    protected $fillable = ['nama', 'nis', 'gender', 'alamat', 'kontak', 'email','foto', 'status_pkl'];


    // public function getStatusPklLabelAttribute()
    // {
    //     return $this->status_pkl ? 'Sedang PKL' : 'Belum PKL';
    // }

    public function pkl()
    {
        return $this->hasMany(Pkl::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    protected function foto(): Attribute
    {
        return Attribute::make(
            get: fn ($foto) => url('/storage/siswa/' . $foto),
        );
    }
}