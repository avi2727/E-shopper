<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'orderid',
        'name',
        'email',
        'contact',
        'address1',
        'address2',
        'country',
        'city',
        'state',
        'zip',
        'product_id',
        'product_name',
        'product_price',
        'product_quantity',
        'product_subtotal',
        'payment',
        'userid',
    ];
}
