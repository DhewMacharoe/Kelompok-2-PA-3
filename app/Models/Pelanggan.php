<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Antrean;

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

    public function buatAntrean(array $data): Antrean
    {
        return Antrean::create($data);
    }

    public function lihatStatusAntrean(): string
    {
        return $this->antreans()->latest()->first()?->status ?? 'Belum ada antrean';
    }

    public function antreans()
    {
        return $this->hasMany(Antrean::class);
    }
}
