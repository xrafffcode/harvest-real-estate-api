<?php

namespace Database\Seeders;

use App\Models\WebConfiguration;
use Illuminate\Database\Seeder;

class WebConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebConfiguration::factory()->count(1)->create();
    }
}
