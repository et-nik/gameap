<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('ds_stats', function(Blueprint $table)
        {
            $table->foreign('dedicated_server_id')->references('id')->on('dedicated_servers')->onDelete('cascade');
        });

        Schema::table('ds_users', function(Blueprint $table)
        {
            $table->foreign('dedicated_server_id')->references('id')->on('dedicated_servers')->onDelete('cascade');
        });

        Schema::table('game_mods', function(Blueprint $table)
        {
            $table->foreign('game_code')->references('code')->on('games')->onDelete('cascade');
        });

        Schema::table('gdaemon_tasks', function(Blueprint $table)
        {
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
        });

        Schema::table('servers_settings', function(Blueprint $table)
        {
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
        });

        Schema::table('servers_stats', function(Blueprint $table)
        {
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
        });

        Schema::table('server_user', function(Blueprint $table)
        {
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('ds_stats', function(Blueprint $table)
        {
            $table->dropForeign('dedicated_server_id');
        });

        Schema::table('game_mods', function(Blueprint $table)
        {
            $table->dropForeign('game_code');
        });

        Schema::table('gdaemon_tasks', function(Blueprint $table)
        {
            $table->dropForeign('server_id');
        });

        Schema::table('ds_users', function(Blueprint $table)
        {
            $table->dropForeign('dedicated_server_id');
        });

        Schema::table('servers_settings', function(Blueprint $table)
        {
            $table->dropForeign('server_id');
        });

        Schema::table('servers_stats', function(Blueprint $table)
        {
            $table->dropForeign('server_id');
        });

        Schema::table('server_user', function(Blueprint $table)
        {
            $table->dropForeign('server_id');
            $table->dropForeign('user_id');
        });

        Schema::enableForeignKeyConstraints();
    }
}
