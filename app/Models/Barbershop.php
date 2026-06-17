<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbershop extends Model
{
    use HasFactory;

    protected $table = 'barber_shops';

    protected $fillable = [
        'nama',
        'slug',
        'alamat',
        'telepon',
        'deskripsi',
        'logo',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'barbershop_id');
    }

    public function antreans()
    {
        return $this->hasMany(Antrean::class, 'barbershop_id');
    }

    public function layanans()
    {
        return $this->hasMany(Layanan::class, 'barbershop_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'barbershop_id');
    }

    public function galeris()
    {
        return $this->hasMany(Galeri::class, 'barbershop_id');
    }

    public function settings()
    {
        return $this->hasMany(Setting::class, 'barbershop_id');
    }
}
