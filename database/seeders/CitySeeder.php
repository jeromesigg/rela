<?php

namespace Database\Seeders;

use Eloquent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $path = base_path('storage/app/cities.sql');
        DB::connection('mysql_info')->unprepared(file_get_contents($path));
        $this->command->info('City table seeded!');
    }
}
