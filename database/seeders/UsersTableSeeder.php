<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB; // ✅ Add this line

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Step 1: Create 20 Garage Owners
        $garageOwnerIds = [];

        for ($i = 0; $i < 50; $i++) {
            $garageOwner = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'businessname' => $faker->company,
                'countrycode' => $faker->randomElement(['+1', '+44', '+91', '+33', '+49', '+61']),
                'mobilenumber' => $faker->numerify('##########'),
                'taxnumber' => $faker->bothify('TAX-####-####'),
                'address' => $faker->address,
                'country_id' => DB::table('tbl_countries')->inRandomOrder()->value('id'),
                'state_id' => DB::table('tbl_states')->inRandomOrder()->value('id'),
                'city_id' => DB::table('tbl_cities')->inRandomOrder()->value('id'),
                'zip' => $faker->postcode,
                'website' => $faker->url,
                'user_type' => 'Garage Owner',
                'user_status' => $faker->randomElement(['0', '1']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $garageOwnerIds[] = $garageOwner->id;
        }

        // Step 2: Create 80 normal Users and assign garage_owner_id randomly
        for ($i = 0; $i < 200; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'businessname' => $faker->company,
                'countrycode' => $faker->randomElement(['+1', '+44', '+91', '+33', '+49', '+61']),
                'mobilenumber' => $faker->numerify('##########'),
                'taxnumber' => $faker->bothify('TAX-####-####'),
                'address' => $faker->address,
                'country_id' => DB::table('tbl_countries')->inRandomOrder()->value('id'),
                'state_id' => DB::table('tbl_states')->inRandomOrder()->value('id'),
                'city_id' => DB::table('tbl_cities')->inRandomOrder()->value('id'),
                'zip' => $faker->postcode,
                'website' => $faker->url,
                'user_type' => 'User',
                'user_status' => $faker->randomElement(['0', '1']),
                'garage_owner_id' => $faker->randomElement($garageOwnerIds), // 🔁 Assign to a garage owner
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
