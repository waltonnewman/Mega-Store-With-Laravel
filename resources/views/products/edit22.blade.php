<x-layout>
    <x-page-heading>Update Product</x-page-heading>

    <x-forms.form method="POST" action="/products/{{ $product->id }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH') <!-- Use PATCH for updating -->
        
        <x-forms.input label="Title" name="name" placeholder="Enter Product Title" value="{{ $product->name }}" required />
        <x-forms.input label="Description" name="description" value="{{ $product->description }}" />

        <x-forms.select label="Product Type" name="is_variable" required>
            <option value="0" {{ $product->is_variable == 0 ? 'selected' : '' }}>Simple Product</option>
            <option value="1" {{ $product->is_variable == 1 ? 'selected' : '' }}>Variable Product</option>
        </x-forms.select>

        <x-forms.input label="Regular Price" name="price" value="{{ $product->price }}" required />
        <x-forms.input label="Sale Price" name="sale_price" value="{{ $product->sale_price }}" />

        <x-forms.divider />

        <x-forms.label name="categories" label="Categories" />
        @foreach($categories as $category)
            <x-forms.checkbox name="categories[]" :value="$category->id" :id="$category->id" :label="$category->name" 
                :checked="$product->categories->contains($category->id)" />
        @endforeach

        <x-forms.divider />

        <x-forms.input label="Product Image" name="image" type="file" />

        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: auto;">
        @else
            No Image
        @endif

        <x-forms.divider />
        <x-forms.input label="Slug" name="slug" placeholder="Enter Product Slug" value="{{ $product->slug }}" required />

        <x-forms.divider />

        <x-forms.label name="variants" label="Product Variants" />
        <div id="variants">
            @foreach($product->variants as $index => $variant)
                <div class="variant" data-index="{{ $index }}">
                    <input type="text" name="variant_name[]" value="{{ $variant->name }}" placeholder="E.g., Size, Color" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;" />
                    <input type="text" name="variant_value[{{ $index }}][]" 
                        value="{{ is_array($variant->values) ? implode(',', $variant->values) : (is_string($variant->values) ? $variant->values : '') }}" 
                        placeholder="E.g., 100g, 200g, 500g" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;" />
                    <div class="variant-details"></div>
                    <button type="button" class="remove-variant" style="background-color: #f44336; color: white; border: none; padding: 10px 15px; border-radius: 4px;">Remove Variant</button>
                    <hr />
                </div>
            @endforeach
        </div>

        <button type="button" id="add-variant" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; border-radius: 4px;">Add Variant</button>

        <x-forms.button>Update</x-forms.button>
    </x-forms.form>

    <script>
        // Add event listener for adding new variants
        document.getElementById('add-variant').addEventListener('click', function() {
            const index = document.querySelectorAll('.variant').length;
            const variantHtml = `
                <div class="variant" data-index="${index}">
                    <input type="text" name="variant_name[]" placeholder="E.g., Size, Color" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;" />
                    <input type="text" name="variant_value[${index}][]" placeholder="E.g., 100g, 200g, 500g" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;" />
                    <div class="variant-details"></div>
                    <button type="button" class="remove-variant" style="background-color: #f44336; color: white; border: none; padding: 10px 15px; border-radius: 4px;">Remove Variant</button>
                    <hr />
                </div>
            `;
            document.getElementById('variants').insertAdjacentHTML('beforeend', variantHtml);
        });

        // Add event listener for removing variants
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('.variant').remove();
                updateVariantIndices();
            }
        });

        // Update indices of variants after removal
        function updateVariantIndices() {
            const variants = document.querySelectorAll('.variant');
            variants.forEach((variant, index) => {
                variant.setAttribute('data-index', index);
                variant.querySelector('input[name^="variant_value"]').name = `variant_value[${index}][]`;
            });
        }

        // Add event listener for handling input in variant values
        document.addEventListener('input', function(e) {
            if (e.target.name.startsWith('variant_value[')) {
                const variantDiv = e.target.closest('.variant');
                const values = e.target.value.split(',').map(value => value.trim()).filter(value => value);
                const detailsDiv = variantDiv.querySelector('.variant-details');

                // Clear previous details
                detailsDiv.innerHTML = '';

                values.forEach((value, index) => {
                    detailsDiv.insertAdjacentHTML('beforeend', `
                        <div class="variant-inputs" style="margin-bottom: 10px;">
                            <input type="text" name="variant_value[${variantDiv.dataset.index}][]" value="${value}" readonly style="width: calc(100% - 20px); padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-right: 10px;" />
                            <input type="number" name="variant_price[${variantDiv.dataset.index}][]" placeholder="Reg Price" style="width: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-right: 10px;" />
                            <input type="number" name="variant_sale_price[${variantDiv.dataset.index}][]" placeholder="Sale Price" style="width: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-right: 10px;" />
                            <input type="number" name="variant_stock[${variantDiv.dataset.index}][]" placeholder="Stock" style="width: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-right: 10px;" />
                            <input type="text" name="variant_sku[${variantDiv.dataset.index}][]" placeholder="SKU" style="width: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" />
                        </div>
                    `);
                });
            }
        });
    </script>
</x-layout>
