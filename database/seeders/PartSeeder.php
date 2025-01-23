<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Part;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parts = [
            ['name' => 'Koffiebonenreservoir', 'stock' => 50],
            ['name' => 'Waterfilter', 'stock' => 30],
            ['name' => 'Melkschuimer', 'stock' => 20],
            ['name' => 'Espresso-pomp', 'stock' => 15],
            ['name' => 'Verwarmingsplaat', 'stock' => 10],
            ['name' => 'Koffiemolen', 'stock' => 25],
            ['name' => 'Lekbak', 'stock' => 40],
            ['name' => 'Pompafdichting', 'stock' => 5],
            ['name' => 'Stoompijpje', 'stock' => 35],
            ['name' => 'Thermostaat', 'stock' => 12],
        ];

        foreach ($parts as $part) {
            Part::create($part);
        }
    }
}
