<head>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Add Product</h2>
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

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full border border-gray-300 rounded-md p-2">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Harga Beli (IDR)</label>
                        <input type="number" name="price" value="{{ old('price') }}"
                               inputmode="numeric" autocomplete="off" min="0" step="1"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Harga Sewa (IDR)</label>
                        <input type="number" name="rental_price" value="{{ old('rental_price', 0) }}"
                               inputmode="numeric" autocomplete="off" min="0" step="1"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}"
                               inputmode="numeric" autocomplete="off" min="0" step="1"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                            Save Product
                        </button>
                        <a href="{{ route('admin.products.index') }}"
                           class="bg-purple-100 text-purple-700 px-4 py-2 rounded-md hover:bg-purple-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

