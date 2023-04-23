<?php

namespace Gameap\Helpers;

use Illuminate\Support\Facades\Auth;

class UserHelper
{
    public static function isAdmin(): bool
    {
        return Auth::user()->can(PermissionHelper::ADMIN_PERMISSIONS);
    }
}
