<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
            'specialization' => $this->faker->text(),
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'facebook' => $this->faker->url(),
            'twitter' => $this->faker->url(),
            'instagram' => $this->faker->url(),
            'linkedin' => $this->faker->url(),
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            'slug' => $this->faker->slug(),
        ];
    }
}
