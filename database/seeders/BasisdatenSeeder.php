<?php

namespace Database\Seeders;

use App\Models\Allergy;
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

        InterventionClass::create([
            'id' => config('interventions.monitoring'),
            'name' => 'Patientenüberwachung',
            'short_name' => 'Patientenüberwachung',
            'parameter_name' => 'Symptom',
            'value_name' => 'Wert',
        ]);
        InterventionClass::create([
            'id' => config('interventions.medication'),
            'name' => 'Verabreichte Medikation',
            'short_name' => 'Medikation',
            'parameter_name' => 'Medikament',
            'value_name' => 'Dosis',
        ]);
        InterventionClass::create([
            'id' => config('interventions.measure'),
            'name' => 'Durchgeführte Massnahmen',
            'short_name' => 'Massnahme',
            'parameter_name' => 'Massnahme',
        ]);
        InterventionClass::create([
            'id' => config('interventions.surveillance'),
            'name' => 'Zustand des Patienten',
            'short_name' => 'Zustand',
            'parameter_name' => 'Messwert',
            'value_name' => 'Wert',
        ]);
        InterventionClass::create([
            'id' => config('interventions.healthstatus'),
            'name' => 'Überwachung der Vitalfunktionen',
            'short_name' => 'Überwachung',
            'parameter_name' => 'Symptom',
            'value_name' => 'Wert',
        ]);
        InterventionClass::create([
            'id' => config('interventions.incident'),
            'name' => 'Allgemeine Geschehnisse',
            'short_name' => 'Geschehen',
            'parameter_name' => 'Geschehen',
        ]);
    }
}
