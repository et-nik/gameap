<?php

namespace Gameap\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Sofa\Eloquence\Validable;
use Sofa\Eloquence\Contracts\Validable as ValidableContract;

class User extends Authenticatable implements ValidableContract
{
    use Notifiable;
    use HasRoles;
    use Validable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Validation rules
     * 
     * @var array
     */
    protected static $rules = [
        'login'     => 'sometimes|string|max:255|unique:users',
        'email'     => 'sometimes|string|email|max:255|unique:users',
        'password'  => 'sometimes|string|min:6|confirmed',
        'name'      => 'string|nullable|max:255',
    ];

    /**
     * Hash password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
