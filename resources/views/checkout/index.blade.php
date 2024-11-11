<x-layout>
    <x-slot:heading>
        Checkout
    </x-slot:heading>

    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Checkout</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Customer Information Section -->
            <div class="p-6 rounded shadow">
                <h3 class="text-xl font-semibold mb-4">Customer Information</h3>
                <x-forms.form method="POST" action="/checkout">
                    @csrf
                    <x-forms.input label="Name" name="name" placeholder="Enter Name" required />
                    <x-forms.input label="Email" name="email" placeholder="Enter Email" required />
                    <x-forms.input label="Address" name="address" placeholder="Enter Address" required />
                    <x-forms.input label="City" name="city" placeholder="Enter City" required />

                    <!-- Payment Method Selection -->
                    <div class="mb-4">
                        <span class="block text-sm font-medium">Payment Method</span>
                        <div class="mt-1">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="payment_method" value="credit_card" class="form-checkbox" />
                                <span class="ml-2">Credit Card</span>
                            </label>
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" name="payment_method"  value="paypal" class="form-checkbox" />
                                <span class="ml-2">PayPal</span>
                            </label>
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" name="payment_method" value="bank_transfer" class="form-checkbox" />
                                <span class="ml-2">Bank Transfer</span>
                            </label>
                        </div>
                    </div>
                          
                    <x-forms.button>Complete Purchase</x-forms.button>
                
            </div>

            <!-- Cart Summary Section -->
            <div class="p-6 rounded shadow">
                <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                <ul id="cart-summary">
                    @php
                        $grandTotal = 0; // Initialize grand total
                    @endphp
                    @foreach($cart as $item)
                    <li class="flex justify-between border-b py-2">
                        <span>{{ $item['name'] }} ({{ $item['quantity'] }})</span>
                        <span>{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </li>
                    @php
                        $subTotal = $item['quantity'] * $item['price'];
                        $grandTotal += $subTotal; // Accumulate grand total
                    @endphp
                    @endforeach
                </ul>
                
                <div class="flex justify-between font-bold mt-4">
                    <span>Grand Total:</span>
                    <span class="grand-total">{{ number_format($grandTotal, 2) }}</span>
                </div>

                 <input type="text" value="{{ number_format($grandTotal, 2) }}" name="total">

                 </x-forms.form>
            </div>
        </div>
    </div>
</x-layout>
