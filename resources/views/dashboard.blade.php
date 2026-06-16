<head>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-[calc(100vh-70px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-500">Pilih menu di bawah ini untuk mengelola berbagai fitur website Solusi Sentral Global Indo.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('profile.edit') }}" class="block p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-purple-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Kelola Profile</h4>
                            <p class="text-sm text-gray-500 mt-1">Ubah informasi akun admin.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.products.index') }}" class="block p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-purple-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Kelola Produk</h4>
                            <p class="text-sm text-gray-500 mt-1">Tambah, edit, hapus data produk.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="block p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-purple-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Kelola Pesanan</h4>
                            <p class="text-sm text-gray-500 mt-1">Pantau dan update status pesanan.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('faqs.index') }}" class="block p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-purple-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Kelola FAQ</h4>
                            <p class="text-sm text-gray-500 mt-1">Atur daftar tanya jawab (FAQ).</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="block p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-purple-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Kelola Testimoni</h4>
                            <p class="text-sm text-gray-500 mt-1">Persetujuan & hapus testimoni.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.hero-section.manage') }}" class="block p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-purple-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Hero Section</h4>
                            <p class="text-sm text-gray-500 mt-1">Ubah tampilan awal website.</p>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>

