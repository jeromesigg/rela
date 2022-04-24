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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('health_information_id')->index()->unsigned();
            $table->foreign('health_information_id')->references('id')->on('health_information');
            $table->bigInteger('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('date');
            $table->time('time');
            $table->mediumText('comment')->nullable();
            $table->string('drug');
            $table->string('dose');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medications');
    }
};
