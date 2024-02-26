<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyCategory>
 */
class PropertyCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $property_categories = [
            'Apartment',
            'House',
            'Land',
            'Commercial',
            'Garage',
        ];

        return [
            'name' => $property_categories[array_rand($property_categories)],
            'icon' => $this->faker->word,
            'slug' => $this->faker->slug,
        ];
    }
}
