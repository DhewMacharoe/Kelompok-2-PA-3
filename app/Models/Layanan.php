<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('active_layanans');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('active_layanans');
        });
    }

    protected $fillable = [
        'nama',
        'harga',
        'estimasi_waktu',
        'deskripsi',
        'ikon',
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

    public function antreans()
    {
        return $this->belongsToMany(Antrean::class, 'antrean_layanan', 'layanan_id', 'antrean_id')
            ->withTimestamps();
    }
}
