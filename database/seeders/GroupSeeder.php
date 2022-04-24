<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //
        $path = base_path('storage/app/groups.sql');
        DB::connection('mysql_info')->unprepared(file_get_contents($path));
        $this->command->info('Groups table seeded!');
    }
}
