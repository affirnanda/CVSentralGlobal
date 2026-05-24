<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Checkout Penyewaan</title>

<script src="https://cdn.tailwindcss.com"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>

<body class="bg-gray-100">

<div class="max-w-7xl mx-auto py-10 px-5">
     <div class="mb-6">
        <a href="{{ url('/')}}"
           class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 px-5 py-3 rounded-xl shadow-sm transition font-semibold">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

<form action="{{ route('checkout.process') }}" method="POST" nonvalidate>

@csrf

<input type="hidden" name="type" value="rent">

<div class="grid lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6">
            Rental Details
        </h2>

        <div class="grid md:grid-cols-2 gap-5">

                <div class="md:col-span-2">
                            <label class="block text-sm font-semibold mb-2">
                                Nama Lengkap
                            </label>

                            <input type="text" 
                            name="full_name" 
                            value="{{ old('full_name') }}" 
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400
                            @error('full_name') border-red-500 @enderror" 
                            placeholder="Masukkan nama lengkap">

                            @error('full_name')
                                <p class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                Email
                            </label>

                            <input type="email" name="email"
                                value="{{ old('email') }}"
                                class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400"
                                @error('email') border-red-500 @enderror"
                                placeholder="Masukkan email">

                                @error('email')
                                <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                                </p>
                                @enderror
                        </div>

                        {{-- PHONE --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                No Handphone
                            </label>

                            <input type="number" name="phone"
                                value="{{ old('phone') }}"
                                class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400"
                                @error('email') border-red-500 @enderror"
                                placeholder="08xxxxxxxxxx">

                                @error('phone')
                                <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                                </p>
                                @enderror
                        </div>

                        {{-- PROVINCE --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                Provinsi
                            </label>

                            <select id="province" name="province"
                            class="w-full border rounded-xl px-4 py-3
                            @error('province') border-red-500 @enderror">

                                <option value="">
                                    Pilih Provinsi
                                </option>

                            </select>
                             @error('province')
                            <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- CITY --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                Kota / Kabupaten
                            </label>

                            <select id="city" name="city"  
                            class="w-full border rounded-xl px-4 py-3 
                            @error('city') border-red-500 @enderror">

                                <option value="">
                                    Pilih Kota
                                </option>

                            </select>
                            @error('city')
                            <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- DISTRICT --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                Kecamatan
                            </label>

                            <select id="district" name="district"  
                            class="w-full border rounded-xl px-4 py-3
                            @error('district') border-red-500 @enderror">

                                <option value="">
                                    Pilih Kecamatan
                                </option>

                            </select>
                            @error('district')
                            <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- POSTAL CODE --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                Kode Pos
                            </label>

                            <input type="number" name="postal_code" 
                            value="{{ old('postal_code') }}"
                            class="w-full border rounded-xl px-4 py-3"
                             @error('postal_code') border-red-500 @enderror
                            placeholder="Kode Pos">
                        
                        @error('postal_code')
                        <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                        </p>
                        @enderror
                        </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Tanggal Mulai Sewa
                        </label>

                        <input type="date"
                            id="rent_start"
                            name="rent_start"
                            min="{{ date('Y-m-d') }}"
                            class="w-full border rounded-xl px-4 py-3">

                        @error('rent_start')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Tanggal Akhir Sewa
                        </label>

                        <input type="date"
                            id="rent_end"
                            name="rent_end"
                            class="w-full border rounded-xl px-4 py-3">

                        @error('rent_end')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                            </div>

                        </div>

    {{-- RIGHT --}}
    <div class="bg-white rounded-2xl shadow p-6 h-fit">

        <h2 class="text-2xl font-bold mb-6">
            Rental Summary
        </h2>

        <div class="space-y-4 border-b pb-5">

            @php $total = 0; @endphp

            @foreach($keranjang as $item)

                @php
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                @endphp

                <div class="flex justify-between items-start">

                    <div>
                        <h3 class="font-semibold text-sm">
                            {{ $item['name'] }}
                        </h3>

                        <p class="text-xs text-gray-500">
                            Qty : {{ $item['qty'] }}
                        </p>
                    </div>

                    <div class="font-bold text-sm">
                        Rp {{ number_format($subtotal,0,',','.') }}
                    </div>

                </div>

            @endforeach

        </div>

        <div class="flex justify-between items-center py-5 border-b">

            <span class="font-bold text-lg">
                Total
            </span>

            <span class="font-bold text-xl text-purple-600">
                Rp {{ number_format($total,0,',','.') }}
            </span>

        </div>

        {{-- PAYMENT --}}
        <div class="py-5">

            <h3 class="font-bold mb-4">
                Payment Method
            </h3>

            <div class="space-y-4">

                @foreach($paymentMethods as $payment)

                <label class="border rounded-xl p-4 flex items-start gap-3 cursor-pointer hover:border-purple-400">

                    <input type="radio"
                           name="payment_method_id"
                           value="{{ $payment->id }}"
                           class="mt-1">

                    <div>

                        <h4 class="font-bold">
                            {{ $payment->name }}
                        </h4>

                        <p class="text-sm text-gray-500">
                            {{ $payment->description }}
                        </p>

                        @if($payment->bank_name)
                        <p class="text-sm mt-1">
                            {{ $payment->bank_name }}
                            -
                            {{ $payment->account_number }}
                        </p>
                        @endif

                    </div>

                </label>

                @endforeach
                @error('payment_method_id')
                <p class="text-red-500 text-sm mt-2">
                {{ $message }}
                </p>
                @enderror
            </div>

        </div>

        <button type="submit"
                class="w-full bg-purple-500 hover:bg-purple-600 transition text-white py-4 rounded-xl font-bold mt-5">

            Order Process

        </button>

    </div>

</div>

</form>

</div>

<script>

const apiKey = "bf3e783e4970efab3e5309bb7a6bff48e915e434dfb00c305c35c63a7b1465c5";

$.get(`https://api.binderbyte.com/wilayah/provinsi?api_key=${apiKey}`,
function(result){

    $.each(result.value, function(i, provinsi){

        $('#province').append(`
            <option value="${provinsi.name}" data-id="${provinsi.id}">
                ${provinsi.name}
            </option>
        `);

    });

});

$('#province').change(function(){

    let id = $(this).find(':selected').data('id');

    $('#city').html('<option>Pilih Kota</option>');

    $('#district').html('<option>Pilih Kecamatan</option>');

    $.get(`https://api.binderbyte.com/wilayah/kabupaten?api_key=${apiKey}&id_provinsi=${id}`,
    function(result){

        $.each(result.value, function(i, kota){

            $('#city').append(`
                <option value="${kota.name}" data-id="${kota.id}">
                    ${kota.name}
                </option>
            `);

        });

    });

});

$('#city').change(function(){
    let id = $(this).find(':selected').data('id');
    $('#district').html('<option>Pilih Kecamatan</option>');
    $.get(`https://api.binderbyte.com/wilayah/kecamatan?api_key=${apiKey}&id_kabupaten=${id}`,
    function(result){
        $.each(result.value, function(i, kecamatan){
            $('#district').append(`
                <option value="${kecamatan.name}">
                    ${kecamatan.name}
                </option>
            `);
        });
    });
});

const today = new Date().toISOString().split('T')[0];
const rentStart = document.getElementById('rent_start');
const rentEnd = document.getElementById('rent_end');
rentStart.min = today;
rentStart.addEventListener('change', function() {
    rentEnd.min = this.value;
    if(rentEnd.value < this.value) {
        rentEnd.value = '';
    }
});

</script>
</body>
</html>