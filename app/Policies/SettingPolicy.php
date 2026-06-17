<?php

namespace App\Policies;

use App\Models\Setting;

class SettingPolicy extends TenantResourcePolicy
{
    // Inherits view, create, update, delete from TenantResourcePolicy
}
