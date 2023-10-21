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
        Schema::table('health_information', function (Blueprint $table) {
            //
            $table->bigInteger('health_status_id')->index()->unsigned()->nullable();
            $table->foreign('health_status_id')->references('id')->on('health_statuses');
            $table->boolean('accept_privacy_agreement')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_information', function (Blueprint $table) {
            //
            $table->dropForeign(['health_status_id']);
            $table->dropColumn('health_status_id');
            $table->dropColumn('accept_privacy_agreement');
        });
    }
};
