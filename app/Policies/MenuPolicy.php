<?php

namespace App\Policies;

use App\Models\Menu;

class MenuPolicy extends TenantResourcePolicy
{
    // Inherits view, create, update, delete from TenantResourcePolicy
}
