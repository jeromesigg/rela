<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergyHealthInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergy_health_information', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('comment')->nullable();
            $table->bigInteger('health_information_id')->index()->unsigned();
            $table->foreign('health_information_id')->references('id')->on('health_information');
            $table->bigInteger('allergy_id')->index()->unsigned();
            $table->foreign('allergy_id')->references('id')->on('allergies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allergy_health_information');
    }
}
