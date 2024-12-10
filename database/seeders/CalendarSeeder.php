<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'user_id' => 2,
                'customer_id' => rand(1, 10),
                'title' => 'Team Meeting',
                'start' => Carbon::now()->addDays(1)->format('Y-m-d H:i:s'),
                'end' => Carbon::now()->addDays(1)->addHours(1)->format('Y-m-d H:i:s'),
                'description' => 'Monthly team meeting to discuss project updates.',
            ],
            [
                'user_id' => 2,
                'customer_id' => rand(1, 10),
                'title' => 'Project Deadline',
                'start' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s'),
                'end' => Carbon::now()->addDays(5)->addHours(2)->format('Y-m-d H:i:s'),
                'description' => 'Final deadline for submitting the project.',
            ],
            [
                'user_id' => 2,
                'customer_id' => rand(1, 10),
                'title' => 'Client Presentation',
                'start' => Carbon::now()->addWeeks(1)->format('Y-m-d H:i:s'),
                'end' => Carbon::now()->addWeeks(1)->addHours(2)->format('Y-m-d H:i:s'),
                'description' => 'Presentation to showcase progress to the client.',
            ],
            [
                'user_id' => 2,
                'customer_id' => rand(1, 10),
                'title' => 'Workshop',
                'start' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
                'end' => Carbon::now()->addDays(10)->addHours(4)->format('Y-m-d H:i:s'),
                'description' => 'Technical workshop on new tools and technologies.',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}