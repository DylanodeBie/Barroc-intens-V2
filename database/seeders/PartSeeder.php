<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Part;

class PartSeeder extends Seeder
{
    public function run()
    {
        $parts = [
            ['name' => 'Rubber (10 mm)', 'stock' => 4, 'price' => 0.39],
            ['name' => 'Rubber (14 mm)', 'stock' => 10, 'price' => 0.45],
            ['name' => 'Slang', 'stock' => 10, 'price' => 4.45],
            ['name' => 'Voeding (elektra)', 'stock' => 10, 'price' => 68.69],
            ['name' => 'Ontkalker', 'stock' => 10, 'price' => 4.00],
            ['name' => 'Waterfilter', 'stock' => 10, 'price' => 299.45],
            ['name' => 'Reservoir sensor', 'stock' => 10, 'price' => 89.99],
            ['name' => 'Druppelstop', 'stock' => 10, 'price' => 122.43],
            ['name' => 'Electrische pomp', 'stock' => 10, 'price' => 478.59],
            ['name' => 'Tandwiel 110mm', 'stock' => 10, 'price' => 5.45],
            ['name' => 'Tandwiel 70mm', 'stock' => 10, 'price' => 5.25],
            ['name' => 'Maalmotor', 'stock' => 10, 'price' => 119.20],
            ['name' => 'Zeef', 'stock' => 10, 'price' => 28.80],
            ['name' => 'Reinigingstabletten', 'stock' => 10, 'price' => 3.45],
            ['name' => 'Reiningsborsteltjes', 'stock' => 10, 'price' => 8.45],
            ['name' => 'Ontkalkingspijp', 'stock' => 10, 'price' => 21.70],
        ];

        foreach ($parts as $part) {
            Part::create($part);
        }
    }
}
