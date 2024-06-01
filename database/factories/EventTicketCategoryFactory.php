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
        return [
            'event_id' => Event::factory(),
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(10, 99) * 1000,
            'ticket_stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
