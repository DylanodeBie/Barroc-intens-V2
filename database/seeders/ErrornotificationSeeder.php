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
        $customers = Customer::whereBetween('id', [1, 10])->get();
        $user = User::find(2);

        if ($customers->isEmpty() || !$user) {
            $this->command->error('Cannot seed error notifications. Make sure customers with IDs between 1 and 10 exist and user with ID 2 exists.');
            return;
        }

        $errorNotifications = [
            [
                'customer_id' => 1,
                'user_id' => $user->id,
                'error_date' => '2024-01-10',
                'status' => 'Pending',
                'title' => 'Network Issue',
                'description' => 'Network connectivity problems reported by customer.'
            ],
            [
                'customer_id' => 1,
                'user_id' => $user->id,
                'error_date' => '2024-02-15',
                'status' => 'Resolved',
                'title' => 'Login Failure',
                'description' => 'Customer unable to log in due to incorrect password reset.'
            ],
            [
                'customer_id' => 3,
                'user_id' => $user->id,
                'error_date' => '2024-03-01',
                'status' => 'In Progress',
                'title' => 'Software Bug',
                'description' => 'Reported issue with software crashing during operation.'
            ],
            [
                'customer_id' => 3,
                'user_id' => $user->id,
                'error_date' => '2024-03-20',
                'status' => 'Pending',
                'title' => 'Hardware Failure',
                'description' => 'Customer reported hardware malfunction in their device.'
            ],
            [
                'customer_id' => 8,
                'user_id' => $user->id,
                'error_date' => '2024-04-05',
                'status' => 'Resolved',
                'title' => 'Data Loss',
                'description' => 'Customer experienced data loss during backup process.'
            ],
            [
                'customer_id' => 7,
                'user_id' => $user->id,
                'error_date' => '2024-05-15',
                'status' => 'In Progress',
                'title' => 'UI Issue',
                'description' => 'User interface is not displaying correctly on customer device.'
            ],
            [
                'customer_id' => 7,
                'user_id' => $user->id,
                'error_date' => '2024-06-10',
                'status' => 'Pending',
                'title' => 'Email Issue',
                'description' => 'Emails are not being delivered to customer inbox.'
            ],
            [
                'customer_id' => 2,
                'user_id' => $user->id,
                'error_date' => '2024-07-01',
                'status' => 'Resolved',
                'title' => 'Database Error',
                'description' => 'Database error occurred while retrieving customer records.'
            ],
            [
                'customer_id' => 9,
                'user_id' => $user->id,
                'error_date' => '2024-08-20',
                'status' => 'Pending',
                'title' => 'Billing Issue',
                'description' => 'Billing discrepancy reported by customer.'
            ],
            [
                'customer_id' => 1,
                'user_id' => $user->id,
                'error_date' => '2024-09-05',
                'status' => 'In Progress',
                'title' => 'System Downtime',
                'description' => 'Unexpected downtime reported by customer affecting service.'
            ],
        ];

        foreach ($errorNotifications as $errorNotification) {
            DB::table('error_notifications')->insert($errorNotification);
        }
    }
}
