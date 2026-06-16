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
    ];

    protected $casts = [
        'kontak' => 'array',
        'is_active' => 'boolean',
    ];
}
