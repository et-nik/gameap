<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTasksFailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers_tasks_fails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('server_task_id');
            $table->longText('output');
            $table->timestamps();

            $table->foreign('server_task_id')
                ->references('id')->on('servers_tasks')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers_tasks_fails');
    }
}
