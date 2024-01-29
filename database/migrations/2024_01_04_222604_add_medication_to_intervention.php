<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            //
            $table->text('medication')->nullable();
            $table->dropForeign(['intervention_class_id']);
            $table->dropColumn('intervention_class_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            //
            $table->bigInteger('intervention_class_id')->index()->unsigned();
            $table->foreign('intervention_class_id')->references('id')->on('intervention_classes');
        });
    }
};
