<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->string('last_ip')->nullable();
            $table->string('clan')->nullable();
            $table->unsignedBigInteger('standoff_id')->unique()->unsigned();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('ban')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
