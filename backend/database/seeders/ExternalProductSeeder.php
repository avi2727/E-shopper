<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExternalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            // ACCESSORIES (Category ID 4 - as per HTML)
            [
                'name' => 'Minimalist Watch',
                'description' => 'Sleek and thin watch with a leather strap.',
                'price' => 110.00,
                'category_id' => 4,
                'subcategory_id' => 1,
                'location' => 'Main Warehouse',
                'information' => 'Quartz movement. Sapphire glass.',
                'size' => '40mm',
                'color' => 'Silver/Black',
                'quantity' => 60,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Classic Aviator Sunglasses',
                'description' => 'Timeless aviator shades with UV protection.',
                'price' => 85.00,
                'category_id' => 4,
                'subcategory_id' => 1,
                'location' => 'Main Warehouse',
                'information' => 'Polarized lenses. Metal frame.',
                'size' => 'Medium',
                'color' => 'Gold/Green',
                'quantity' => 120,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Leather Bifold Wallet',
                'description' => 'Simple and functional leather wallet.',
                'price' => 35.00,
                'category_id' => 4,
                'subcategory_id' => 1,
                'location' => 'Main Warehouse',
                'information' => 'Top grain leather. RFID blocking.',
                'size' => 'Small',
                'color' => 'Tan',
                'quantity' => 200,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // BAGS (Category ID 5)
            [
                'name' => 'Urban Commuter Backpack',
                'description' => 'Water-resistant backpack with laptop compartment.',
                'price' => 59.99,
                'category_id' => 5,
                'subcategory_id' => 3,
                'location' => 'Main Warehouse',
                'information' => 'Fits 15-inch laptop. Multiple pockets.',
                'size' => 'One Size',
                'color' => 'Gray',
                'quantity' => 80,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Luxury Leather Handbag',
                'description' => 'Exquisite leather handbag for formal occasions.',
                'price' => 299.00,
                'category_id' => 5,
                'subcategory_id' => 4,
                'location' => 'Premium Section',
                'information' => 'Genuine calf leather. Gold hardware.',
                'size' => 'Medium',
                'color' => 'Black',
                'quantity' => 15,
                'Supercategory_id' => 2,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Canvas Travel Duffel',
                'description' => 'Durable canvas bag for weekend getaways.',
                'price' => 45.00,
                'category_id' => 5,
                'subcategory_id' => 3,
                'location' => 'Main Warehouse',
                'information' => 'Heavy-duty canvas. Leather trim.',
                'size' => 'Large',
                'color' => 'Olive Green',
                'quantity' => 40,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // SHOES (Category ID 6 - as per HTML)
            [
                'name' => 'Classic Leather Sneakers',
                'description' => 'Versatile and comfortable leather sneakers perfect for everyday wear.',
                'price' => 79.99,
                'category_id' => 6,
                'subcategory_id' => 5,
                'location' => 'Main Warehouse',
                'information' => 'Hand-stitched leather. Rubber sole.',
                'size' => '8, 9, 10, 11',
                'color' => 'White',
                'quantity' => 100,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Running Performance Shoes',
                'description' => 'High-performance running shoes with superior cushioning.',
                'price' => 120.00,
                'category_id' => 6,
                'subcategory_id' => 5,
                'location' => 'Main Warehouse',
                'information' => 'Breathable mesh. Lightweight design.',
                'size' => '7, 8, 9, 10, 11, 12',
                'color' => 'Blue/Orange',
                'quantity' => 50,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Elegant Suede Boots',
                'description' => 'Premium suede boots for a sophisticated look.',
                'price' => 150.00,
                'category_id' => 6,
                'subcategory_id' => 5,
                'location' => 'Store Front',
                'information' => '100% Suede. Italian design.',
                'size' => '9, 10, 11',
                'color' => 'Brown',
                'quantity' => 25,
                'Supercategory_id' => 1,
                'availability' => 1,
                'trandy' => 1,
                'justArrived' => 1,
                'product_image' => 'https://images.unsplash.com/photo-1520639889410-d02030f40d6c?auto=format&fit=crop&w=800&q=80',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($products as $product) {
            DB::table('product')->updateOrInsert(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
