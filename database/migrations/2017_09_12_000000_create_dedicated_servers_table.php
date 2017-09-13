<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDedicatedServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dedicated_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('enabled');
            $table->string('name');
            $table->string('os');
            $table->string('location');
            $table->string('provider');
            $table->text('ip');
            $table->string('ram');
            $table->string('cpu');
            $table->string('work_path');
            $table->string('steamcmd_path');
            $table->string('gdaemon_host');
            $table->string('gdaemon_login');
            $table->string('gdaemon_password');
            $table->string('gdaemon_privkey');
            $table->string('gdaemon_pubkey');
            $table->string('gdaemon_keypass');
            $table->text('script_start');
            $table->text('script_stop');
            $table->text('script_restart');
            $table->text('script_status');
            $table->text('script_get_console');
            $table->text('script_send_command');
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
        Schema::dropIfExists('dedicated_servers');
    }
}
