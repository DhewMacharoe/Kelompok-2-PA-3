<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';

    protected $fillable = [
        'nama',
        'harga',
        'estimasi_waktu',
        'deskripsi',
        'foto',
        'is_active',
    ];

    public function tambahLayanan(array $data): bool
    {
        return $this->fill($data)->save();
    }

    public function updateLayanan(array $data): bool
    {
        return $this->update($data);
    }

    public function getDetailLayanan(): self
    {
        return $this;
    }

    public function antrians()
    {
        return $this->belongsToMany(Antrian::class, 'antrian_layanan', 'layanan_id', 'antrian_id')
            ->withTimestamps();
    }
}
