<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Validable;
use Sofa\Eloquence\Contracts\Validable as ValidableContract;

/**
 * Class DedicatedServer
 *
 * @property int $id
 * @property boolean $enabled
 * @property string $name
 * @property string $os
 * @property string $location
 * @property string $provider
 * @property string $ip
 * @property string $ram
 * @property string $cpu
 * @property string $work_path
 * @property string $steamcmd_path
 * @property string $gdaemon_host
 * @property string $gdaemon_login
 * @property string $gdaemon_password
 * @property string $gdaemon_privkey
 * @property string $gdaemon_pubkey
 * @property string $gdaemon_keypass
 * @property string $gdaemon_api_key
 * @property string $gdaemon_api_token
 * @property string $prefer_install_method
 * @property string $script_install
 * @property string $script_reinstall
 * @property string $script_update
 * @property string $script_start
 * @property string $script_pause
 * @property string $script_stop
 * @property string $script_kill
 * @property string $script_restart
 * @property string $script_status
 * @property string $script_get_console`
 * @property string $script_send_command
 * @property string $created_at
 * @property string $updated_at
 */
class DedicatedServer extends Model implements ValidableContract
{
    use Validable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enabled', 
        'name', 
        'os',
        'location', 
        'provider', 
        'ip',
        'ram',
        'cpu', 
        'work_path',
        'steamcmd_path', 
        'gdaemon_host',
        'gdaemon_login', 
        'gdaemon_password',
        'gdaemon_privkey', 
        'gdaemon_pubkey',
        'gdaemon_keypass', 
        'prefer_install_method',
        'script_install',
        'script_reinstall',
        'script_update',
        'script_start',
        'script_pause',
        'script_stop', 
        'script_kill', 
        'script_restart',
        'script_status', 
        'script_get_console',
        'script_send_command'
    ];

    protected $casts = [
        'ip' => 'array',
    ];

    /**
     * Validation rules
     * @var array
     */
    protected static $rules = [
        'name' => 'required|max:128',
        'location' => 'required|max:128',
        // 'ip' => 'required|array',
        'work_path' => 'required|max:128',
        'gdaemon_host' => 'required|max:128',
        'gdaemon_login' => 'required|max:128',
        'gdaemon_password' => 'required|max:128',
        'gdaemon_privkey' => 'required|max:128',
        'gdaemon_keypass' => 'required|max:128',
        // 'gdaemon_api_key' => 'required|max:128',
    ];

    /**
     * One to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers()
    {
        return $this->hasMany(Server::class, 'ds_id');
    }
}
