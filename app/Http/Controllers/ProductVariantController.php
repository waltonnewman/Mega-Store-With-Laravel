<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants;
        return view('variants.index', compact('product', 'variants'));
    }

    public function create(Product $product)
    {
        return view('variants.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'variant_name' => 'required|string|max:255',
            'variant_value' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:product_variants,sku',
        ]);

        $product->variants()->create($validatedData);

        return redirect()->route('variants.index', $product)->with('success', 'Variant added successfully!');
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        return view('variants.edit', compact('product', 'variant'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validatedData = $request->validate([
            'variant_name' => 'required|string|max:255',
            'variant_value' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:product_variants,sku,' . $variant->id,
        ]);

        $variant->update($validatedData);

        return redirect()->route('variants.index', $product)->with('success', 'Variant updated successfully!');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->route('variants.index', $product)->with('success', 'Variant deleted successfully!');
    }
}