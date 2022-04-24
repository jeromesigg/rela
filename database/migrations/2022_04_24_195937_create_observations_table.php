<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('observation_class_id')->index()->unsigned();
            $table->foreign('observation_class_id')->references('id')->on('observations');
            $table->bigInteger('health_information_id')->index()->unsigned();
            $table->foreign('health_information_id')->references('id')->on('health_information');
            $table->bigInteger('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('date');
            $table->time('time');
            $table->mediumText('comment')->nullable();
            $table->string('parameter');
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observations');
    }
}
