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
    @php
    $jumlahItem = collect($keranjang)->sum('qty');
    @endphp
    @php
        use Illuminate\Support\Facades\Storage;
        $defaultImage = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"><rect fill="#F3F4F6" width="100%" height="100%"/><g transform="translate(0, -5)"><circle cx="150" cy="135" r="28" fill="#E5E7EB"/><path d="M139 131h22m-11-11v22" stroke="#9CA3AF" stroke-width="3" stroke-linecap="round"/><text x="50%" y="195" dominant-baseline="middle" text-anchor="middle" font-family="system-ui, -apple-system, sans-serif" font-size="12" font-weight="600" fill="#9CA3AF" letter-spacing="0.5">SENTRAL GLOBAL INDO</text></g></svg>');
    @endphp

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
        <div id="cartButton" class="relative cursor-pointer transition-transform hover:scale-105">
            <div class="w-10 h-10 bg-[#C7D2FE] rounded-full flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center">
                {{ collect($keranjang ?? [])->sum('qty') }}
            </div>
        </div>
    </nav>

    <div id="cartOverlay"
         class="fixed inset-0 bg-black/40 z-40 hidden">
    </div>

    <div id="cartSidebar"
         class="fixed top-0 -right-[400px] w-[350px] h-full bg-white z-50 shadow-2xl transition-all duration-300 flex flex-col">

        <div class="p-4 border-b flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg">Keranjang</h2>
                <p class="text-xs text-gray-400">
                    {{ collect($keranjang ?? [])->sum('qty') }} item
                </p>
            </div>

            <button id="closeCart" class="text-2xl text-gray-500">×</button>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            @php $total = 0; @endphp
            @forelse($keranjang ?? [] as $item)
                @php
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                @endphp

                <div id="cart-item-{{ $item['id'] }}" class="flex gap-3 border-b pb-3">
                    @php $cartImage = !empty($item['image']) && Storage::disk('public')->exists($item['image']) ? asset('storage/' . $item['image']) : $defaultImage; @endphp
                    <img src="{{ $cartImage }}" class="w-20 h-20 object-cover rounded-lg">
                    <div class="flex-1">
                        <h4 class="text-sm font-bold">{{ $item['name'] }}</h4>
                        <p class="text-xs font-semibold mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Subtotal:
                            <span id="subtotal-{{ $item['id'] }}">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                        </p>
                        <div class="flex items-center gap-2 mt-2">
                            <button onclick="updateCart({{ $item['id'] }}, -1)" class="w-6 h-6 border rounded">-</button>
                            <span id="qty-{{ $item['id'] }}">{{ $item['qty'] }}</span>
                            <button onclick="updateCart({{ $item['id'] }}, 1)" class="w-6 h-6 border rounded">+</button>
                        </div>
                    </div>
                    <form action="{{ route('keranjang.remove', $item['id']) }}" method="POST">
                        @csrf
                        <button class="text-red-500">×</button>
                    </form>
                </div>
            @empty
                <p class="text-center text-gray-400 text-sm">Keranjang kosong</p>
            @endforelse
        </div>

        <div class="border-t p-4">
            <div class="flex justify-between font-bold mb-4">
                <span>Total:</span>
                <span id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div class="space-y-3">
            <a href="{{ $jumlahItem > 0 ? route('checkout.buy') : '#' }}"
            class="checkout-btn block w-full py-3 rounded-lg text-center font-bold relative z-50
            {{ $jumlahItem > 0
                ? 'bg-purple-400 hover:bg-purple-500 text-white'
                : 'bg-gray-300 text-gray-500 cursor-not-allowed pointer-events-none' }}">
            Beli
            </a>

            <a href="{{ $jumlahItem > 0 ? route('checkout.rent') : '#' }}"
            class="checkout-btn block w-full py-3 rounded-lg text-center font-bold relative z-50
            {{ $jumlahItem > 0
                ? 'bg-purple-400 hover:bg-purple-500 text-white'
                : 'bg-gray-300 text-gray-500 cursor-not-allowed pointer-events-none' }}">
            Sewa
            </a>
            </div>

        </div>
    </div>

    <div class="bg-purple-500 py-12 text-center text-white">
        <h1 class="text-3xl font-bold">Katalog Produk Kami</h1>
        <p class="text-sm opacity-80">Temukan solusi terbaik untuk kebutuhan bisnis Anda</p>
    </div>

    <section class="py-16 px-10">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
             @forelse($products as $product)
<div data-aos="fade-up" class="bg-white border rounded-xl p-4 shadow-sm transition product-hover">
    <a href="{{ route('products.show', $product) }}" class="block">
        @php $listImage = !empty($product->image) && Storage::disk('public')->exists($product->image) ? asset('storage/' . $product->image) : $defaultImage; @endphp
        <img src="{{ $listImage }}" 
     class="w-full h-40 object-cover rounded-lg mb-4"
     onerror="this.src='{{ $defaultImage }}'">

<h4 class="text-sm font-bold mb-1 truncate" title="{{ $product->name }}">{{ $product->name }}</h4>
        <p class="text-xs text-gray-400 mb-3 h-8 overflow-hidden">{{ \Illuminate\Support\Str::limit($product->description ?? '', 60) }}</p>
    </a>
    
    <div class="flex justify-between items-center">
        <div>
            <span class="text-purple-600 font-bold text-sm">IDR {{ number_format((float)$product->price, 0, ',', '.') }}</span>
            @if($product->stock <= 0)
                <p class="text-[10px] text-red-500 font-semibold">Stok produk habis</p>
            @else
                <p class="text-[10px] text-gray-500">Stock: {{ $product->stock }}</p>
            @endif
        </div>
        <form action="{{ route('keranjang.add', $product) }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center justify-center w-10 h-10 rounded-lg transition {{ $product->stock <= 0 ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-purple-100 text-purple-600 hover:bg-purple-600 hover:text-white' }}"
                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                @if($product->stock <= 0)
                    <span class="text-[10px]">Habis</span>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                @endif
            </button>
        </form>
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
    <script>
        AOS.init({ duration: 1000, once: true });

        const cartButton = document.getElementById('cartButton');
        const cartSidebar = document.getElementById('cartSidebar');
        const closeCart = document.getElementById('closeCart');
        const cartOverlay = document.getElementById('cartOverlay');

        cartButton?.addEventListener('click', () => {
        cartSidebar.classList.remove('-right-[400px]');
        cartSidebar.classList.add('right-0');
        cartOverlay.classList.remove('hidden');
        });

        function closeSidebar() {
        cartSidebar.classList.remove('right-0');
        cartSidebar.classList.add('-right-[400px]');
        cartOverlay.classList.add('hidden');
        }

        closeCart?.addEventListener('click', closeSidebar);
        cartOverlay?.addEventListener('click', closeSidebar);

        function updateCart(id, change) {
            fetch(`/keranjang/update/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ change: change })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const qtyElement = document.getElementById(`qty-${id}`);
                    let qty = parseInt(qtyElement.innerText);
                    qty += change;
                    if (qty <= 0) {
                        document.getElementById(`cart-item-${id}`).remove();
                    } else {
                        qtyElement.innerText = qty;
                        document.getElementById(`subtotal-${id}`).innerText = 'Rp ' + formatRupiah(data.subtotal);
                    }
                    document.getElementById('cart-total').innerText = 'Rp ' + formatRupiah(data.total);
                }
            });
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }
    </script>
</body>
</html>