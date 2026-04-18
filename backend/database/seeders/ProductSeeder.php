<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert([
            [
                'name' => 'Classic Blue T-Shirt',
                'description' => 'A comfortable and stylish slim-fit blue t-shirt made of 100% cotton.',
                'price' => 24.99,
                'category_id' => 1,
                'subcategory_id' => 1,
                'location' => 'Main Warehouse',
                'information' => 'Machine wash cold. Tumble dry low.',
                'size' => 'M, L, XL',
                'color' => 'Navy Blue',
                'quantity' => 150,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                // Using an Unsplash placeholder image that visually fits the product
                'product_image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Leather Moto Jacket',
                'description' => 'Premium genuine leather jacket with silver zip details and quilted shoulders.',
                'price' => 199.50,
                'category_id' => 2,
                'subcategory_id' => 3,
                'location' => 'Store Front',
                'information' => 'Dry clean only. 100% Leather exterior.',
                'size' => 'S, M, L',
                'color' => 'Black',
                'quantity' => 30,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 0,
                'product_image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Running Sneakers',
                'description' => 'Lightweight athletic sneakers featuring breathable mesh and comfortable sole padding.',
                'price' => 89.99,
                'category_id' => 3,
                'subcategory_id' => 5,
                'location' => 'Main Warehouse',
                'information' => 'Wipe clean with a damp cloth.',
                'size' => '8, 9, 10, 11',
                'color' => 'White/Grey',
                'quantity' => 85,
                'Supercategory_id' => 2,
                'availability' => 1,
                'trandy' => 0,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
