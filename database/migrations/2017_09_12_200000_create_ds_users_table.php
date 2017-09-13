<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ds_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dedicated_server_id')->unsigned();
            $table->string('username');
            $table->integer('uid')->unsigned();
            $table->integer('gid')->unsigned();
            $table->text('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ds_users');
    }
}
