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

   <div class="flex items-center">
    <div id="cartButton"
         class="relative cursor-pointer transition-transform hover:scale-105">
        <div class="w-10 h-10 bg-[#C7D2FE] rounded-full flex items-center justify-center shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 text-white"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <div class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center">
            {{ collect($keranjang)->sum('qty') }}
        </div>

    </div>
</div>
<!-- KERANJANG -->
<div id="cartOverlay"
     class="fixed inset-0 bg-black/40 z-40 hidden">
</div>

<!-- Sidebar -->
<div id="cartSidebar"
     class="fixed top-0 right-[-400px] w-[350px] h-full bg-white z-50 shadow-2xl transition-all duration-300 flex flex-col">

    <!-- Header -->
    <div class="p-4 border-b flex justify-between items-center">
        <div>
            <h2 class="font-bold text-lg">Keranjang</h2>

            <p class="text-xs text-gray-400">
                {{ collect($keranjang)->sum('qty') }} item
            </p>
        </div>

        <button id="closeCart"
                class="text-2xl text-gray-500">
            ×
        </button>
    </div>

    <div class="flex-1 overflow-y-auto p-4 space-y-4">
        @php $total = 0; @endphp
        @forelse($keranjang as $item)
            @php
                $subtotal = $item['price'] * $item['qty'];
                $total += $subtotal;
            @endphp

            <div id="cart-item-{{ $item['id'] }}" class="flex gap-3 border-b pb-3">

                <img src="{{ asset('storage/' . $item['image']) }}"
                     class="w-20 h-20 object-cover rounded-lg">

                <div class="flex-1">

                    <h4 class="text-sm font-bold">
                        {{ $item['name'] }}
                    </h4>

                    <p class="text-xs font-semibold mt-1">
                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Subtotal:
                    <span id="subtotal-{{ $item['id'] }}">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                    </span>
                    </p>

                    <div class="flex items-center gap-2 mt-2">

                        <button
                            onclick="updateCart({{ $item['id'] }}, -1)"
                            class="w-6 h-6 border rounded">
                            -
                        </button>

                        <span id="qty-{{ $item['id'] }}">{{ $item['qty'] }}</span>

                        <button
                            onclick="updateCart({{ $item['id'] }}, 1)"
                            class="w-6 h-6 border rounded">
                            +
                        </button>

                    </div>
                </div>

                <form action="{{ route('keranjang.remove', $item['id']) }}"
                      method="POST">
                    @csrf

                    <button class="text-red-500">
                        ×
                    </button>
                </form>

            </div>

        @empty

            <p class="text-center text-gray-400 text-sm">
                Keranjang kosong
            </p>

        @endforelse

    </div>

    <!-- Footer -->
    <div class="border-t p-4">

        <div class="flex justify-between font-bold mb-4">
            <span>Total:</span>

            <span id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <button class="w-full bg-purple-400 text-white py-3 rounded-lg mb-3">
            Beli
        </button>

        <button class="w-full bg-purple-400 text-white py-3 rounded-lg">
            Sewa
        </button>

    </div>

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

<!-- ACTION BUTTON -->
<div class="flex flex-col gap-3">

    <!-- Tambahkan ke Keranjang -->
    <form action="{{ route('keranjang.add', $product) }}" method="POST">
        @csrf

        <button type="submit"
            class="w-full bg-purple-400 hover:bg-purple-500 text-white py-3 rounded-xl font-bold shadow-md transition hover:scale-[1.02]">
            Tambahkan ke Keranjang
        </button>
    </form>

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
<script>
AOS.init({
duration:1000,
once:true
});

const cartButton = document.getElementById('cartButton');
const cartSidebar = document.getElementById('cartSidebar');
const closeCart = document.getElementById('closeCart');
const cartOverlay = document.getElementById('cartOverlay');

cartButton.addEventListener('click', () => {
    cartSidebar.style.right = '0';
    cartOverlay.classList.remove('hidden');
});

function closeSidebar() {
    cartSidebar.style.right = '-400px';
    cartOverlay.classList.add('hidden');
}
closeCart.addEventListener('click', closeSidebar);
cartOverlay.addEventListener('click', closeSidebar);

function formatRupiah(angka)
{
    return new Intl.NumberFormat('id-ID').format(angka);
}

function updateCart(id, change)
{
    fetch(`/keranjang/update/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            change: change
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            const qtyElement = document.getElementById(`qty-${id}`);
            let qty = parseInt(qtyElement.innerText);
            qty += change;
            if(qty <= 0) {
                document.getElementById(`cart-item-${id}`).remove();
            } else {
                qtyElement.innerText = qty;
                document.getElementById(`subtotal-${id}`).innerText =
                    'Rp ' + formatRupiah(data.subtotal);
            }
            document.getElementById('cart-total').innerText =
                'Rp ' + formatRupiah(data.total);
        }
    });
}
</script>

</body>
</html>