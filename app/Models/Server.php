<?php

namespace Gameap\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property Game $game
 * @property GameMod $gameMod
 * @property ServerSetting[] $settings
 * @property User[] $users
 * @property ServerTask[] $tasks
 */
class Server extends Model
{
    use SoftDeletes;

    public const TIME_EXPIRE_PROCESS_CHECK = 120;

    // Installed statuses
    public const NOT_INSTALLED        = 0;
    public const INSTALLED            = 1;
    public const INSTALLATION_PROCESS = 2;

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
        'vars'           => 'array',
        'enabled'        => 'boolean',
        'installed'      => 'integer',
        'blocked'        => 'boolean',
        'ds_id'          => 'integer',
        'game_mod_id'    => 'integer',
        'server_port'    => 'integer',
        'query_port'     => 'integer',
        'rcon_port'      => 'integer',
        'process_active' => 'boolean',
    ];

    public function processActive(): bool
    {
        if (empty($this->last_process_check)) {
            return false;
        }

        $lastProcessCheck = Carbon::createFromFormat(
            Carbon::DEFAULT_TO_STRING_FORMAT,
            $this->last_process_check,
            'UTC'
        )->timestamp;

        return $this->process_active
            && $lastProcessCheck >= Carbon::now()->timestamp - self::TIME_EXPIRE_PROCESS_CHECK;
    }

    public function dedicatedServer(): BelongsTo
    {
        return $this->belongsTo(DedicatedServer::class, 'ds_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id', 'code');
    }

    public function gameMod(): BelongsTo
    {
        return $this->belongsTo(GameMod::class, 'game_mod_id');
    }

    public function settings(): HasMany
    {
        return $this->hasMany(ServerSetting::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(ServerTask::class);
    }

    public function getFullPathAttribute(): string
    {
        return rtrim($this->dedicatedServer->work_path, '/') . '/' . ltrim($this->dir, '/');
    }

    public function getFileManagerDisksAttribute(): array
    {
        $fileManagerDisks = [
            'server' => array_merge(
                $this->dedicatedServer->gdaemonSettings('local'),
                ['driver' => 'gameap', 'workDir' => $this->full_path, 'root' => $this->full_path]
            ),
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getAliasesAttribute(): array
    {
        $aliases = [
            'ip'            => $this->server_ip,
            'port'          => $this->server_port,
            'query_port'    => $this->query_port,
            'rcon_port'     => $this->rcon_port,
            'rcon_password' => $this->rcon,
            'uuid'          => $this->uuid,
            'uuid_short'    => $this->uuid_short,
        ];

        if ($this->gameMod !== null && is_array($this->gameMod->vars)) {
            foreach ($this->gameMod->vars as $var) {
                $varname           = $var['var'];
                $aliases[$varname] = $this->vars[$varname] ?? $var['default'];
            }
        }

        return $aliases;
    }
}
