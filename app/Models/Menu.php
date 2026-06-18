<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tenancy\Traits\BelongsToTenant;

class Menu extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'deskripsi',
        'foto',
        'is_available',
        'user_id',
        'barbershop_id',
    ];

    protected static function booted()
    {
        static::saved(function ($model) {
            $tenantId = $model->barbershop_id ?? (app()->bound('currentTenantId') ? app('currentTenantId') : 1);
            \Illuminate\Support\Facades\Cache::forget("active_menus_tenant_{$tenantId}");
        });

        static::deleted(function ($model) {
            $tenantId = $model->barbershop_id ?? (app()->bound('currentTenantId') ? app('currentTenantId') : 1);
            \Illuminate\Support\Facades\Cache::forget("active_menus_tenant_{$tenantId}");
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
