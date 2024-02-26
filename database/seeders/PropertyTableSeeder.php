<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Models\PropertyCategory;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $seedCount = 5;
        for ($i = 0; $i < $seedCount; $i++) {
            $amenity = PropertyAmenity::inRandomOrder()->first();
            $category = PropertyCategory::inRandomOrder()->first();
            $type = PropertyType::inRandomOrder()->first();
            $agent = Agent::inRandomOrder()->first();

            $property = Property::factory()
                ->for($agent)
                ->hasAttached($amenity)
                ->hasAttached($category)
                ->hasAttached($type);

            $property = $property->create();
        }

    }
}
