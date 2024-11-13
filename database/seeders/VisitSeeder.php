<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visit;
use App\Models\User;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(2);

        if (!$user) {
            $this->command->error('Cannot seed visits. Make sure user with ID 2 exists.');
            return;
        }

        // Seed 5 visits using specific error notifications and user ID 2
        $visits = [
            [
                'customer_id' => 1,
                'user_id' => $user->id,
                'error_notification_id' => 1,
                'visit_date' => '2024-02-20',
                'error_details' => 'Machine not heating properly.',
                'address' => '123 Main St, Coffeeville',
                'used_parts' => 'Heating element, Thermostat',
            ],
            [
                'customer_id' => 1,
                'user_id' => $user->id,
                'error_notification_id' => 2,
                'visit_date' => '2024-03-10',
                'error_details' => 'Water leakage detected.',
                'address' => '456 Elm St, Coffeeville',
                'used_parts' => 'Water hose, Sealant',
            ],
            [
                'customer_id' => 3,
                'user_id' => $user->id,
                'error_notification_id' => 3,
                'visit_date' => '2024-04-05',
                'error_details' => 'Grinder malfunctioning.',
                'address' => '789 Oak St, Coffeeville',
                'used_parts' => 'Grinder blades, Motor',
            ],
            [
                'customer_id' => 3,
                'user_id' => $user->id,
                'error_notification_id' => 4,
                'visit_date' => '2024-05-25',
                'error_details' => 'Display panel not working.',
                'address' => '101 Maple St, Coffeeville',
                'used_parts' => 'Display unit, Wiring harness',
            ],
            [
                'customer_id' => 8,
                'user_id' => $user->id,
                'error_notification_id' => 5,
                'visit_date' => '2024-06-15',
                'error_details' => 'Pump making noise.',
                'address' => '202 Birch St, Coffeeville',
                'used_parts' => 'Pump, Noise dampeners',
            ],
        ];

        foreach ($visits as $visit) {
            Visit::create($visit);
        }
    }
}
