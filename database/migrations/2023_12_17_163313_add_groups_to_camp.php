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
        Schema::table('camps', function (Blueprint $table) {
            //
            $table->string('group_text')->nullable();
            $table->bigInteger('group_id')->index()->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camps', function (Blueprint $table) {
            //
            $table->dropColumn('group_text');
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });
    }
};
