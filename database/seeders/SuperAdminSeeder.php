<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'businessname' => 'Admin Business',
            'countrycode' => '1',
            'mobilenumber' => '1234567890',
            'email' => 'admin@automo-bill.com',
            'password' => Hash::make('Admin@123'), // Securely hash password
            'taxnumber' => 'TAX123456',
            'address' => '123 Admin Street',
            'country_id' => 1, // Adjust based on your tbl_countries
            'state_id' => 1,   // Adjust based on your tbl_states
            'city_id' => 1,    // Adjust based on your tbl_cities
            'zip' => '12345',
            'website' => 'https://admin-website.com',
            'user_type' => 'Super Admin', // Ensure this matches your role system
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
