<?php

namespace Database\Seeders;

use App\Models\Observation;
use Illuminate\Database\Seeder;
use Faker\Factory;

class ObservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Observation::factory()->count(100)->create();
    }
}
