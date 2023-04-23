<?php

namespace Gameap\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * @property string $name
 * @property string $token
 * @property array $abilities
 * @property \DateTime $last_used_at
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
}
