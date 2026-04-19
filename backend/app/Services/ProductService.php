<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Handle product creation logic, including image upload.
     */
    public function createProduct(array $data, $image = null)
    {
        if ($image) {
            $data['product_image'] = $this->uploadImage($image);
        }

        return Product::create($data);
    }

    /**
     * Handle product update logic.
     */
    public function updateProduct(Product $product, array $data, $image = null)
    {
        if ($image) {
            // Optional: Delete old image if it exists
            // if ($product->product_image) { Storage::disk('public')->delete($product->product_image); }
            $data['product_image'] = $this->uploadImage($image);
        }

        $product->update($data);
        return $product;
    }

    /**
     * Helper for image uploads.
     */
    protected function uploadImage($image)
    {
        $imageName = $image->getClientOriginalName();
        return $image->storeAs('productImages', $imageName, 'public');
    }

    /**
     * Get counts per supercategory.
     */
    public function getCategoryCounts()
    {
        $supercategories = [1, 2, 3, 4, 5, 6];
        $counts = [];

        foreach ($supercategories as $id) {
            $counts[$id] = Product::where('Supercategory_id', $id)->count();
        }

        return $counts;
    }
}
