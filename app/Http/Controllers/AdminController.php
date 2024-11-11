<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Category;
use App\Models\User;
use App\Models\ProductVariant;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('/admins/products.new_product', compact('categories'));
    }

    
    public function welcome()
{
    $featuredProducts = Product::where('is_featured', true)->take(3)->get();
    $recentProducts = Product::latest()->take(3)->get();
    $tags = ['Web Development', 'Design', 'Marketing', 'SEO', 'E-commerce']; // Example tags

    return view('welcome', compact('featuredProducts', 'recentProducts', 'tags'));
}


   public function store(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_variable' => 'required|boolean',
        'price' => 'required|numeric',
        'sale_price' => 'nullable|numeric|lt:price',
        'categories' => 'nullable|array',
        'categories.*' => 'exists:categories,id',
        'variant_name.*' => 'nullable|string',
        'variant_value.*' => 'required|array',
        'variant_value.*.*' => 'required|string',
        'variant_price.*' => 'nullable|array',
        'variant_price.*.*' => 'nullable|numeric',
        'variant_sale_price.*' => 'nullable|array',
        'variant_sale_price.*.*' => 'nullable|numeric|lt:variant_price.*.*',
        'variant_stock.*' => 'nullable|array',
        'variant_stock.*.*' => 'nullable|integer',
        'variant_sku.*' => 'nullable|array',
        'variant_sku.*.*' => 'nullable|string',
        'image' => 'required|file|mimes:png,jpg,webp|max:2048',
    ]);

    // Create the product
    $product = Product::create([
        'name' => $validatedData['name'],
        'description' => $validatedData['description'],
        'is_variable' => $validatedData['is_variable'],
        'price' => $validatedData['price'],
        'sale_price' => $validatedData['sale_price'],
        'user_id' => auth()->id(),
    ]);

    // Store the product image
    $product->image = $request->file('image')->store('images', 'public');
    $product->slug = $this->generateUniqueSlug($validatedData['name']);
    $product->save();

    // Attach categories if provided
    if (!empty($validatedData['categories'])) {
        $product->categories()->attach($validatedData['categories']);
    }

    // Handle variants if the product is variable
    if ($validatedData['is_variable']) {
        foreach ($validatedData['variant_name'] as $index => $variantName) {
            if ($variantName) {
                $this->createVariants($product, $index, $validatedData);
            }
        }
    }

    return redirect()->route('products.show', $product->slug)->with('success', 'Product created successfully.');
}

// Helper function to create product variants
private function createVariants(Product $product, $index, array $validatedData)
{
    $variantValues = $validatedData['variant_value'][$index] ?? [];
    $variantPrices = $validatedData['variant_price'][$index] ?? [];
    $variantSalePrices = $validatedData['variant_sale_price'][$index] ?? [];
    $variantStocks = $validatedData['variant_stock'][$index] ?? [];
    $variantSkus = $validatedData['variant_sku'][$index] ?? [];

    foreach ($variantValues as $subIndex => $value) {
        try {
            ProductVariant::create([
                'product_id' => $product->id,
                'variant_name' => $validatedData['variant_name'][$index],
                'variant_value' => $value,
                'price' => $variantPrices[$subIndex] ?? null,
                'sale_price' => $variantSalePrices[$subIndex] ?? null,
                'quantity' => $variantStocks[$subIndex] ?? null,
                'sku' => $variantSkus[$subIndex] ?? null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating product variant: ' . $e->getMessage(), [
                'variant_name' => $validatedData['variant_name'][$index],
                'variant_value' => $value,
            ]);
            return redirect()->back()->withErrors(['error' => 'Failed to create variant: ' . $e->getMessage()]);
        }
    }
}



  public function show($slug)
{
    // Fetch the product along with its variants
    $product = Product::with('variants')->where('slug', $slug)->firstOrFail();

    // Group variants by their attribute name
    $groupedVariants = $product->variants->groupBy('variant_name');

    return view('products.show', compact('product', 'groupedVariants'));
}

 public function edit(Product $product)
{
    $categories = Category::all();
    // Check if the user is authorized
    /* if (auth()->user()->cannot('edit', $product)) {
        abort(403); 
    }
       */
     return view('/admins/products.edit', compact('product', 'categories'));
}

    public function allProducts()
{
    $products = Product::with('categories', 'user')->paginate(4); // Adjust the pagination as needed
    return view('/admins/products.all-products', compact('products'));
}

    public function allUsers()
{
    $users = User::all(); // Adjust the pagination as needed
    return view('/admins/allUsers', compact('users'));
}

    public function update(Request $request, Product $product)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'sale_price' => 'nullable|numeric|lt:price',
        'is_variable' => 'boolean',
        'categories' => 'array|exists:categories,id',
        'image' => 'nullable|image|max:2048', // Add validation for the image if applicable
        'variant_name.*' => 'required|string|max:255', // Validate variant names
        'variant_value.*' => 'required|string|max:255', // Validate variant values
        'variant_price.*' => 'nullable|numeric', // Validate variant prices
        'variant_sale_price.*' => 'nullable|numeric|lt:variant_price.*', // Validate sale prices against regular prices
        'variant_stock.*' => 'nullable|integer|min:0', // Validate stock
        'variant_sku.*' => 'nullable|string|max:255', // Validate SKU
    ]);

     // Remove categories from the validated data before updating the product
    $dataToUpdate = collect($validatedData)->except('categories');

    // Update the product with validated data excluding categories
    $product->update($dataToUpdate->toArray());

    // Sync categories if provided
    if (isset($validatedData['categories'])) {
        $product->categories()->sync($validatedData['categories']);
    }

    // Handle image upload if applicable
    if ($request->hasFile('image')) {
        // Assuming you have a method to handle the image upload
        $product->image = $request->file('image')->store('images/products', 'public');
        $product->save();
    }

    // Handle variants if applicable
    if ($request->has('variant_name')) {
        // Assuming you have a method to handle saving variants
        $this->updateVariants($product, $request);
    }

    return redirect()->route('products.all')->with('success', 'Product updated successfully!');
}

// Method to handle updating variants
protected function updateVariants(Product $product, Request $request)
{
    // Clear existing variants
    $product->variants()->delete();

    // Loop through variants and create them
    foreach ($request->variant_name as $index => $name) {
        $product->variants()->create([
            'name' => $name,
            'values' => explode(',', $request->variant_value[$index]), // Assuming values are comma-separated
            'price' => $request->variant_price[$index] ?? null,
            'sale_price' => $request->variant_sale_price[$index] ?? null,
            'stock' => $request->variant_stock[$index] ?? null,
            'sku' => $request->variant_sku[$index] ?? null,
        ]);
    }
}


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admins.allUsers')->with('success', 'User deleted successfully!');
    }

    // Function to generate a unique slug
    private function generateUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $baseSlug = $slug;
        $count = 1;

        // Check if the slug already exists
        while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        return $slug;
    }
}
