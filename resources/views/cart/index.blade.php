<x-layout>
    <x-slot:heading>
        Cart
    </x-slot:heading>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Product ID</th>
                    <th class="py-2 px-4 border-b">Product Name</th>
                    <th class="py-2 px-4 border-b">Unit Price</th>
                    <th class="py-2 px-4 border-b">Quantity</th>
                    <th class="py-2 px-4 border-b">Attributes</th>
                    <th class="py-2 px-4 border-b">Sub Total</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody id="cart-body">
                @php
                    $grandTotal = 0; // Initialize grand total
                @endphp
                @foreach($cart as $item)
                @php
                    $subTotal = $item['quantity'] * $item['price'];
                    $grandTotal += $subTotal; // Accumulate grand total
                @endphp
                <tr data-id="{{ $item['id'] }}" class="hover:bg-green-500">
                    <td class="py-2 px-4 border-b">{{ $item['id'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $item['name'] }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($item['price'], 2) }}</td>
                    <td class="py-2 px-4 border-b">
                        <div class="flex items-center">
                            <button class="minus bg-green-500 text-white px-2 py-1 rounded">-</button>
                            <input type="number" class="quantity w-16 text-center text-black border border-gray-300 mx-2" value="{{ $item['quantity'] }}" min="1" readonly>
                            <button class="plus bg-green-500 text-white px-2 py-1 rounded">+</button>
                        </div>
                    </td>
                   <td class="py-2 px-4 border-b">
                      @if(isset($item['attributes']) && !empty($item['attributes']))
                   {{ implode(', ', array_map(function($key, $value) { return "$key: $value"; }, array_keys($item['attributes']), $item['attributes'])) }}
                   @else
                     N/A
                    @endif
                   </td>
                    <td class="py-2 px-4 border-b subtotal">{{ number_format($subTotal, 2) }}</td>
                    <td class="py-2 px-4 border-b">
                       <button class="remove-button bg-green-500 text-white px-2 py-1 rounded" data-id="{{ $item['id'] }}">Remove</button>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="py-2 px-4 border-b text-right font-bold">Grand Total:</td>
                    <td class="py-2 px-4 border-b font-bold grand-total">{{ number_format($grandTotal, 2) }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <a class="bg-green-500 text-white px-2 py-1 rounded" href="/shop">Continue Shopping</a>
    </div>

    <style>
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            thead {
                display: none; /* Hide the header on small screens */
            }
            tr {
                display: flex;
                flex-direction: column; /* Stack rows vertically */
                border: 1px solid #ccc; /* Add border for better visibility */
                margin-bottom: 1rem; /* Space between rows */
            }
            td {
                display: flex;
                justify-content: space-between; /* Align items side by side */
                padding: 0.5rem; /* Add padding */
                border: none; /* Remove border for better layout */
                background: #f9f9f9; /* Optional: Background color for rows */
                border-bottom: 1px solid #ddd; /* Optional: Border for row separation */
            }
            td:before {
                content: attr(data-label); /* Use data-label for display */
                font-weight: bold; /* Make labels bold */
                margin-right: 1rem; /* Space between label and value */
            }
        }
    </style>

    <script>
        document.querySelectorAll('.plus').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const quantityInput = row.querySelector('.quantity');
                const newQuantity = parseInt(quantityInput.value) + 1;
                quantityInput.value = newQuantity;
                updateCart(row, newQuantity);
            });
        });

        document.querySelectorAll('.minus').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const quantityInput = row.querySelector('.quantity');
                const newQuantity = Math.max(1, parseInt(quantityInput.value) - 1);
                quantityInput.value = newQuantity;
                updateCart(row, newQuantity);
            });
        });

        document.querySelectorAll('.remove-button').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');

                fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                    },
                    body: JSON.stringify({ id: itemId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload the page to see updated cart
                    } else {
                        console.error('Failed to remove item from cart');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        function updateCart(row, quantity) {
            const itemId = row.dataset.id;
            const price = parseFloat(row.children[2].textContent);
            const subTotal = quantity * price;
            row.querySelector('.subtotal').textContent = subTotal.toFixed(2);
            updateGrandTotal();
            updateCartCookie(itemId, quantity);
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.subtotal').forEach(subtotal => {
                grandTotal += parseFloat(subtotal.textContent);
            });
            document.querySelector('.grand-total').textContent = grandTotal.toFixed(2);
        }

        function updateCartCookie(itemId, quantity) {
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                },
                body: JSON.stringify({ id: itemId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Failed to update cart cookie');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</x-layout>
