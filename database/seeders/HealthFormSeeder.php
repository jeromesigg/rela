<?php

namespace Database\Seeders;

use App\Models\HealthForm;
use App\Models\HealthInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i=0;$i<300;$i++) {
            $health_form = HealthForm::factory()->create();
            HealthInformation::firstOrCreate(['code' => $health_form['code']]);
        }
    }
}
