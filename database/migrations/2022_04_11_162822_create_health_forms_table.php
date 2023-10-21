<?php

use App\Models\HealthForm;
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
        Schema::connection('mysql_info')->create('health_forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('code');
            $table->string('nickname');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('ahv')->nullable();
            $table->string('street')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone_number')->nullable();
            $table->bigInteger('group_id')->index()->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_address')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('doctor_contact')->nullable();
            $table->string('health_insurance_contact')->nullable();
            $table->string('accident_insurance_contact')->nullable();
            $table->string('liability_insurance_contact')->nullable();
            $table->boolean('swimmer')->default(false);
            $table->boolean('finish')->default(false);
            $table->string('vaccination')->nullable();
            $table->string('file_allergies')->nullable();
            $table->bigInteger('camp_id')->index()->unsigned()->nullable();
            $table->foreign('camp_id')->references('id')->on('camps')->onDelete('cascade');
            HealthForm::addSlugColumn($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_info')->dropIfExists('health_forms');
    }
};
