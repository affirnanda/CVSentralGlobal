<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - CV Solusi Sentra Global Indo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
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
    </nav>

    {{-- Product Detail --}}
    <div class="max-w-5xl mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl shadow-md p-8 flex flex-col md:flex-row gap-10" data-aos="fade-up">
            
            <div class="md:w-1/2">
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="w-full h-80 object-cover rounded-xl"
                     onerror="this.src='https://via.placeholder.com/600x400'">
            </div>

            <div class="md:w-1/2 flex flex-col justify-center">
                <a href="{{ route('katalog.index') }}" 
                   class="text-xs text-purple-500 hover:underline mb-4 inline-block">← Kembali ke Katalog</a>
                <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                <p class="text-2xl text-orange-500 font-bold mb-4">
                    IDR {{ number_format((float)$product->price, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $product->description }}</p>
            </div>
        </div>

        {{-- Related Products --}}
        @if($related->count())
        <div class="mt-12">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Produk Lainnya</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($related as $item)
                <a href="{{ route('products.show', $item) }}"
                   class="bg-white border rounded-xl p-3 shadow-sm transition hover:scale-105 block" data-aos="fade-up">
                    <img src="{{ asset('storage/' . $item->image) }}"
                         class="w-full h-32 object-cover rounded-lg mb-3"
                         onerror="this.src='https://via.placeholder.com/300'">
                    <h4 class="text-xs font-bold mb-1 truncate">{{ $item->name }}</h4>
                    <div class="text-orange-500 font-bold text-xs">
                        IDR {{ number_format((float)$item->price, 0, ',', '.') }}
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <footer class="bg-gray-100 py-10 text-center text-xs text-gray-500 mt-10">
        <p>© 2026 CV Solusi Sentra Globalindo</p>
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>AOS.init({ duration: 1000, once: true });</script>
</body>
</html>