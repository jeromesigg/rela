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
        Schema::create('health_information_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('answer')->nullable();
            $table->foreignUuid('health_information_id')->references('id')->on('health_information')->onDelete('cascade');
            $table->bigInteger('question_id')->index()->unsigned()->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('healthform_questions');
    }
};
