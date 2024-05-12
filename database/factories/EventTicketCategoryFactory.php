<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventTicketCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventTicketCategory>
 */
class EventTicketCategoryFactory extends Factory
{
    protected $model = EventTicketCategory::class;

    public function definition(): array
    {
        $event = Event::factory()->create();
        $event_id = $event->id;
        return [
            'event_id' => $event_id,
            'name' => fake()->name(),
            'price' => rand(1000, 9999),
            'ticket_stock' => rand(0,100),
        ];
    }
}
