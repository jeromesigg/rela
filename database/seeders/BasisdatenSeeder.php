<?php

namespace Database\Seeders;

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


        InterventionClass::create([
            'id' => config('interventions.monitoring'),
            'name' => 'Patientenüberwachung',
            'short_name' => 'Patientenüberwachung',
            'parameter_name' => 'Symptom',
            'value_name' => 'Wert',
            'file' => '/files/Patientenueberwachung.jpg',
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
            'name' => '1.Hilfe Leistungen',
            'short_name' => '1.Hilfe Leistungen',
            'parameter_name' => 'Massnahme',
            'value_name' => 'Intervention',
            'with_picture' => true,
        ]);
        InterventionClass::create([
            'id' => config('interventions.surveillance'),
            'name' => 'Krankheiten des Patienten',
            'short_name' => 'Krankheit',
            'parameter_name' => 'Symptom',
            'value_name' => 'Wert',
        ]);
        InterventionClass::create([
            'id' => config('interventions.incident'),
            'name' => 'Sicherheitsrelevante Ereignisse',
            'short_name' => 'Sicherheitsrelevante Ereignisse',
            'parameter_name' => 'Geschehen',
            'value_name' => 'Intervention',
        ]);
    }
}
