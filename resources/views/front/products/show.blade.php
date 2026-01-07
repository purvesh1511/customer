<x-app-layout>
    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- LEFT: Product Image -->
            <div class="flex justify-center items-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded shadow-lg object-cover">
                @else
                    <img src="https://via.placeholder.com/500x500" alt="{{ $product->name }}" class="w-full h-auto rounded shadow-lg object-cover">
                @endif
            </div>

            <!-- RIGHT: Product Content -->
            <div class="flex flex-col justify-start">
                <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>
                <p class="text-gray-500 mb-4">{{ $product->category->name ?? '' }}</p>
                <p class="text-2xl text-green-600 font-semibold mb-6">${{ number_format($product->price, 2) }}</p>
                <p class="text-gray-700 mb-6">{{ $product->description }}</p>

                <!-- Quantity and Add to Cart -->
                <form id="add-to-cart-form"
                    data-url="{{ route('cart.add', $product->id) }}"
                    class="flex flex-col sm:flex-row items-start sm:items-center gap-4">

                    @csrf

                    <div class="flex items-center gap-2">
                        <label for="quantity" class="font-medium">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1"
                            class="w-20 border-gray-300 rounded px-2 py-1">
                    </div>

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold">
                        Add to Cart
                    </button>
                </form>

                <p id="cart-message" class="mt-3 text-green-600 hidden"></p>
            </div>
        </div>

        <!-- Optional: Related Products -->
        @if($relatedProducts ?? false)
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="bg-white shadow rounded overflow-hidden">
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://via.placeholder.com/300x200' }}" class="w-full h-48 object-cover" alt="{{ $related->name }}">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">{{ $related->name }}</h3>
                                <p class="text-green-600 font-bold mt-2">${{ number_format($related->price, 2) }}</p>
                                <a href="{{ route('product.show', $related->id) }}" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <script>
document.getElementById('add-to-cart-form').addEventListener('submit', function (e) {
    e.preventDefault();

    let form   = this;
    let url    = form.dataset.url;
    let token  = form.querySelector('input[name="_token"]').value;
    let qty    = document.getElementById('quantity').value;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            document.getElementById('cart-count').innerText = res.count;

            let msg = document.getElementById('cart-message');
            msg.innerText = res.message;
            msg.classList.remove('hidden');

            setTimeout(() => msg.classList.add('hidden'), 2000);
        }
    })
    .catch(err => console.error(err));
});
</script>
</x-app-layout>
