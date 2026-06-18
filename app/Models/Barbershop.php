<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barbershop extends Model
{
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
        'nama_brand',
        'favicon',
        'alaamat',
        'kontak',
        'email',
        'warna_primer',
        'slogan',
        'deskripsi_hero',
        'gambar_hero',
        'judul_hero_layanan',
        'deskripsi_hero_layanan',
        'gambar_hero_layanan',
        'judul_hero_galeri',
        'deskripsi_hero_galeri',
        'gambar_hero_galeri',
    ];

    protected $casts = [
        'kontak' => 'array',
        'is_active' => 'boolean',
    ];
}
