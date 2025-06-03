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

        $countryMap = [
            'us' => '1',
            'in' => '91',
            'ca' => '1',
            'au' => '61',
            'nz' => '64',
        ];

        for ($i = 0; $i < 50; $i++) {

            $countryIsoCode = $faker->randomElement(array_keys($countryMap));
            $countryCode = $countryMap[$countryIsoCode];

            $garageOwner = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('User@123'),
                'businessname' => $faker->company,
                'countryisocode' => $countryIsoCode,
                'countrycode' => $countryCode,
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

            $countryIsoCode = $faker->randomElement(array_keys($countryMap));
            $countryCode = $countryMap[$countryIsoCode];

            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'businessname' => $faker->company,
                'countryisocode' => $countryIsoCode,
                'countrycode' => $countryCode,
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
