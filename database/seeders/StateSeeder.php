<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'California', 'country_id' => 1],
            ['name' => 'Texas', 'country_id' => 1],
            ['name' => 'Ontario', 'country_id' => 2],
            ['name' => 'Quebec', 'country_id' => 2],
            ['name' => 'New South Wales', 'country_id' => 4],
            ['name' => 'Victoria', 'country_id' => 4],
        ];

        DB::table('tbl_states')->insert($states);
    }
}
