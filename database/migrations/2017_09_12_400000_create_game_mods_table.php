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
            $table->text('fast_rcon')->nullable();
            $table->text('vars')->nullable();
            $table->text('remote_repository')->nullable();
            $table->text('local_repository')->nullable();
            $table->text('default_start_cmd')->nullable();
            $table->string('kick_cmd', 64)->nullable();
            $table->string('ban_cmd', 64)->nullable();
            $table->string('chname_cmd', 64)->nullable();
            $table->string('srestart_cmd', 64)->nullable();
            $table->string('chmap_cmd', 64)->nullable();
            $table->string('sendmsg_cmd', 64)->nullable();
            $table->string('passwd_cmd', 64)->nullable();
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
