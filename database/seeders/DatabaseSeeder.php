<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(ProductSeeder::class);

        // Behoud de oude user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        // Voeg jouw user toe
        User::factory()->create([
            'name' => 'Daan',
            'email' => 'daan.sinke@hotmail.com', // Vervang met je eigen email als je dat wilt
            'password' => bcrypt('BQV-bhw4jnh*qep6qxk'),
            'role_id' => 10,
        ]);
    }
}
