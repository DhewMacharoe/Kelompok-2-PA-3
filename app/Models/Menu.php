<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'deskripsi',
        'foto',
        'is_available',
        'user_id'
    ];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('active_menus');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('active_menus');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
