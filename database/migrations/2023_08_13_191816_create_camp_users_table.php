<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('camp_id')->index()->unsigned()->nullable();
            $table->foreign('camp_id')->references('id')->on('camps')->onDelete('cascade');
            $table->bigInteger('user_id')->index()->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('role_id')->index()->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles');

            $table->unique(['camp_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camp_users');
    }
};
