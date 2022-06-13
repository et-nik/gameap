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
        Schema::table('game_mods', function (Blueprint $table) {
            $table->renameColumn('remote_repository', 'remote_repository_linux');
            $table->renameColumn('local_repository', 'local_repository_linux');
            $table->renameColumn('default_start_cmd_linux', 'start_cmd_linux');
            $table->renameColumn('default_start_cmd_windows', 'start_cmd_windows');
            $table->text('remote_repository_windows')->nullable();
            $table->text('local_repository_windows')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_mods', function (Blueprint $table) {
            $table->renameColumn('remote_repository_linux', 'remote_repository');
            $table->renameColumn('local_repository_linux', 'local_repository');
            $table->renameColumn('start_cmd_linux', 'default_start_cmd_linux');
            $table->renameColumn('start_cmd_windows', 'default_start_cmd_windows');
            $table->dropColumn('remote_repository_windows');
            $table->dropColumn('local_repository_windows');
        });
    }
}
