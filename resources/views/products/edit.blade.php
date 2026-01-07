<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('products.update', $product->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-4">
                            <label class="block font-medium">Product Name</label>
                            <input type="text"
                                   name="title"
                                   class="form-control w-full"
                                   value="{{ old('title', $product->title) }}">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-4">
                            <label class="block font-medium">Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   class="form-control w-full"
                                   value="{{ old('price', $product->price) }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-4">
                            <label class="block font-medium">Product Image</label>
                            <input type="file"
                                   name="image"
                                   class="form-control w-full">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$product->image) }}"
                                         width="80"
                                         alt="Product Image">
                                </div>
                            @endif
                        </div>

                        {{-- Status --}}
                        <div class="mb-4 flex items-center">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox"
                                   name="status"
                                   id="status"
                                   value="1"
                                   class="mr-2"
                                   {{ old('status', $product->status) ? 'checked' : '' }}>
                            <label for="status" class="font-medium">Active</label>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="block font-medium">Description</label>
                            <textarea name="description"
                                      class="form-control w-full"
                                      rows="3">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('products.index') }}"
                               class="btn btn-secondary">Back</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
