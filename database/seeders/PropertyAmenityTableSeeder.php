<?php

namespace Database\Seeders;

use App\Models\PropertyAmenity;
use Illuminate\Database\Seeder;

class PropertyAmenityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyAmenity::factory()->count(5)->create();
    }
}
