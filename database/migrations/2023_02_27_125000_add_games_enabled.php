<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGamesEnabled extends Migration
{
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->boolean('enabled')->default(true);
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('enabled');
        });
    }
}
