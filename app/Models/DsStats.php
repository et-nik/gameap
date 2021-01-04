<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DsStats
 * @package Gameap\Models
 *
 * @property int $id
 * @property int $dedicated_server_id
 * @property string $time
 * @property string $loa
 * @property string $ram
 * @property string $cpu
 * @property string $ifstat
 * @property int $ping
 * @property int $drvspace
 */
class DsStats extends Model
{
    public $timestamps = false;
    protected $fillable = ['dedicated_server_id', 'time', 'loa', 'ram', 'cpu', 'ifstat', 'ping', 'drvspace'];
}
