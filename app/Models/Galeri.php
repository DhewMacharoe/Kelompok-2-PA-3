<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tenancy\Traits\BelongsToTenant;

class Galeri extends Model
{
    use BelongsToTenant;
    protected $table = 'galeris';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'is_active',
        'user_id',
        'barbershop_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}