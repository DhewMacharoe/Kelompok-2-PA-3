<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Antrian;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';

    protected $fillable = [
        'nama_pelanggan',
        'nomor_telepon',
        'password',
    ];

    public function register(): bool
    {
        return $this->save();
    }

    public function login(): bool
    {
        return true;
    }

    public function buatAntrian(array $data): Antrian
    {
        return Antrian::create($data);
    }

    public function lihatStatusAntrian(): string
    {
        return $this->antrians()->latest()->first()?->status ?? 'Belum ada antrian';
    }

    public function antrians()
    {
        return $this->hasMany(Antrian::class);
    }
}
