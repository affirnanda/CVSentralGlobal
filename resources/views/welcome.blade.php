<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Solusi Sentra Global Indo</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>

<style>
.hero-bg{
background:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),
url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1200');
background-size:cover;
background-position:center;
}

.card-hover:hover{
transform:translateY(-10px);
box-shadow:0 15px 25px rgba(0,0,0,0.15);
}

.product-hover:hover{
transform:scale(1.05);
}

html{
scroll-behavior:smooth;
}
</style>

</head>

<body class="bg-[#F3F4F6] text-gray-800">

@if(session('success'))
<div id="flash-success"
     class="fixed top-5 right-5 z-[9999] bg-green-500 text-white px-6 py-3 rounded-xl shadow-xl flex items-center gap-3 transition-all duration-500">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span class="text-sm font-semibold">{{ session('success') }}</span>
    <button onclick="document.getElementById('flash-success').remove()" class="ml-2 text-white hover:text-green-100 font-bold text-lg leading-none">&times;</button>
</div>
<script>
    setTimeout(function() {
        var el = document.getElementById('flash-success');
        if (el) el.style.opacity = '0', setTimeout(() => el.remove(), 500);
    }, 4000);
</script>
@endif

<!-- NAVBAR -->

<nav class="flex items-center justify-between px-10 py-4 bg-white sticky top-0 z-50 shadow-sm">

<div class="flex items-center gap-2">
<div class="w-8 h-8 bg-black rounded text-white flex items-center justify-center font-bold">CV</div>
<span class="text-[10px] font-bold leading-tight">
Solusi<br>Sentra Global Indo
</span>
</div>

<div class="hidden md:flex gap-8 text-sm font-semibold text-gray-600">
<a href="#home">Dashboard</a>
<a href="#profile">Profile</a>
<a href="#produk">Produk</a>
<a href="#testi">Testimonials</a>
<a href="#faq">FAQ</a>
</div>

<div class="flex items-center">
    <div class="relative cursor-pointer transition-transform hover:scale-105">
        <div class="w-10 h-10 bg-[#C7D2FE] rounded-full flex items-center justify-center shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>

        <div class="absolute -top-1 -right-1 w-5 h-5 bg-white border-2 border-[#C7D2FE] rounded-full flex items-center justify-center hidden">
            </div>
    </div>
</div>

</nav>

<!-- HERO -->
<header class="hero-bg h-[500px] flex flex-col items-center justify-center text-center px-6">

<h1 data-aos="zoom-in"
class="text-3xl md:text-5xl font-extrabold text-white max-w-3xl mb-6">
The Best Solution for Your Bussines
</h1>

<button data-aos="fade-up" data-aos-delay="300"
class="bg-purple-400 hover:bg-purple-500 text-white px-8 py-2 rounded-full font-bold shadow-lg transition hover:scale-110">
Learn More
</button>

</header>

<!-- PROFILE -->
<section id="profile" class="py-16 px-10 bg-white">

<div class="max-w-6xl mx-auto">

<div class="grid md:grid-cols-2 gap-10 items-center">

<div data-aos="fade-right">

<h2 class="text-2xl font-bold mb-4 border-l-4 border-purple-500 pl-4">
Berpengalaman di bidangnya selama 5 tahun
</h2>

<p class="text-gray-500 text-sm leading-relaxed mb-6">
Lorem Ipsum is simply dummy text of the printing and typesetting industry.
</p>

<div class="grid grid-cols-3 gap-4 text-center">

<div>
<div class="text-xl font-bold text-purple-600">1500+</div>
<div class="text-[10px] text-gray-400">Users</div>
</div>

<div>
<div class="text-xl font-bold text-purple-600">1200+</div>
<div class="text-[10px] text-gray-400">Partners</div>
</div>

<div>
<div class="text-xl font-bold text-purple-600">1800+</div>
<div class="text-[10px] text-gray-400">Products</div>
</div>

</div>

</div>

<div data-aos="fade-left" class="rounded-xl overflow-hidden shadow-2xl">
<img src="https://www.shutterstock.com/image-photo/asian-staff-member-meeting-customer-600nw-2672747739.jpg">
</div>

</div>

</div>

</section>

<!-- LAYANAN -->
<section class="py-16 bg-[#E9E9FF] px-10">

<div class="text-center mb-10">
<span class="bg-purple-400 text-white px-6 py-1 rounded-md font-bold text-sm">
Layanan Kami
</span>
</div>

<div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6">

<div data-aos="flip-left" class="bg-white p-6 rounded-2xl text-center transition card-hover">

<div class="text-3xl mb-4">🏠</div>

<h3 class="font-bold mb-2">Express Service</h3>

<p class="text-xs text-gray-400 mb-4">
Layanan cepat dengan kualitas terbaik
</p>

</div>

<div data-aos="flip-left" data-aos-delay="200"
class="bg-white p-6 rounded-2xl text-center transition card-hover">

<div class="text-3xl mb-4">🔧</div>

