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
 * @property string $code_name
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
 * @property string $vars
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Server extends Model
{
    const TIME_EXPIRE_PROCESS_CHECK = 120;

    protected $fillable = [
        'enabled', 'name', 'code_name', 'game_id',
        'ds_id', 'game_mod_id', 'expires',
        'installed', 'server_ip', 'server_port',
        'query_port', 'rcon_port',
        'rcon', 'dir', 'su_user',
        'cpu_limit', 'ram_limit', 'net_limit',
        'start_command', 'stop_command',
        'force_stop_command', 'restart_command'
    ];

    /**
     * Get server status
     *
     * @return bool
     */
    public function processActive()
    {
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
}