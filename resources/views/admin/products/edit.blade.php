<head>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="text-white hover:text-gray-200" title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-white leading-tight">Edit Product</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-purple-100">
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full border border-gray-300 rounded-md p-2">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Harga Beli (IDR)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}"
                               inputmode="numeric" autocomplete="off" min="0" step="1"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Harga Sewa (IDR)</label>
                        <input type="number" name="rental_price" value="{{ old('rental_price', $product->rental_price ?? 0) }}"
                               inputmode="numeric" autocomplete="off" min="0" step="1"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                               inputmode="numeric" autocomplete="off" min="0" step="1"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" class="h-20 w-20 object-cover rounded mb-2">
                        @endif
                        <input type="file" name="image" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500">
                        <p class="text-xs text-gray-400 mt-1">Leave empty to keep current image</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                            Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}"
                           class="bg-purple-100 text-purple-700 px-4 py-2 rounded-md hover:bg-purple-200">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

