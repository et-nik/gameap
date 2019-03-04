<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientCertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fingerprint');
            $table->timestamp('expires');
            $table->string('certificate');
            $table->string('private_key');
            $table->string('private_key_pass')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_certificates');
    }
}
