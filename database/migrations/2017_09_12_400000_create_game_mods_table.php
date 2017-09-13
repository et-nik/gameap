<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_mods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_code', 16);
            $table->string('name');
            $table->text('fast_rcon');
            $table->text('vars');
            $table->text('remote_repository');
            $table->text('local_repository');
            $table->string('kick_cmd', 64);
            $table->string('ban_cmd', 64);
            $table->string('chname_cmd', 64);
            $table->string('srestart_cmd', 64);
            $table->string('chmap_cmd', 64);
            $table->string('sendmsg_cmd', 64);
            $table->string('passwd_cmd', 64);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_mods');
    }
}
