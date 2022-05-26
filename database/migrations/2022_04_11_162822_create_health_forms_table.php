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

            $table->id();
            $table->timestamps();
            $table->longText('code');
            $table->string('nickname');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('street');
            $table->integer('zip_code');
            $table->string('city');
            $table->date('birthday');
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
            $table->string('file_vaccination')->nullable();
            $table->string('file_allergy')->nullable();
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
