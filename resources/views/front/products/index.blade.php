<x-app-layout>
    <h1 class="text-3xl font-bold mb-6">Our Products</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pd-5">
        @foreach($products as $product)
            <div class="bg-white shadow rounded overflow-hidden">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200' }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                <div class="p-4">
                    <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                    <p class="text-gray-500">{{ $product->category->name ?? '' }}</p>
                    <p class="text-green-600 font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('product.show', $product->id) }}" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Details</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-app-layout>
