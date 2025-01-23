<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Part;

class PartSeeder extends Seeder
{
    public function run()
    {
        $parts = [
            ['name' => 'Koffiebonenreservoir', 'stock' => 50, 'price' => 100.50],
            ['name' => 'Waterfilter', 'stock' => 30, 'price' => 25.75],
            ['name' => 'Melkschuimer', 'stock' => 20, 'price' => 35.00],
            ['name' => 'Espresso-pomp', 'stock' => 15, 'price' => 150.00],
            ['name' => 'Verwarmingsplaat', 'stock' => 10, 'price' => 120.00],
            ['name' => 'Koffiemolen', 'stock' => 25, 'price' => 75.00],
            ['name' => 'Lekbak', 'stock' => 40, 'price' => 15.00],
            ['name' => 'Pompafdichting', 'stock' => 5, 'price' => 10.50],
            ['name' => 'Stoompijpje', 'stock' => 35, 'price' => 50.00],
            ['name' => 'Thermostaat', 'stock' => 12, 'price' => 80.00],
        ];

        foreach ($parts as $part) {
            Part::create($part);
        }
    }
}
