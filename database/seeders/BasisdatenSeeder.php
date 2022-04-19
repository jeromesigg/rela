<?php

namespace Database\Seeders;

use App\Models\Allergy;
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
        User::create( [
            'id' => 1,
            'name' => 'Administrator',
            'email' => 'Admin@Cevi',
            'slug' => 'Administrator',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'is_Admin' => true,
            'is_Manager' => false,
            'is_Helper' => false,
            'email_verified_at' => now(),
        ]);


        Allergy::create(['name' => 'Heuschnupfen']);
        Allergy::create(['name' => 'Bienen- / Wespenstiche']);
        Allergy::create(['name' => 'Asthma bei / nach']);
        Allergy::create(['name' => 'Lebensmittel']);
        Allergy::create(['name' => 'Medikament (Wirkstoff)']);
        Allergy::create(['name' => 'Andere']);
    }
}
