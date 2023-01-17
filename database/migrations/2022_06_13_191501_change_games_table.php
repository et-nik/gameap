<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->renameColumn('steam_app_id', 'steam_app_id_linux');
            $table->renameColumn('remote_repository', 'remote_repository_linux');
            $table->renameColumn('local_repository', 'local_repository_linux');
        });
        Schema::table('games', function (Blueprint $table) {
            $table->integer('steam_app_id_windows')->after('steam_app_id_linux')->unsigned()->nullable();
            $table->string('remote_repository_windows')->after('remote_repository_linux')->nullable();
            $table->string('local_repository_windows')->after('local_repository_linux')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->renameColumn('steam_app_id_linux', 'steam_app_id');
            $table->renameColumn('remote_repository_linux', 'remote_repository');
            $table->renameColumn('local_repository_linux', 'local_repository');
            $table->dropColumn('steam_app_id_windows');
            $table->dropColumn('remote_repository_windows');
            $table->dropColumn('local_repository_windows');
        });
    }
}
