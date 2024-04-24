<?php

namespace Database\Factories;

use App\Models\Talent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Talent>
 */
class TalentFactory extends Factory
{
    protected $model = Talent::class;

    public function definition(): array
    {
        return [
            'stage_name' => fake()->name(),
            'real_name' => fake()->name(),
            'image_url' => fake()->imageUrl()
        ];
    }
}
