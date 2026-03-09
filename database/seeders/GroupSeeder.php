<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
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
            DB::connection('mysql_info')->table('groups')->insert([
                ['name' => 'Cevi Zürich', 'short_name' => 'CZH'],
                ['name' => 'Cevi Bern', 'short_name' => 'CBE'],
            ]);

            return;
        }
        //
        $path = base_path('storage/app/groups.sql');
        DB::connection('mysql_info')->unprepared(file_get_contents($path));
        $this->command->info('Groups table seeded!');
    }
}
