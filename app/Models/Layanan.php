<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';

    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'estimasi_waktu',
        'deskripsi',
        'foto',
        'is_active',
    ];
}

