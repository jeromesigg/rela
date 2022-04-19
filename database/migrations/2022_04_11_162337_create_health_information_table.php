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
            $table->id();
            $table->timestamps();
            $table->longText('code');
            $table->string('recent_issues')->nullable();
            $table->string('recent_issues_doctor')->nullable();
            $table->string('drugs')->nullable();
            $table->boolean('drugs_only_contact')->default(false);
            $table->string('chronicle_diseases')->nullable();
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
