<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
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
        'judul_hero_menu',
        'deskripsi_hero_menu',
        'gambar_hero_menu',
    ];

    protected $casts = [
        'kontak' => 'array',
        'is_active' => 'boolean',
    ];
}
