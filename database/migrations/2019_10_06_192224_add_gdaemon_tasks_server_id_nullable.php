<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGdaemonTasksServerIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gdaemon_tasks_tmp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('run_aft_id')->unsigned()->nullable();
            $table->timestamps();
            $table->integer('dedicated_server_id')->unsigned();
            $table->integer('server_id')->unsigned()->nullable(true);
            $table->string('task', 8);
            $table->mediumText('data')->nullable();
            $table->text('cmd')->nullable();
            $table->mediumText('output')->nullable();
            $table->enum('status', ['waiting', 'working', 'error', 'success', 'canceled'])->default('waiting');
        });

        DB::statement("INSERT INTO gdaemon_tasks_tmp SELECT * FROM gdaemon_tasks;");

        Schema::dropIfExists('gdaemon_tasks');
        Schema::rename('gdaemon_tasks_tmp', 'gdaemon_tasks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('gdaemon_tasks_tmp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('run_aft_id')->unsigned()->nullable();
            $table->timestamps();
            $table->integer('dedicated_server_id')->unsigned();
            $table->integer('server_id')->unsigned()->nullable(false);
            $table->string('task', 8);
            $table->mediumText('data')->nullable();
            $table->text('cmd')->nullable();
            $table->mediumText('output')->nullable();
            $table->enum('status', ['waiting', 'working', 'error', 'success'])->default('waiting');
        });

        DB::statement("INSERT INTO gdaemon_tasks_tmp SELECT * FROM gdaemon_tasks;");

        Schema::dropIfExists('gdaemon_tasks');
        Schema::rename('gdaemon_tasks_tmp', 'gdaemon_tasks');
    }
}
