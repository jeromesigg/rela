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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('intervention_class_id')->index()->unsigned();
            $table->foreign('intervention_class_id')->references('id')->on('intervention_classes');
            $table->bigInteger('health_information_id')->index()->unsigned();
            $table->foreign('health_information_id')->references('id')->on('health_information');
            $table->bigInteger('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('date');
            $table->time('time');
            $table->mediumText('comment')->nullable();
            $table->string('parameter');
            $table->string('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interventions');
    }
};
