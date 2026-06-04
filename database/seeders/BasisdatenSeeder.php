<?php

namespace Database\Seeders;

use App\Models\HealthStatus;
use Illuminate\Database\Seeder;

class BasisdatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        HealthStatus::firstOrCreate(['id' => config('status.health_green')],
            [
                'name' => 'Grün',
            ]);
        HealthStatus::firstOrCreate(['id' => config('status.health_yellow')],
            [
                'name' => 'Gelb',
            ]);
        HealthStatus::firstOrCreate(['id' => config('status.health_red')],
            [
                'name' => 'Rot',
            ]);
    }
}
