<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ProductSeeder::class,
            UserSeeder::class, // Users must be seeded before dependent seeders
            CustomerSeeder::class,
            ErrornotificationSeeder::class,
            VisitSeeder::class,
        ]);
    }
}
