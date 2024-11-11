<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_name', // E.g., size, color, etc.
        'variant_value', // E.g., 'Large', 'Red', etc.
        'price', // Price specific to this variant
        'sale_price', //sale price
        'quantity', // Stock quantity for this variant
        'sku', // Stock Keeping Unit
    ];

    // Define the relationship to the Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
