<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - CV Solusi Sentra Global Indo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
    <style>
        .product-hover:hover { transform: scale(1.05); }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-[#F3F4F6] text-gray-800">

    <nav class="flex items-center justify-between px-10 py-4 bg-white sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-black rounded text-white flex items-center justify-center font-bold">CV</div>
                <span class="text-[10px] font-bold leading-tight">Solusi<br>Sentra Global Indo</span>
            </a>
        </div>
        <div class="hidden md:flex gap-8 text-sm font-semibold text-gray-600">
            <a href="{{ route('welcome') }}">Home</a>
            <a href="{{ route('katalog.index') }}" class="text-purple-600">Produk</a>
        </div>
        <div class="w-10 h-10 bg-[#C7D2FE] rounded-full flex items-center justify-center shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
    </nav>

    <div class="bg-purple-500 py-12 text-center text-white">
        <h1 class="text-3xl font-bold">Katalog Produk Kami</h1>
        <p class="text-sm opacity-80">Temukan solusi terbaik untuk kebutuhan bisnis Anda</p>
    </div>

    <section class="py-16 px-10">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @forelse($products as $product)
                <div data-aos="fade-up" class="bg-white border rounded-xl p-4 shadow-sm transition product-hover">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="w-full h-40 object-cover rounded-lg mb-4"
                         onerror="this.src='https://via.placeholder.com/300'">
                    
                    <h4 class="text-sm font-bold mb-1">{{ $product->name }}</h4>
                    <p class="text-xs text-gray-400 mb-3 h-8 overflow-hidden">{{ Str::limit($product->description, 60) }}</p>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-purple-600 font-bold text-sm">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                        <button class="bg-purple-100 text-purple-600 p-2 rounded-lg hover:bg-purple-600 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500 text-lg">Belum ada produk yang tersedia.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </section>

    <footer class="bg-gray-100 py-10 text-center text-xs text-gray-500">
        <p>© 2026 CV Solusi Sentra Globalindo</p>
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>AOS.init();</script>
</body>
</html>