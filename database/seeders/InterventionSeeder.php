<?php

namespace Database\Seeders;

use App\Models\Intervention;
use Illuminate\Database\Seeder;
use Faker\Factory;

class InterventionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Intervention::factory()->count(1000)->create();
    }
}
