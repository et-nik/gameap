<?php

namespace Gameap\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndAbilities;

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
        //'password'  => 'sometimes|string|min:6|confirmed',
        'password'  => 'nullable|sometimes|string|min:6',
        'name'      => 'string|nullable|max:255',
    ];

    /**
     * Hash password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if ($value != null && strlen($value) > 0) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function servers()
    {
        return $this->belongsToMany(Server::class);
    }
}
