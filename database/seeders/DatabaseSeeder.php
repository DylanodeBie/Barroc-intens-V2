<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MachineSeeder;

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
        MachineSeeder::class,
        UserSeeder::class,
        CustomerSeeder::class,
        ErrornotificationSeeder::class,
        VisitSeeder::class,
        QuoteSeeder::class,
        InvoiceSeeder::class,
    ]);
}
}
