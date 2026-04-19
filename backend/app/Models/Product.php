<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'description',
        'price',
        'availability',
        'category_id',
        'location',
        'size',
        'color',
        'information',
        'Supercategory_id',
        'trandy',
        'justArrived',
        'product_image',
    ];

    /**
     * Scope a query to only include trendy products.
     */
    public function scopeTrendy($query)
    {
        return $query->where('trandy', 1);
    }

    /**
     * Scope a query to only include new arrivals.
     */
    public function scopeJustArrived($query)
    {
        return $query->where('justArrived', 1);
    }
}
