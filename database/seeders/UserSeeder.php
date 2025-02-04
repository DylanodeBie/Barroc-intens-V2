<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Behoud de oude user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        // Voeg jouw user toe
        User::factory()->create([
            'name' => 'Laurens',
            'email' => 'laurens_vt@icloud.com',
            'password' => bcrypt('bamba009'),
            'role_id' => 10,
        ]);

         // Voeg jouw user toe
        User::factory()->create([
            'name' => 'Daan',
            'email' => 'daan.sinke@hotmail.com',
            'password' => bcrypt('BQV-bhw4jnh*qep6qxk'),
            'role_id' => 10,
        ]);

        // Voeg jouw user toe
        User::factory()->create([
            'name' => 'Dylano',
            'email' => 'dqdebie@gmail.com',
            'password' => 'test12345',
            'role_id' => 10,
        ]);

        // Create users based on the organizational chart
        User::factory()->create([
            'name' => 'Joris Pulles',
            'email' => 'joris.pulles@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 10, // CEO
        ]);

        User::factory()->create([
            'name' => 'Maarten Pulles',
            'email' => 'maarten.pulles@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 7, // Head Sales
        ]);

        User::factory()->create([
            'name' => 'John Vrees',
            'email' => 'john.vrees@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 8, // Head Inkoop
        ]);

        User::factory()->create([
            'name' => 'Simon Nagelborcke',
            'email' => 'simon.nagelborcke@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 9, // Head Maintenance
        ]);

        User::factory()->create([
            'name' => 'Ingeborg van Lier',
            'email' => 'ingeborg.vanlier@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 2, // Finance role
        ]);

        User::factory()->create([
            'name' => 'Ashley van de Sluis',
            'email' => 'ashley.vandesluis@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 2, // Finance role
        ]);

        User::factory()->create([
            'name' => 'Guillaume de Randamie',
            'email' => 'guillaume.derandamie@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 3, // Consultant
        ]);

        User::factory()->create([
            'name' => 'Annemie Meijard',
            'email' => 'annemie.meijard@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 3, // Consultant
        ]);

        User::factory()->create([
            'name' => 'Evelien Rosse',
            'email' => 'evelien.rosse@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 6, // Inkoop
        ]);

        User::factory()->create([
            'name' => 'Max Rosendorp',
            'email' => 'max.rosendorp@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 6, // Medewerker Magazijn
        ]);

        User::factory()->create([
            'name' => 'Muhammad Demir',
            'email' => 'muhammad.demir@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, // Technische Dienst
        ]);

        User::factory()->create([
            'name' => 'Paul Machielsen',
            'email' => 'paul.machielsen@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, // Technische Dienst
        ]);

        User::factory()->create([
            'name' => 'Cindy Paxier',
            'email' => 'cindy.paxier@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, // Technische Dienst
        ]);

        User::factory()->create([
            'name' => 'Piotr Loszarowski',
            'email' => 'piotr.loszarowski@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, // Technische Dienst
        ]);

        User::factory()->create([
            'name' => 'Jimmy Choi',
            'email' => 'jimmy.choi@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, // Planner
        ]);
    }
}
