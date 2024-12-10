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

        $imageUrl = $faker->imageUrl(640, 480, 'cats', true); 

        DB::table('products')->insert([
            'id' => 1,
            'name' => 'Palmero Pro',
            'brand' => 'Douwe Egberts',
            'description' => 'Dit is de Palmero Pro',
            'stock' => 5,
            'price' => 159.99,
            'image' => $imageUrl, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
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

        DB::table('products')->insert([
            'id' => 2,
            'name' => 'Cafissimo Pure',
            'brand' => 'Douwe Egberts',
            'description' => 'Dit is de Cafissimo Pure',
            'stock' => 3,
            'price' => 199.99,
            'image' => $imageUrl, // Hier wordt een gegenereerde afbeelding gebruikt
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('products')->insert([
            'id' => 3,
            'name' => 'Aulika Top',
            'brand' => 'Nespresso',
            'description' => 'Dit is de Aulika Top',
            'stock' => 1,
            'price' => 249.99,
            'image' => $imageUrl, // Hier wordt een gegenereerde afbeelding gebruikt
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('products')->insert([
            'id' => 4,
            'name' => 'Niagara Plus',
            'brand' => 'Nespresso',
            'description' => 'Dit is de Niagara Plus',
            'stock' => 2,
            'price' => 299.99,
            'image' => $imageUrl, // Hier wordt een gegenereerde afbeelding gebruikt
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('products')->insert([
            'id' => 5,
            'name' => 'Colombia Speciaal',
            'brand' => 'Nespesso',
            'description' => 'Dit is de Colombia Speciaal',
            'stock' => 0,
            'price' => 349.99,
            'image' => $imageUrl, // Hier wordt een gegenereerde afbeelding gebruikt
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
