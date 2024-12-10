<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('products')->insert([
            // Machines
            [
                'id' => 1,
                'name' => 'Barroc Intens Italian Light',
                'brand' => 'Barroc Intens',
                'description' => 'S234FREKT - Lease: €499,- p/m excl. btw, Installatie: €289,- excl. btw',
                'stock' => 5,
                'price' => 499.00, // Lease price
                'type' => 'machine',
                'image' => $faker->imageUrl(640, 480, 'coffee', true),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Barroc Intens Italian',
                'brand' => 'Barroc Intens',
                'description' => 'S234KNDPF - Lease: €599,- p/m excl. btw, Installatie: €289,- excl. btw',
                'stock' => 3,
                'price' => 599.00,
                'type' => 'machine',
                'image' => $faker->imageUrl(640, 480, 'coffee', true),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Barroc Intens Italian Deluxe',
                'brand' => 'Barroc Intens',
                'description' => 'S234NNBMV - Lease: €799,- p/m excl. btw, Installatie: €375,- excl. btw',
                'stock' => 1,
                'price' => 799.00,
                'type' => 'machine',
                'image' => $faker->imageUrl(640, 480, 'coffee', true),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Barroc Intens Italian Deluxe Special',
                'brand' => 'Barroc Intens',
                'description' => 'S234MMPLA - Lease: €999,- p/m excl. btw, Installatie: €375,- excl. btw',
                'stock' => 2,
                'price' => 999.00,
                'type' => 'machine',
                'image' => $faker->imageUrl(640, 480, 'coffee', true),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Coffee Beans
            [
                'id' => 5,
                'name' => 'Espresso Beneficio',
                'brand' => 'Barroc Intens',
                'description' => 'S239KLIUP - Zachte koffie van de Finca El Limoncillo in Nicaragua.',
                'stock' => 100,
                'price' => 21.60,
                'type' => 'coffee_bean',
                'image' => $faker->imageUrl(640, 480, 'coffee', true),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Yellow Bourbon Brasil',
                'brand' => 'Barroc Intens',
                'description' => 'S239MNKLL - Zeldzame koffie met gele koffiebessen van de Bourbon koffiestruik.',
                'stock' => 50,
                'price' => 23.20,
                'type' => 'coffee_bean',
                'image' => $faker->imageUrl(640, 480, 'coffee', true),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Espresso Roma',
                'brand' => 'Barroc Intens',
                'description' => 'S239IPPSD - Italiaanse espresso met een krachtig karakter en aromatische afdronk.',
                'stock' => 80,
                'price' => 20.80,
                'type' => 'coffee_bean',
                'image' => $faker->imageUrl(640, 480, 'coffee', true),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Red Honey Honduras',
                'brand' => 'Barroc Intens',
                'description' => 'S239EVVFS - Honey-methode voor een zoete fruitsmaak.',
                'stock' => 30,
                'price' => 27.80,
                'type' => 'coffee_bean',
                'image' => $faker->imageUrl(640, 480, 'coffee', true),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
