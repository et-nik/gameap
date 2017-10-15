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
            $table->boolean('enabled')->default(0);
            $table->boolean('installed')->default(0);
            $table->boolean('blocked')->default(0);
            $table->string('name');
            $table->string('code_name', 64);
            $table->string('game_id', 16);
            $table->integer('ds_id')->unsigned();
            $table->integer('game_mod_id')->unsigned();
            $table->timestamp('expires')->nullable();
            $table->string('server_ip', 256);
            $table->integer('server_port')->unsigned();
            $table->integer('query_port')->unsigned()->nullable();
            $table->integer('rcon_port')->unsigned()->nullable();
            $table->string('rcon', 256)->nullable();
            $table->string('dir', 256);
            $table->string('su_user', 256)->nullable();
            $table->integer('cpu_limit')->unsigned()->nullable();
            $table->integer('ram_limit')->unsigned()->nullable();
            $table->integer('net_limit')->unsigned()->nullable();
            $table->text('start_command')->nullable();
            $table->text('stop_command')->nullable();
            $table->text('force_stop_command')->nullable();
            $table->text('restart_command')->nullable();
            $table->boolean('process_active')->default(0);
            $table->integer('last_process_check')->nullable();
            $table->text('vars')->nullable();
            $table->timestamps();
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
