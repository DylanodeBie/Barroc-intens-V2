<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineSeeder extends Seeder
{
    public function run()
    {
        DB::table('machines')->insert([
            [
                'name' => 'Barroc Intens Italian Light',
                'code' => 'S234FREKT',
                'lease_price' => 499.00,
                'installation_cost' => 289.00,
                'image' => 'img/machine-bit-light.png', // Use the light image for this machine
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barroc Intens Italian',
                'code' => 'S234KNDPF',
                'lease_price' => 599.00,
                'installation_cost' => 289.00,
                'image' => 'img/machine-bit-light.png', // Use the same light image
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barroc Intens Italian Deluxe',
                'code' => 'S234NNBMV',
                'lease_price' => 799.00,
                'installation_cost' => 375.00,
                'image' => 'img/machine-bit-deluxe.png', // Use the deluxe image
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barroc Intens Italian Deluxe Special',
                'code' => 'S234MMPLA',
                'lease_price' => 999.00,
                'installation_cost' => 375.00,
                'image' => 'img/machine-bit-deluxe.png', // Use the deluxe image
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
