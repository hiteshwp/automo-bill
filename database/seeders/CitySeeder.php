<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Los Angeles', 'state_id' => 1],
            ['name' => 'San Francisco', 'state_id' => 1],
            ['name' => 'Houston', 'state_id' => 2],
            ['name' => 'Toronto', 'state_id' => 3],
            ['name' => 'Montreal', 'state_id' => 4],
            ['name' => 'Sydney', 'state_id' => 5],
        ];

        DB::table('tbl_cities')->insert($cities);
    }
}
