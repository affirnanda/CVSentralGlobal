<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Solusi Sentra Global Indo</title>
    <link rel="icon" href="{{ asset('images/logo-solusi-sentra-globalindo.jpeg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    @php
        use Illuminate\Support\Facades\Storage;
        $defaultImage = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400" viewBox="0 0 600 400"><rect fill="#F3F4F6" width="100%" height="100%"/><g transform="translate(0, -10)"><circle cx="300" cy="180" r="40" fill="#E5E7EB"/><path d="M285 175h30m-15-15v30" stroke="#9CA3AF" stroke-width="4" stroke-linecap="round"/><text x="50%" y="260" dominant-baseline="middle" text-anchor="middle" font-family="system-ui, -apple-system, sans-serif" font-size="18" font-weight="600" fill="#9CA3AF" letter-spacing="1">SOLUSI SENTRAL GLOBAL INDO</text></g></svg>');
        $smallDefaultImage = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"><rect fill="#F3F4F6" width="100%" height="100%"/><g transform="translate(0, -5)"><circle cx="150" cy="135" r="28" fill="#E5E7EB"/><path d="M139 131h22m-11-11v22" stroke="#9CA3AF" stroke-width="3" stroke-linecap="round"/><text x="50%" y="195" dominant-baseline="middle" text-anchor="middle" font-family="system-ui, -apple-system, sans-serif" font-size="12" font-weight="600" fill="#9CA3AF" letter-spacing="0.5">SENTRAL GLOBAL INDO</text></g></svg>');
        $heroImage = !empty($landingData['hero_image']) ? trim($landingData['hero_image']) : null;
        $heroBackground = $heroImage && Storage::disk('public')->exists('landing/' . $heroImage) ? asset('storage/landing/' . $heroImage) : $defaultImage;
        $profileImage = !empty($landingData['profile_image']) ? trim($landingData['profile_image']) : null;
        $profileImageUrl = $profileImage && Storage::disk('public')->exists('landing/' . $profileImage) ? asset('storage/landing/' . $profileImage) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=600&h=400&fit=crop';
        ;
    @endphp

    <style>
        .hero-bg {
            @if($heroBackground)
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                    url('{{ $heroBackground }}');
                background-size: cover;
                background-position: center;
            @else background-color: #ffffff;
            @endif
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
        }

        .product-hover:hover {
            transform: scale(1.05);
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

</head>

<body class="bg-[#F3F4F6] text-black">

    @if(session('success'))
        <div id="flash-success"
            class="fixed top-5 right-5 z-[9999] bg-green-500 text-black px-6 py-3 rounded-xl shadow-xl flex items-center gap-3 transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-success').remove()"
                class="ml-2 text-black hover:text-black font-bold text-lg leading-none">&times;</button>
        </div>

        <script>
            setTimeout(function () {
                var el = document.getElementById('flash-success');
                if (el) el.style.opacity = '0', setTimeout(() => el.remove(), 500);
            }, 4000);
        </script>
    @endif

    <nav
        class="flex items-center justify-between gap-3 px-4 py-3 bg-purple-700 sticky top-0 z-50 shadow-md sm:px-6 lg:px-10">
        <a href="#home" class="flex shrink-0 items-center">
            <x-application-logo
                class="h-10 w-auto max-w-[118px] rounded-md sm:h-12 sm:max-w-[150px] lg:max-w-[170px]" />
        </a>

        <div class="hidden md:flex gap-8 text-sm font-semibold text-white">
            <a href="#home" class="transition hover:text-black">Dashboard</a>
            <a href="#profile" class="transition hover:text-black">Profile</a>
            <a href="#produk" class="transition hover:text-black">Produk</a>
            <a href="#testi" class="transition hover:text-black">Testimonials</a>
            <a href="#faq" class="transition hover:text-black">FAQ</a>
        </div>
        @php
            $jumlahItem = collect($keranjang)->sum('qty');
        @endphp
        <div class="flex shrink-0 items-center">
            <div id="cartButton" class="relative cursor-pointer transition-transform hover:scale-105">
                <div
                    class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center shadow-md ring-1 ring-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div
                    class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 bg-red-500 text-black text-[10px] rounded-full flex items-center justify-center">
                    {{ collect($keranjang)->sum('qty') }}
                </div>

            </div>
        </div>
    </nav>

    <div id="cartOverlay" class="fixed inset-0 bg-black/40 z-40 hidden">
    </div>

    <div id="cartSidebar"
        class="fixed top-0 right-[-400px] w-[350px] h-full bg-white z-50 shadow-2xl transition-all duration-300 flex flex-col">

        <div class="p-4 border-b flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg">Keranjang</h2>

                <p class="text-xs text-black">
                    {{ collect($keranjang)->sum('qty') }} item
                </p>
            </div>

            <button id="closeCart" class="text-2xl text-black">
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

                    @php $cartImage = !empty($item['image']) && Storage::disk('public')->exists($item['image']) ? asset('storage/' . $item['image']) : $smallDefaultImage; @endphp
                    <img src="{{ $cartImage }}" class="w-20 h-20 object-cover rounded-lg">

                    <div class="flex-1">

                        <h4 class="text-sm font-bold">
                            {{ $item['name'] }}
                        </h4>

                        <p class="text-xs font-semibold mt-1">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </p>

                        <p class="text-xs text-black mt-1">
                            Subtotal:
                            <span id="subtotal-{{ $item['id'] }}">Rp
                                {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                            </span>
                        </p>

                        <div class="flex items-center gap-2 mt-2">

                            <button onclick="updateCart({{ $item['id'] }}, -1)" class="w-6 h-6 border rounded">
                                -
                            </button>

                            <span id="qty-{{ $item['id'] }}">{{ $item['qty'] }}</span>

                            <button onclick="updateCart({{ $item['id'] }}" class="w-6 h-6 border rounded">
                                +
                            </button>

                        </div>
                    </div>

                    <form action="{{ route('keranjang.remove', $item['id']) }}" method="POST">
                        @csrf

                        <button class="text-black">
                            ×
                        </button>
                    </form>

                </div>

            @empty

                <p class="text-center text-black text-sm">
                    Keranjang kosong
                </p>

            @endforelse

        </div>

        <div class="border-t p-4">

            <div class="flex justify-between font-bold mb-4">
                <span>Total:</span>

                <span id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div class="space-y-3">

                <a href="{{ $jumlahItem > 0 ? route('checkout.buy') : '#' }}" class="checkout-btn block w-full py-3 rounded-lg text-center font-bold relative z-50
            {{ $jumlahItem > 0
    ? 'bg-purple-400 hover:bg-purple-500 text-black'
    : 'bg-gray-300 text-black cursor-not-allowed pointer-events-none' }}">
                    Beli
                </a>

                <a href="{{ $jumlahItem > 0 ? route('checkout.rent') : '#' }}" class="checkout-btn block w-full py-3 rounded-lg text-center font-bold relative z-50
            {{ $jumlahItem > 0
    ? 'bg-purple-400 hover:bg-purple-500 text-black'
    : 'bg-gray-300 text-black cursor-not-allowed pointer-events-none' }}">
                    Sewa
                </a>
            </div>
        </div>

    </div>

    <header id="home" class="hero-bg min-h-screen flex items-center px-10 pt-20">
        <div class="max-w-7xl mx-auto w-full">
            <h1 data-aos="zoom-in"
                class="text-4xl md:text-6xl lg:text-7xl font-extrabold {{ !empty($landingData['hero_image']) ? 'text-white' : 'text-white' }} max-w-4xl mb-8 leading-tight tracking-tight uppercase">
                {{ $landingData['hero_title'] ?? 'The Best Solution for Your Bussines' }}
            </h1>

            <a href="#profile" data-aos="fade-up" data-aos-delay="200"
                class="inline-block bg-transparent border-2 {{ !empty($landingData['hero_image']) ? 'border-white text-white hover:bg-white hover:text-black' : 'border-purple-600 text-black hover:bg-purple-600 hover:text-black' }} px-8 py-3 rounded-full font-bold transition-all duration-300 transform hover:-translate-y-1">
                Learn More
            </a>
        </div>
    </header>

    <section id="profile" class="py-24 px-10 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 data-aos="fade-up"
                class="text-4xl md:text-5xl lg:text-6xl font-extrabold uppercase mb-16 tracking-tight text-black leading-tight max-w-4xl">
                {{ $landingData['profile_title'] ?? 'Berpengalaman di bidangnya selama 5 tahun' }}
            </h2>

            <div class="grid md:grid-cols-2 gap-16 items-start">
                <div data-aos="fade-right" class="pr-0 md:pr-8">
                    <p class="text-black text-lg md:text-xl leading-relaxed mb-8">
                        {{ $landingData['section_text'] ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.' }}
                    </p>

                    <a href="#produk"
                        class="inline-flex items-center text-black font-semibold border-b-2 border-gray-900 pb-1 hover:text-black hover:border-purple-600 transition-colors">
                        Lihat produk kami selengkapnya <span class="ml-2">&rarr;</span>
                    </a>
                </div>

                <div data-aos="fade-left"
                    class="bg-gray-100 w-full min-h-[400px] flex items-center justify-center overflow-hidden">
                    <img src="{{ $profileImageUrl }}" class="w-full h-full object-cover max-h-[600px]"
                        onerror="this.src='{{ $defaultImage }}'">
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-[#E9E9FF] px-10">

        <div class="text-center mb-10">
            <span class="bg-purple-400 text-black px-6 py-1 rounded-md font-bold text-sm">
                Layanan Kami
            </span>
        </div>

        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6">

            <div data-aos="flip-left" class="bg-white p-6 rounded-2xl text-center transition card-hover">

                <div class="text-3xl mb-4">🏠</div>

                <h3 class="font-bold mb-2">Express Service</h3>

                <p class="text-xs text-black mb-4">
                    Layanan cepat dengan kualitas terbaik
                </p>

            </div>

            <div data-aos="flip-left" data-aos-delay="200"
                class="bg-white p-6 rounded-2xl text-center transition card-hover">

                <div class="text-3xl mb-4">🔧</div>

                <h3 class="font-bold mb-2">Maintenance</h3>

                <p class="text-xs text-black mb-4">
                    Perawatan rutin untuk perangkat Anda
                </p>

            </div>

            <div data-aos="flip-left" data-aos-delay="400"
                class="bg-white p-6 rounded-2xl text-center transition card-hover">

                <div class="text-3xl mb-4">📞</div>

                <h3 class="font-bold mb-2">Help Desk</h3>

                <p class="text-xs text-black mb-4">
                    Dukungan teknis kapan saja
                </p>

            </div>

        </div>

    </section>

    <section id="produk" class="py-16 px-10 bg-white">

        <div class="text-center mb-10">
            <a href="{{ route('katalog.index') }}" class="inline-block transition hover:scale-105">
                <span class="bg-purple-400 text-black px-6 py-1 rounded-md font-bold text-sm">
                    Catalog Product
                </span>
            </a>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div data-aos="zoom-in" class="bg-white border rounded-xl p-3 shadow-sm transition product-hover">
                    <a href="{{ route('products.show', $product) }}" class="block">
                        @php $listImage = !empty($product->image) && Storage::disk('public')->exists($product->image) ? asset('storage/' . $product->image) : $smallDefaultImage; @endphp
                        <img src="{{ $listImage }}" class="w-full h-32 object-cover rounded-lg mb-3"
                            onerror="this.src='{{ $smallDefaultImage }}'">

                        <h4 class="text-xs font-bold mb-1 truncate" title="{{ $product->name }}">{{ $product->name }}</h4>
                        <p class="text-[10px] text-black mb-2">
                            {{ \Illuminate\Support\Str::limit($product->description ?? '', 50) }}
                        </p>

                        <div class="text-black font-bold text-xs">
                            IDR {{ number_format((float) $product->price, 0, ',', '.') }}
                        </div>
                        @if($product->available_stock <= 0)
                            <p class="text-[10px] text-black font-semibold mt-1">Stok produk habis</p>
                        @else
                            <p class="text-[10px] text-black mt-1">Stok tersisa: {{ $product->available_stock }}</p>
                        @endif
                    </a>
                </div>
            @empty
                <div class="col-span-4 text-center py-10 text-black text-sm">
                    Belum ada produk. Tambahkan produk melalui panel admin.
                </div>
            @endforelse
        </div>

    </section>

    <section id="testi" class="py-16 bg-[#E9E9FF] px-10">

        <div class="text-center mb-10">
            <span class="bg-purple-400 text-black px-6 py-1 rounded-md font-bold text-sm">
                Testimonial
            </span>
        </div>

        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6 mb-16">
            @forelse($testimonials as $t)
                <div data-aos="fade-up" class="bg-white p-6 rounded-xl shadow-md flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($t->name) }}&background=random"
                            class="w-12 h-12 rounded-full border-2 border-purple-200">
                        <div>
                            <h5 class="text-sm font-bold text-black">{{ $t->name }}</h5>
                            <div class="text-black text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $t->rating ? '★' : '☆' }}
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-black italic leading-relaxed">
                        "{{ $t->message }}"
                    </p>
                </div>
            @empty
                <div class="col-span-full text-center text-black italic">
                    Belum ada testimoni yang disetujui.
                </div>
            @endforelse
        </div>

        <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl shadow-xl border border-purple-100" data-aos="zoom-in">
            <h3 class="text-xl font-bold text-center mb-6 text-black">Kirim Testimoni Anda</h3>

            <form action="{{ route('testimonials.store') }}" method="POST" class="space-y-4" novalidate>
                @csrf
                <div>
                    <label class="block text-xs font-bold text-black mb-1">NAMA ANDA</label>
                    <input type="text" id="name" name="name" required placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}" maxlength="100"
                        oninput="validateTestiField(this, 'name-count', 'name-error', 100, 'submit-testi-btn')"
                        class="w-full px-4 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm @error('name') border-red-500 @enderror">
                    <div class="flex justify-between items-center mt-1">
                        <span id="name-error" class="text-xs text-black hidden">&#10060; Penulisan nama terlalu
                            panjang</span>
                        @error('name')
                            <span class="text-xs text-black">{{ $message }}</span>
                        @enderror
                        <span id="name-counter" class="text-[10px] text-black ml-auto"><span
                                id="name-count">0</span>/100</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">RATING</label>
                    <select name="rating" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm">
                        <option value="5">★★★★★ (Sangat Bagus)</option>
                        <option value="4">★★★★☆ (Bagus)</option>
                        <option value="3">★★★☆☆ (Cukup)</option>
                        <option value="2">★★☆☆☆ (Buruk)</option>
                        <option value="1">★☆☆☆☆ (Sangat Buruk)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">PESAN / TESTIMONI</label>
                    <textarea id="message" name="message" rows="3" required
                        placeholder="Tuliskan pengalaman Anda bersama kami..." maxlength="300"
                        oninput="validateTestiField(this, 'message-count', 'message-error', 300, 'submit-testi-btn')"
                        class="w-full px-4 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        <span id="message-error" class="text-xs text-black hidden">&#10060; Pesan testimoni terlalu
                            panjang</span>
                        @error('message')
                            <span class="text-xs text-black">{{ $message }}</span>
                        @enderror
                        <span id="message-counter" class="text-[10px] text-black ml-auto"><span
                                id="message-count">0</span>/300</span>
                    </div>
                </div>

                <button type="submit" id="submit-testi-btn"
                    class="w-full bg-purple-500 hover:bg-purple-600 text-black font-bold py-3 rounded-xl shadow-lg transition-all transform hover:scale-[1.02]">
                    Kirim Testimoni
                </button>
            </form>
        </div>
    </section>

    <section id="faq" class="py-16 px-10 bg-white">

        <div class="text-center mb-10">
            <span class="bg-purple-400 text-black px-6 py-1 rounded-md font-bold text-sm">
                FAQ
            </span>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">

            @forelse($faqs as $faq)
                <details data-aos="fade-up" class="bg-[#F3F4F6] rounded-xl shadow-sm p-4 group">

                    <summary class="flex justify-between items-center cursor-pointer font-semibold text-black list-none">
                        <span>{{ $faq->question }}</span>

                        <span class="text-black text-xl transition-transform duration-300 group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-3 text-sm text-black leading-relaxed">
                        {{ $faq->answer }}
                    </p>

                </details>
            @empty
                <div class="text-center text-black">
                    Belum ada FAQ tersedia.
                </div>
            @endforelse


    </section>

    <footer class="bg-purple-700 py-10 text-center text-xs text-black">

        <p>
            © 2026 CV Solusi Sentra Globalindo
        </p>

    </footer>

    <a href="#"
        class="fixed bottom-6 right-6 bg-green-500 p-3 rounded-full shadow-xl animate-bounce hover:scale-110 transition">

        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" class="w-8 h-8">

    </a>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
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

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        function updateCart(id, change) {
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
                    if (data.success) {
                        const qtyElement = document.getElementById(`qty-${id}`);
                        let qty = parseInt(qtyElement.innerText);
                        qty += change;
                        if (qty <= 0) {
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

        function validateTestiField(input, countId, errorId, maxLen, btnId) {
            const count = input.value.length;
            const counterEl = document.getElementById(countId);
            const errorMsg = document.getElementById(errorId);
            const submitBtn = document.getElementById(btnId);

            counterEl.textContent = count;

            const isOverLimit = count > maxLen;
            const nameOver = document.getElementById('name').value.length > 100;
            const messageOver = document.getElementById('message').value.length > 300;

            if (isOverLimit) {
                input.classList.add('border-red-500');
                input.classList.remove('border-gray-200');
                errorMsg.classList.remove('hidden');
                document.getElementById(countId).parentElement.classList.add('text-black');
            } else {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-200');
                errorMsg.classList.add('hidden');
                document.getElementById(countId).parentElement.classList.remove('text-black');
            }

            submitBtn.disabled = nameOver || messageOver;
            if (submitBtn.disabled) {
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const name = document.getElementById('name');
            const message = document.getElementById('message');
            if (name) validateTestiField(name, 'name-count', 'name-error', 100, 'submit-testi-btn');
            if (message) validateTestiField(message, 'message-count', 'message-error', 300, 'submit-testi-btn');
        });
    </script>

    @if($errors->any() || session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const testiSection = document.getElementById('testi');
                    if (testiSection) {
                        testiSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 100);
            });
        </script>
    @endif

</body>

</html>