<h3 class="font-bold mb-2">Maintenance</h3>

<p class="text-xs text-gray-400 mb-4">
Perawatan rutin untuk perangkat Anda
</p>

</div>

<div data-aos="flip-left" data-aos-delay="400"
class="bg-white p-6 rounded-2xl text-center transition card-hover">

<div class="text-3xl mb-4">📞</div>

<h3 class="font-bold mb-2">Help Desk</h3>

<p class="text-xs text-gray-400 mb-4">
Dukungan teknis kapan saja
</p>

</div>

</div>

</section>

<!-- PRODUCT -->
<section id="produk" class="py-16 px-10 bg-white">

    <div class="text-center mb-10">
        <a href="{{ route('katalog.index') }}" class="inline-block transition hover:scale-105">
            <span class="bg-purple-400 text-white px-6 py-1 rounded-md font-bold text-sm">
                Catalog Product
            </span>
        </a>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div data-aos="zoom-in" class="bg-white border rounded-xl p-3 shadow-sm transition product-hover">

            <img src="{{ asset('storage/' . $product->image) }}"
                 class="w-full h-32 object-cover rounded-lg mb-3"
                 onerror="this.src='https://images.unsplash.com/photo-1526733158272-60b4944e8d52?q=80&w=200'">

            <h4 class="text-xs font-bold mb-1">{{ $product->name }}</h4>

            <p class="text-[10px] text-gray-400 mb-2">
                {{ \Illuminate\Support\Str::limit($product->description, 50) }}
            </p>

            <div class="text-orange-500 font-bold text-xs">
                IDR {{ number_format($product->price, 0, ',', '.') }}
            </div>

        </div>
        @empty
        <div class="col-span-4 text-center py-10 text-gray-400 text-sm">
            Belum ada produk. Tambahkan produk melalui panel admin.
        </div>
        @endforelse
    </div>

</section>

<!-- TESTIMONIAL -->
<section id="testi" class="py-16 bg-[#E9E9FF] px-10">

    <div class="text-center mb-10">
        <span class="bg-purple-400 text-white px-6 py-1 rounded-md font-bold text-sm">
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
                        <h5 class="text-sm font-bold text-gray-800">{{ $t->name }}</h5>
                        <div class="text-yellow-400 text-xs">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $t->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-600 italic leading-relaxed">
                    "{{ $t->message }}"
                </p>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-400 italic">
                Belum ada testimoni yang disetujui.
            </div>
        @endforelse
    </div>

    <!-- FORM KIRIM TESTIMONI -->
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl shadow-xl border border-purple-100" data-aos="zoom-in">
        <h3 class="text-xl font-bold text-center mb-6 text-gray-800">Kirim Testimoni Anda</h3>
        
        <form action="{{ route('testimonials.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">NAMA ANDA</label>
                <input type="text" name="name" required placeholder="Masukkan nama lengkap"
                       class="w-full px-4 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">RATING</label>
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
                <label class="block text-xs font-bold text-gray-500 mb-1">PESAN / TESTIMONI</label>
                <textarea name="message" rows="3" required placeholder="Tuliskan pengalaman Anda bersama kami..."
                          class="w-full px-4 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm"></textarea>
            </div>

            <button type="submit" 
                    class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 rounded-xl shadow-lg transition-all transform hover:scale-[1.02]">
                Kirim Testimoni
            </button>
        </form>
    </div>
</section>

    <!-- FAQ -->
<section id="faq" class="py-16 px-10 bg-white">

    <div class="text-center mb-10">
        <span class="bg-purple-400 text-white px-6 py-1 rounded-md font-bold text-sm">
            FAQ
        </span>
    </div>

    <div class="max-w-4xl mx-auto space-y-4">

        @forelse($faqs as $faq)
    <details data-aos="fade-up" class="bg-[#F3F4F6] rounded-xl shadow-sm p-4 group">

        <!-- Question -->
        <summary class="flex justify-between items-center cursor-pointer font-semibold text-gray-700 list-none">
            <span>{{ $faq->question }}</span>

            <!-- Icon -->
            <span class="text-purple-500 text-xl transition-transform duration-300 group-open:rotate-45">
                +
            </span>
        </summary>

        <!-- Answer -->
        <p class="mt-3 text-sm text-gray-500 leading-relaxed">
            {{ $faq->answer }}
        </p>

    </details>
@empty
    <div class="text-center text-gray-400">
        Belum ada FAQ tersedia.
    </div>
@endforelse
    

</section>

<!-- FOOTER -->
<footer class="bg-gray-100 py-10 text-center text-xs text-gray-500">

<p>
© 2026 CV Solusi Sentra Globalindo
</p>

</footer>

<!-- WHATSAPP BUTTON -->
<a href="#"
class="fixed bottom-6 right-6 bg-green-500 p-3 rounded-full shadow-xl animate-bounce hover:scale-110 transition">

<img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
class="w-8 h-8">

</a>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
AOS.init({
duration:1000,
once:true
});
</script>

</body>
</html>
