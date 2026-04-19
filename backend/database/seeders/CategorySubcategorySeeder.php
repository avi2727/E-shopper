<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => 1, 'name' => 'Men'],
            ['id' => 2, 'name' => 'Women'],
            ['id' => 3, 'name' => 'Baby'],
            ['id' => 4, 'name' => 'Accessories'],
            ['id' => 5, 'name' => 'Bags'],
            ['id' => 6, 'name' => 'Shoes'],
        ];

        foreach ($categories as $category) {
            DB::table('category')->updateOrInsert(
                ['id' => $category['id']],
                [
                    'name' => $category['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

        $subcategories = [
            ['id' => 1, 'name' => 'T-Shirts'],
            ['id' => 2, 'name' => 'Jeans'],
            ['id' => 3, 'name' => 'Jackets'],
            ['id' => 4, 'name' => 'Dresses'],
            ['id' => 5, 'name' => 'Shoes'],
            ['id' => 6, 'name' => 'Shirts'],
        ];

        foreach ($subcategories as $subcat) {
            DB::table('subcategory')->updateOrInsert(
                ['id' => $subcat['id']],
                [
                    'name' => $subcat['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
