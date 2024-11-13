<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\User;

class ErrornotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get customers between ID 20 and 30 and limit users to ID 2
        $customers = Customer::whereBetween('id', [1, 10])->get();
        $user = User::find(2);

        if ($customers->isEmpty() || !$user) {
            $this->command->error('Cannot seed error notifications. Make sure customers with IDs between 20 and 30 exist and users with ID 2 exist.');
            return;
        }

        // Seed 10 error notifications with specific customer and user IDs
        $errorNotifications = [
            [
                'customer_id' => 1,
                'user_id' => $user->id,
                'error_date' => '2024-01-10',
                'status' => 'Pending',
            ],
            [
                'customer_id' => 1,
                'user_id' => $user->id,
                'error_date' => '2024-02-15',
                'status' => 'Resolved',
            ],
            [
                'customer_id' => 3,
                'user_id' => $user->id,
                'error_date' => '2024-03-01',
                'status' => 'In Progress',
            ],
            [
                'customer_id' => 3,
                'user_id' => $user->id,
                'error_date' => '2024-03-20',
                'status' => 'Pending',
            ],
            [
                'customer_id' => 8,
                'user_id' => $user->id,
                'error_date' => '2024-04-05',
                'status' => 'Resolved',
            ],
            [
                'customer_id' => 7,
                'user_id' => $user->id,
                'error_date' => '2024-05-15',
                'status' => 'In Progress',
            ],
            [
                'customer_id' => 7,
                'user_id' => $user->id,
                'error_date' => '2024-06-10',
                'status' => 'Pending',
            ],
            [
                'customer_id' => 2,
                'user_id' => $user->id,
                'error_date' => '2024-07-01',
                'status' => 'Resolved',
            ],
            [
                'customer_id' => 9,
                'user_id' => $user->id,
                'error_date' => '2024-08-20',
                'status' => 'Pending',
            ],
            [
                'customer_id' => 1,
                'user_id' => $user->id,
                'error_date' => '2024-09-05',
                'status' => 'In Progress',
            ],
        ];

        foreach ($errorNotifications as $errorNotification) {
            DB::table('error_notifications')->insert($errorNotification);
        }
    }
}
