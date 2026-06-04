<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Solusi Sentra Global Indo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card-hover:hover{
            transform:translateY(-10px);
            box-shadow:0 15px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-[#F3F4F6] text-gray-800 flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-white p-8 rounded-3xl shadow-xl border border-purple-100 mx-4 transition-all duration-300 hover:shadow-2xl" data-aos="zoom-in">
        
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Login Admin</h3>
            <p class="text-xs text-gray-500 mt-2">Masuk ke panel admin Solusi Sentra Global Indo</p>
        </div>
        
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-gray-500 mb-1">EMAIL</label>
                <input id="email" type="text" name="email" value="{{ old('email') }}" autofocus autocomplete="username" placeholder="Masukkan email Anda"
                       class="w-full px-4 py-2 rounded-lg bg-gray-50 border {{ $errors->has('email') ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-purple-400' }} focus:outline-none focus:ring-2 text-sm transition-colors">
                @error('email')
                    <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-gray-500 mb-1">PASSWORD</label>
                <input id="password" type="password" name="password" autocomplete="current-password" placeholder="Masukkan password Anda"
                       class="w-full px-4 py-2 rounded-lg bg-gray-50 border {{ $errors->has('password') ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-purple-400' }} focus:outline-none focus:ring-2 text-sm transition-colors">
                @error('password')
                    <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 cursor-pointer" name="remember">
                    <span class="ms-2 text-xs font-semibold text-gray-600">Ingat Saya</span>
                </label>
            </div>

            <button type="submit" 
                    class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 rounded-xl shadow-lg transition-all transform hover:scale-[1.02] mt-6">
                Masuk
            </button>
        </form>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
    <script>
        AOS.init({
            duration:1000,
            once:true
        });
    </script>
</body>
</html>
