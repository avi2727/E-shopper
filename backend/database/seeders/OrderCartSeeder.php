<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderCartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample Cart Items for John Doe (User ID 2)
        $products = DB::table('product')->limit(2)->get();
        
        if ($products->count() > 0) {
            foreach ($products as $product) {
                DB::table('cart')->insert([
                    'user_id' => 2,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // Sample Order for Jane Smith (User ID 3)
        if ($products->count() > 0) {
            $product = $products->first();
            DB::table('orders')->insert([
                'orderId' => 'ORD-' . strtoupper(Str::random(8)),
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'contact' => '1234567890',
                'address1' => '123 Main St',
                'address2' => 'Apt 4B',
                'country' => 'USA',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10001',
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'product_quantity' => 1,
                'product_subtotal' => $product->price,
                'payment' => 'Credit Card',
                'userid' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
