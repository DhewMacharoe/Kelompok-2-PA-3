<?php

namespace App\Tenancy\Traits;

use App\Tenancy\TenantScope;
use App\Models\Barbershop;

trait BelongsToTenant
{
    /**
     * Boot the trait to add the global scope and auto-populate barbershop_id.
     */
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (empty($model->barbershop_id) && app()->bound('currentTenantId')) {
                $model->barbershop_id = app('currentTenantId');
            }
        });
    }

    /**
     * Get the barbershop that owns this record.
     */
    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class, 'barbershop_id');
    }
}
