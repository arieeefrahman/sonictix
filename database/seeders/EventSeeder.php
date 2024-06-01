<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventTicketCategory;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::factory()
            ->count(20)
            ->create()
            ->each(function ($event) {
                EventTicketCategory::factory()
                    ->count(3)
                    ->create(['event_id' => $event->id]);
        });
    }
}
