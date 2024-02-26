<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'email' => 'admin@harvest.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $admin->assignRole('admin');
    }
}
