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
            $table->bigInteger('intervention_master_id')->index()->unsigned()->nullable();
            $table->foreign('intervention_master_id')->references('id')->on('interventions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            //
            $table->dropForeign(['intervention_master_id']);
            $table->dropColumn('intervention_master_id');
        });
    }
};
