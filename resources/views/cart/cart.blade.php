<x-layout>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">Product ID</th>
                    <th class="py-2 px-4 border-b">Quantity</th>
                    <th class="py-2 px-4 border-b">Attributes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b">{{ $item['id'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $item['quantity'] }}</td>
                    <td class="py-2 px-4 border-b">
                        @if(isset($item['attributes']))
                            <ul>
                                @foreach($item['attributes'] as $key => $value)
                                    <li>{{ $key }}: {{ $value }}</li>
                                @endforeach
                            </ul>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
