<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('q'); // Get the search query
        $products = Product::query()
            ->with(['categories'])
            ->where('name', 'LIKE', '%'.$query.'%')
            ->get();

        return view('results', ['products' => $products, 'query' => $query]);
    }
}
