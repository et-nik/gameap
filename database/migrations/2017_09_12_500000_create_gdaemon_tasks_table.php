<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGdaemonTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gdaemon_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('run_aft_id')->unsigned()->nullable();
            $table->timestamps();
            $table->integer('dedicated_server_id')->unsigned();
            $table->integer('server_id')->unsigned();
            $table->string('task', 8);
            $table->mediumText('data')->nullable();
            $table->text('cmd')->nullable();
            $table->mediumText('output')->nullable();
            $table->enum('status', ['waiting', 'working', 'error', 'success'])->default('waiting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gdaemon_tasks');
    }
}
