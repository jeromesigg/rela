<?php

namespace Database\Seeders;

use App\Models\HealthStatus;
use App\Models\InterventionClass;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
