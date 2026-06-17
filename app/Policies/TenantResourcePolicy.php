<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class TenantResourcePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, $model): bool
    {
        return $user->hasRole('super_admin') || 
               ($user->hasRole('admin') && $user->barbershop_id === $model->barbershop_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin and Super Admin can create records
        return $user->hasAnyRole(['super_admin', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, $model): bool
    {
        return $user->hasRole('super_admin') || 
               ($user->hasRole('admin') && $user->barbershop_id === $model->barbershop_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, $model): bool
    {
        return $user->hasRole('super_admin') || 
               ($user->hasRole('admin') && $user->barbershop_id === $model->barbershop_id);
    }
}
