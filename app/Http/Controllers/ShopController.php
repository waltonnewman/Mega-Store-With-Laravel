<?php

namespace App\Http\Controllers;

use App\Models\Product; // Make sure to import the Product model
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
         // Fetch products with pagination (e.g., 12 products per page)
        $products = Product::Simplepaginate(12);
        return view('shop.index', compact('products')); // Pass to the view
    }
}
