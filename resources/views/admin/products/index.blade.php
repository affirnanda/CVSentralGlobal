<head>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">Products</h2>
            <a href="{{ route('admin.products.create') }}"
               class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-700">
                + Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-purple-100">
                <table class="min-w-full divide-y divide-purple-100">
                    <thead class="bg-purple-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Harga Beli / Sewa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-purple-100">
                        @forelse($products as $product)
                        <tr>
                            <td class="px-6 py-4">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="h-12 w-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400 text-sm">Sentral Global Indo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div>Beli: IDR {{ number_format((float)($product->price ?? 0), 0, ',', '.') }}</div>
                                <div class="text-gray-500">Sewa: IDR {{ number_format((float)($product->rental_price ?? 0), 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $product->stock }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-purple-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">No products yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

