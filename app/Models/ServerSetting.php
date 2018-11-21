<?php

namespace Gameap\Models;

use Illuminate\Database\Eloquent\Model;

class ServerSetting extends Model
{
    public $table = 'servers_settings';
    public $timestamps = false;

    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id');
    }


}
