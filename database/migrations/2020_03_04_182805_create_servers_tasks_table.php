<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task', 16);
            $table->integer('server_id')->index();

            // 0:      repeat endlessly
            // 1:       repeat once
            // 2-255:   repeat count
            $table->unsignedTinyInteger('repeat')->default(1);
            $table->integer('repeat_period')->default(0);
            $table->unsignedInteger('counter')->default(0);
            $table->timestamp('execute_date')->index();
            $table->longText('payload')->nullable();
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
        Schema::dropIfExists('servers_tasks');
    }
}
