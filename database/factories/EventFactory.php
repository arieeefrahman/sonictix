<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;
    
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween(now()->addMonth(), now()->addMonths(2));
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->modify('+1 week'));

        $googleMapsUrlFormat = $this->faker->randomElement([
            'https://maps.app.goo.gl/',
            'https://www.google.com/maps/test',
        ]);
    

        return [
            'title' => $this->faker->sentence(3, true),
            'description' => $this->faker->paragraph(2),
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'end_date' => $endDate->format('Y-m-d H:i:s'),
            'created_by' => $this->faker->name(),
            'location' => $this->faker->city(),
            'google_maps_url' => $googleMapsUrlFormat,
        ];
    }
}
