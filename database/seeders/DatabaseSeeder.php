<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            WebConfigurationTableSeeder::class,
            PropertyAmenityTableSeeder::class,
            PropertyCategoryTableSeeder::class,
            PropertyTypeTableSeeder::class,
            AgentTableSeeder::class,
            // PropertyTableSeeder::class,
            // TestimonialTableSeeder::class,
        ]);
    }
}
