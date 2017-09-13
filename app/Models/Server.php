<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Server model
 * @package Gameap\Models
 *
 * @property integer $id
 * @property boolean $enabled
 * @property string $name
 */
class Server extends Model
{
    public $timestamps = false;
}