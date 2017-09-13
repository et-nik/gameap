<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('enabled');
            $table->string('name');
            $table->string('code_name', 64);
            $table->string('game_id', 16);
            $table->integer('ds_id')->unsigned();
            $table->integer('game_mod_id')->unsigned();
            $table->timestamp('expires')->nullable();
            $table->boolean('installed');
            $table->string('server_ip', 256);
            $table->integer('server_port')->unsigned();
            $table->integer('query_port')->unsigned();
            $table->integer('rcon_port')->unsigned();
            $table->string('rcon', 256);
            $table->string('dir', 256);
            $table->string('su_user', 256);
            $table->integer('cpu_limit')->unsigned();
            $table->integer('ram_limit')->unsigned();
            $table->integer('net_limit')->unsigned();
            $table->text('start_command');
            $table->text('stop_command');
            $table->text('force_stop_command');
            $table->text('restart_command');
            $table->boolean('process_active');
            $table->timestamp('last_process_check')->nullable();
            $table->text('vars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
