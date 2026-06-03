<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('testing')) {
            // Nur ein paar Test-Städte
            DB::connection('mysql_info')->table('cities')->insert([
                ['name' => 'Bern', 'plz' => '3000'],
                ['name' => 'Zürich', 'plz' => '8000'],
            ]);

            return;
        }

        $path = base_path('storage/app/cities.sql');
        DB::connection('mysql_info')->unprepared(file_get_contents($path));
        $this->command->info('City table seeded!');
    }
}
