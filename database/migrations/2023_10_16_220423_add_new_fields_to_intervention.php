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
        Schema::table('interventions', function (Blueprint $table) {
            //
            $table->text('further_treatment')->nullable();
            $table->string('user_close')->nullable();
            $table->date('date_close')->nullable();
            $table->time('time_close')->nullable();
            $table->text('comment_close')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interventions', function (Blueprint $table) {
            //
            $table->dropColumn('further_treatment');
            $table->dropColumn('user_close');
            $table->dropColumn('date_close');
            $table->dropColumn('time_close');
            $table->dropColumn('comment_close');
        });
    }
};
