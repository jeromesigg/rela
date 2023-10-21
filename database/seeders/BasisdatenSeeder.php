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


        InterventionClass::firstOrCreate(['id' => config('interventions.monitoring')],
            [
                'name' => 'Patientenüberwachung',
                'short_name' => 'Patientenüberwachung',
                'parameter_name' => 'Symptom',
                'value_name' => 'Wert',
                'file' => '/files/Patientenueberwachung.jpg',
        ]);
        InterventionClass::firstOrCreate(['id' => config('interventions.medication')],
            [
                'name' => 'Verabreichte Medikation',
                'short_name' => 'Medikation',
                'parameter_name' => 'Medikament',
                'value_name' => 'Dosis',
        ]);
        InterventionClass::firstOrCreate(['id' => config('interventions.measure')],
            [
                'name' => '1.Hilfe Leistungen',
                'short_name' => '1.Hilfe Leistungen',
                'parameter_name' => 'Massnahme',
                'value_name' => 'Intervention',
                'with_picture' => true,
        ]);
        InterventionClass::firstOrCreate(['id' => config('interventions.surveillance')],
            [
                'name' => 'Krankheiten des Patienten',
                'short_name' => 'Krankheit',
                'parameter_name' => 'Symptom',
                'value_name' => 'Wert',
        ]);
        InterventionClass::firstOrCreate(['id' => config('interventions.incident')],
            [
                'name' => 'Sicherheitsrelevante Ereignisse',
                'short_name' => 'Sicherheitsrelevante Ereignisse',
                'parameter_name' => 'Geschehen',
                'value_name' => 'Intervention',
        ]);
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
