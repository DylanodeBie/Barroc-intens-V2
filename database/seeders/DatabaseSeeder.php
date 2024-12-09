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
        $this->call(RoleSeeder::class);
        $this->call(ProductSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Dylano',
            'email' => 'dqdebie@gmail.com',
            'password' => 'test12345',
            'role_id' => 10,
        ]);

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@test.nl',
            'password' => 'test12345',
            'role_id' => 10,
        ]);

        User::factory()->create([
            'name' => 'Daan',
            'email' => 'daan.sinke@hotmail.com',
            'password' => bcrypt('BQV-bhw4jnh*qep6qxk'),
            'role_id' => 10,
        ]);

        User::factory()->create([
            'name' => 'Joris Pulles',
            'email' => 'joris.pulles@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 10, 
        ]);

        User::factory()->create([
            'name' => 'Maarten Pulles',
            'email' => 'maarten.pulles@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 7,
        ]);

        User::factory()->create([
            'name' => 'John Vrees',
            'email' => 'john.vrees@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 8,
        ]);

        User::factory()->create([
            'name' => 'Simon Nagelborcke',
            'email' => 'simon.nagelborcke@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 9,
        ]);

        User::factory()->create([
            'name' => 'Ingeborg van Lier',
            'email' => 'ingeborg.vanlier@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 2, 
        ]);

        User::factory()->create([
            'name' => 'Ashley van de Sluis',
            'email' => 'ashley.vandesluis@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 2, 
        ]);

        User::factory()->create([
            'name' => 'Guillaume de Randamie',
            'email' => 'guillaume.derandamie@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 3, 
        ]);

        User::factory()->create([
            'name' => 'Annemie Meijard',
            'email' => 'annemie.meijard@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 3, 
        ]);

        User::factory()->create([
            'name' => 'Evelien Rosse',
            'email' => 'evelien.rosse@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 6, 
        ]);

        User::factory()->create([
            'name' => 'Max Rosendorp',
            'email' => 'max.rosendorp@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 6, 
        ]);

        User::factory()->create([
            'name' => 'Muhammad Demir',
            'email' => 'muhammad.demir@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, 
        ]);

        User::factory()->create([
            'name' => 'Paul Machielsen',
            'email' => 'paul.machielsen@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, 
        ]);

        User::factory()->create([
            'name' => 'Cindy Paxier',
            'email' => 'cindy.paxier@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, 
        ]);

        User::factory()->create([
            'name' => 'Piotr Loszarowski',
            'email' => 'piotr.loszarowski@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, 
        ]);

        User::factory()->create([
            'name' => 'Jimmy Choi',
            'email' => 'jimmy.choi@barrocintens.com',
            'password' => bcrypt('password'),
            'role_id' => 5, 
        ]);
    }
}
