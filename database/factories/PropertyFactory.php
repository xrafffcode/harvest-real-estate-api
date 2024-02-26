<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'description' => fake()->sentence(),
            'loc_city' => fake()->city(),
            'loc_latitude' => fake()->latitude(),
            'loc_longitude' => fake()->longitude(),
            'loc_address' => fake()->address(),
            'loc_state' => fake()->state(),
            'loc_zip' => fake()->postcode(),
            'loc_country' => fake()->country(),
            'price' => fake()->numberBetween(1, 100000000),
        ];
    }
}
