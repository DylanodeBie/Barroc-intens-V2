<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Geen Rol', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Finance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Sales', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Inkoop', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Maintenance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Hoofd Finance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Hoofd Sales', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Hoofd Inkoop', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Hoofd Maintenance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'CEO', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}