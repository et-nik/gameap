<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Server model
 * @package Gameap\Models
 *
 * @property integer $id
 * @property boolean $enabled
 * @property boolean $installed
 * @property boolean $blocked
 * @property string $name
 * @property string $uuid
 * @property string $uuid_short
 * @property string $game_id
 * @property integer $ds_id
 * @property integer $game_mod_id
 * @property string $expires
 * @property string $server_ip
 * @property integer $server_port
 * @property integer $query_port
 * @property integer $rcon_port
 * @property string $rcon RCON password
 * @property string $dir
 * @property string $su_user
 * @property integer $cpu_limit
 * @property integer $ram_limit
 * @property integer $net_limit
 * @property string $start_command
 * @property string $stop_command
 * @property string $force_stop_command
 * @property string $restart_command
 * @property bool $process_active
 * @property string $last_process_check
 * @property array $vars
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property string $full_path
 *
 * @property DedicatedServer $dedicatedServer
 */
class Server extends Model
{
    const TIME_EXPIRE_PROCESS_CHECK = 120;

    // Installed statuses
    const NOT_INSTALLED              = 0;
    const INSTALLED                  = 1;
    const INSTALLATION_PROCESS       = 2;

    protected $fillable = [
        'uuid', 'uuid_short',
        'enabled', 'name', 'code_name', 'game_id',
        'ds_id', 'game_mod_id', 'expires',
        'installed', 'blocked', 'server_ip', 'server_port',
        'query_port', 'rcon_port',
        'rcon', 'dir', 'su_user',
        'cpu_limit', 'ram_limit', 'net_limit',
        'start_command', 'stop_command',
        'force_stop_command', 'restart_command',
        'vars',
    ];

    protected $casts = [
        'vars' => 'array',
    ];

    /**
     * Get server status
     *
     * @return bool
     */
    public function processActive()
    {
        if (empty($this->last_process_check)) {
            return false;
        }
        
        $lastProcessCheck = Carbon::createFromFormat('Y-m-d H:i:s' , $this->last_process_check)->timestamp;

        if ($this->process_active && $lastProcessCheck >= Carbon::now()->timestamp - self::TIME_EXPIRE_PROCESS_CHECK) {
            return true;
        }

        return false;
    }

    public function dedicatedServer()
    {
        return $this->belongsTo(DedicatedServer::class, 'ds_id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'code');
    }

    public function gameMod()
    {
        return $this->belongsTo(GameMod::class, 'game_mod_id');
    }

    /**
     * One to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany(ServerSetting::class);
    }

    /**
     * @return string
     */
    public function getFullPathAttribute()
    {
        return rtrim($this->dedicatedServer->work_path, '/') . '/' . ltrim($this->dir, '/');
    }

    /**
     * @return array
     */
    public function getFileManagerDisksAttribute()
    {
        $fileManagerDisks = [
            "server" => array_merge(
                $this->dedicatedServer->gdaemonSettings('local'),
                ['driver' => 'gameap', 'workDir' => $this->full_path, 'root' => $this->full_path]
            )
        ];

        $setting = $this->settings()->where('name', 'file-manager')->first();

        if (!empty($setting)) {
            $disks = json_decode($setting->value, true);

            if (!empty($disks)) {
                $fileManagerDisks = array_merge($fileManagerDisks, $disks);
            }
        }


        return $fileManagerDisks;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getAliasesAttribute()
    {
        $aliases = [
            'ip' => $this->server_ip,
            'port' => $this->server_port,
            'query_port' => $this->query_port,
            'rcon_port' => $this->rcon_port,
            'rcon_password' => $this->rcon,
            'uuid' => $this->uuid,
            'uuid_short' => $this->uuid_short,
        ];

        foreach ($this->gameMod->vars as $var) {
            $varname = $var['var'];
            $aliases[ $varname ] = isset($this->vars[$varname])
                ? $this->vars[$varname]
                : $var['default'];
        }

        return $aliases;
    }
}