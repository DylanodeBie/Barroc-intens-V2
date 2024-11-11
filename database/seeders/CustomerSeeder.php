<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Maak een nieuwe instance van de Faker library voor het genereren van dummy data
        $faker = Faker::create();

        // Creëer bijvoorbeeld 10 klanten in de database
        for ($i = 0; $i < 10; $i++) {
            DB::table('customers')->insert([
                'company_name' => $faker->company,
                'contact_person' => $faker->name,
                'phonenumber' => $faker->phoneNumber,
                'address' => $faker->address,
                'email' => $faker->email,
                'bkr_check' => $faker->boolean, // Genereren van een willekeurige true/false waarde
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
