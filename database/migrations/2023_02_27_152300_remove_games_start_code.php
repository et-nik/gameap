<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveGamesStartCode extends Migration
{
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('start_code');
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('start_code', 16)->nullable();
        });
    }
}
