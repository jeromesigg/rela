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
            $table->bigInteger('health_status_id')->index()->unsigned()->nullable();
            $table->foreign('health_status_id')->references('id')->on('health_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            //
            $table->dropForeign(['health_status_id']);
            $table->dropColumn('health_status_id');
        });
    }
};
