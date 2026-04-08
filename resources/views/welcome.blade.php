<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solusi Sentra Global Indo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .hero-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="flex items-center justify-between px-10 py-4 bg-white/80 backdrop-blur-md sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-black rounded flex items-center justify-center text-white font-bold">CV</div>
            <span class="text-xs font-bold leading-tight">Solusi<br>Sentra Global Indo</span>
        </div>
        <div class="hidden md:flex gap-8 text-gray-700 font-medium">
            <a href="#" class="hover:text-purple-600">Home</a>
            <a href="#" class="hover:text-purple-600">Profile</a>
            <a href="#" class="hover:text-purple-600">Artikel</a>
            <a href="#" class="hover:text-purple-600">Produk</a>
            <a href="#" class="hover:text-purple-600">Testimonials</a>
            <a href="#" class="hover:text-purple-600">FAQ</a>
        </div>
        <div class="bg-purple-300 p-2 rounded-full cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
    </nav>

    <header class="hero-bg h-[600px] flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold text-white max-w-4xl leading-tight mb-8">
            Providing the Best Solutions for Your Service and Goods Needs
        </h1>
        <button class="bg-purple-300 hover:bg-purple-400 text-white px-8 py-3 rounded-full font-semibold transition shadow-lg">
            Learn More
        </button>
    </header>

    <section class="py-16 px-10 relative">
        <div class="text-center mb-12">
            <div class="inline-block bg-purple-200 text-purple-700 px-4 py-1 rounded-t-lg font-bold text-sm">
                Recommended Articles
            </div>
            <div class="bg-purple-500 text-white py-2 px-6 rounded-lg shadow-md -mt-1 relative z-10 font-bold">
                News Update
            </div>
        </div>

        <div class="swiper mySwiper max-w-6xl mx-auto">
            <div class="swiper-wrapper">
                @foreach(range(1, 4) as $item)
                <div class="swiper-slide p-4">
                    <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100">
                        <img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=500" alt="article" class="w-full h-48 object-cover">
                        <div class="p-5">
                            <h3 class="font-bold text-gray-800 mb-4">A symbol of hope for global unity</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    24 Oct 2025
                                </span>
                                <a href="#" class="bg-purple-500 text-white text-xs px-4 py-2 rounded flex items-center gap-2 hover:bg-purple-600">
                                    Read More <span>→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next !text-purple-500"></div>
            <div class="swiper-button-prev !text-purple-500"></div>
        </div>
    </section>

    <a href="https://wa.me/yournumber" class="fixed bottom-8 right-8 bg-green-500 p-3 rounded-full shadow-2xl hover:scale-110 transition-transform z-50">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" class="w-10 h-10" alt="WhatsApp">
    </a>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    </script>
</body>
</html>