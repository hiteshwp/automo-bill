<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['id' => 1, 'name' => 'United States', 'code' => 'US', 'phonecode'=>'1'],
            ['id' => 2, 'name' => 'Canada', 'code' => 'CA', 'phonecode'=>'1'],
            ['id' => 3, 'name' => 'United Kingdom', 'code' => 'GB', 'phonecode'=>'44'],
            ['id' => 4, 'name' => 'Australia', 'code' => 'AU', 'phonecode'=>'61'],
        ];

        DB::table('tbl_countries')->insert($countries);
    }
}
