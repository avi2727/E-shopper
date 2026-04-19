<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@eshopper.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'isloggedin' => 0,
            ]
        );

        // Test Customer 1
        User::updateOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'isloggedin' => 0,
            ]
        );

        // Test Customer 2
        User::updateOrCreate(
            ['email' => 'jane@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password'),
                'isloggedin' => 0,
            ]
        );
    }
}
