<x-layout>
    <x-slot:heading>
        {{ $product->name }}
    </x-slot:heading>

    <div class="container mx-auto px-4 py-6">
        @if(session('success'))
            <div class="alert alert-success bg-green-900 text-white px-10 py-5">
                {{ session('success') }} 
                <a href="{{ session('cartLink') }}">View Cart</a>
            </div>
        @endif

        <div class="border p-6 rounded-lg">
            <form action="/cart/add" method="POST">
                @csrf
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="text" id="price" name="price" value="{{ $product->sale_price }}">
                <input type="hidden" name="variant_id" id="variant_id" value="0">
                

                <div class="grid lg:grid-cols-2 gap-8 mt-6">
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="400px" class="h-auto mb-4">
                    </div>
                    
                    <div>
                        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
                        <p class="mt-2 text-gray-700">{{ $product->description }}</p>

                        <div class="mt-4">
                            <span class="text-gray-500 line-through" id="original-price">{{ $product->price }}</span>
                            <span class="text-red-500 font-bold" id="current-price">{{ $product->sale_price }}</span>
                        </div>

                        <!-- Quantity Input -->
                        <div class="mt-4 flex items-center">
                            <label for="quantity" class="mr-2">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="1" class="border text-gray-500 rounded px-2 py-1 w-16">
                        </div>

                        <!-- Render dropdowns for each attribute -->
                     

                        @foreach($groupedVariants as $attributeName => $variants)
                         <div class="mt-4">
                             <label for="{{ Str::slug($attributeName) }}" class="block">{{ $attributeName }}:</label>
                                <select id="{{ Str::slug($attributeName) }}" name="attributes[{{ $attributeName }}]" required class="border text-gray-500 rounded px-2 py-1 w-full" data-variant>
                                 <option value="">Select {{ $attributeName }}</option>
                                  @foreach($variants as $variant)
                                      <option value="{{ $variant->variant_value }}" data-sale-price="{{ $variant->sale_price }}" data-price="{{ $variant->price }}">
                                         {{ $variant->variant_value }}
                                       </option>
                                   @endforeach
                                  </select>
                             </div>
                         @endforeach


                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </form>

               <!-- Gallery Section -->
        <div class="mt-8">
            <h2 class="text-xl font-bold">Gallery</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                @foreach($product->galleries as $gallery)
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery Image" class="rounded-lg shadow-md" style="width: 40%; height: auto;">
                    </div>
                @endforeach
            </div>
        </div>
        </div>

       
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currentPrice = document.getElementById('current-price'); // Element to display current price
            const originalPrice = document.getElementById('original-price'); // Element to display original price
            const priceInput = document.getElementById('price'); // Hidden input for price
            const variantIdInput = document.getElementById('variant_id'); // Hidden input for variant ID

            // Function to update prices based on selected options
            function updatePrices() {
                let newPrice = null;
                let salePrice = null;
                let selectedVariantId = null;

                // Get all select elements for attributes
                const variantSelects = document.querySelectorAll('select[data-variant]'); // Use a common attribute to select all variant dropdowns
                variantSelects.forEach(select => {
                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption) {
                        const price = selectedOption.getAttribute('data-price');
                        const sale_price = selectedOption.getAttribute('data-sale-price');

                        // Update the price if available
                        if (price) {
                            newPrice = price; // Update new price
                        }
                        if (sale_price) {
                            salePrice = sale_price; // Update sale price
                        }

                        // Update the hidden variant_id input with the selected option's value
                        selectedVariantId = selectedOption.value;
                    }
                });

                // Update displayed prices
                if (newPrice) {
                    currentPrice.textContent = newPrice;
                    priceInput.value = newPrice;
                }
                if (salePrice) {
                    originalPrice.textContent = salePrice;
                } else {
                    originalPrice.textContent = '';
                }

                // Update the hidden variant_id input to the last selected variant
                variantIdInput.value = selectedVariantId;
            }

            // Add event listeners to dynamic select elements
            const variantSelects = document.querySelectorAll('select[data-variant]'); // Use a common attribute
            variantSelects.forEach(select => {
                select.addEventListener('change', updatePrices);
            });
        });
    </script>
</x-layout>
