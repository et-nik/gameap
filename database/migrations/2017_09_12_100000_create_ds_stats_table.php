<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ds_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dedicated_server_id')->unsigned();
            $table->timestamp('time');
            $table->string('loa');
            $table->string('ram');
            $table->string('cpu');
            $table->string('ifstat');
            $table->integer('ping')->unsigned();
            $table->string('drvspace');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ds_stats');
    }
}
