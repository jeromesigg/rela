<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilesToHealthForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_info')->table('health_forms', function (Blueprint $table) {
            //
            $table->string('file_vaccination')->nullable();
            $table->string('file_allergy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_info')->table('health_forms', function (Blueprint $table) {
            //
            $table->dropColumn('file_vaccination');
            $table->dropColumn('file_allergy');
        });
    }
}
