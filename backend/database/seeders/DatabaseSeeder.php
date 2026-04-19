<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySubcategorySeeder::class,
            ProductSeeder::class,
            DirectoryImageSeeder::class,
            ExternalProductSeeder::class,
            OrderCartSeeder::class,
        ]);
    }
}
