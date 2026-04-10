<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    // Opsional, karena nama tabel sudah jamak ('antrians'), tapi tidak masalah tetap ada
    protected $table = 'antrians';

    protected $fillable = [
        'nomor_antrian',
        'nama_pelanggan',
        'layanan_id', // Sebaiknya ditambahkan karena ada di migration
        'status',
        'waktu_masuk',
        'waktu_selesai',
    ];
}
