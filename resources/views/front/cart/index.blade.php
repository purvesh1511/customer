<x-app-layout>
<div class="max-w-6xl mx-auto py-10">

<h2 class="text-2xl font-bold mb-6">Your Cart</h2>

@if(empty($cart))
    <p>Your cart is empty.</p>
@else
<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-3">Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php $grand = 0; @endphp
        @foreach($cart as $item)
            @php $total = $item['price'] * $item['quantity']; $grand += $total; @endphp
            <tr class="border-t">
                <td class="p-3 flex items-center gap-3">
                    <img src="{{ asset('storage/'.$item['image']) }}" class="w-16 h-16 rounded">
                    {{ $item['name'] }}
                </td>
                <td>₹{{ $item['price'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>₹{{ $total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="text-right mt-6 text-xl font-bold">
    Grand Total: ₹{{ $grand }}
</div>
@endif

</div>
</x-app-layout>
