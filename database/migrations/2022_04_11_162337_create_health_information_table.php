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
        Schema::create('health_information', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('code');
            $table->string('recent_issues')->nullable();
            $table->string('recent_issues_doctor')->nullable();
            $table->text('drug_longterm')->nullable();
            $table->text('drug_demand')->nullable();
            $table->text('drug_emergency')->nullable();
            $table->boolean('drugs_only_contact')->default(false);
            $table->boolean('ointment_only_contact')->default(false);
            $table->string('chronicle_diseases')->nullable();
            $table->string('file_protocol')->nullable();
            $table->text('allergy')->nullable();
            $table->bigInteger('camp_id')->index()->unsigned()->nullable();
            $table->foreign('camp_id')->references('id')->on('camps')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_information');
    }
};
