<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice {{ $order->invoice_number }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

    <div class="max-w-6xl mx-auto py-10 px-5">
        <div class="mb-6">
            <a href="{{ url('/')}}"
                class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 px-5 py-3 rounded-xl shadow-sm transition font-semibold">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>

        {{-- HEADER --}}
        <div class="bg-gradient-to-r from-purple-500 to-indigo-500 rounded-3xl p-8 text-white shadow-xl mb-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                <div>

                    <h1 class="text-3xl font-extrabold mb-2">
                        INVOICE
                    </h1>

                    <p class="text-sm text-purple-100">
                        {{ $order->invoice_number }}
                    </p>

                </div>

                <div class="text-left md:text-right">

                    <div class="bg-white/20 px-5 py-3 rounded-2xl inline-block">

                        <p class="text-sm">
                            Status Pembayaran
                        </p>

                        <h3 class="font-bold text-xl">
                            MENUNGGU PEMBAYARAN
                        </h3>

                    </div>

                </div>

            </div>

        </div>

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- LEFT CONTENT --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- CUSTOMER --}}
                <div class="bg-white rounded-3xl shadow-lg p-8">

                    <h2 class="text-2xl font-bold mb-6">
                        Data Customer
                    </h2>

                    <div class="grid md:grid-cols-2 gap-5">

                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Nama Lengkap
                            </p>

                            <h3 class="font-semibold">
                                {{ $order->full_name }}
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Email
                            </p>

                            <h3 class="font-semibold">
                                {{ $order->email }}
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                No Handphone
                            </p>

                            <h3 class="font-semibold">
                                {{ $order->phone }}
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Jenis Transaksi
                            </p>

                            <h3 class="font-semibold capitalize">
                                {{ $order->type }}
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Provinsi
                            </p>

                            <h3 class="font-semibold">
                                {{ $order->province }}
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Kota / Kabupaten
                            </p>

                            <h3 class="font-semibold">
                                {{ $order->city }}
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Kecamatan
                            </p>

                            <h3 class="font-semibold">
                                {{ $order->district }}
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Kode Pos
                            </p>

                            <h3 class="font-semibold">
                                {{ $order->postal_code }}
                            </h3>
                        </div>

                        @if($order->type == 'rent')

                            <div>
                                <p class="text-sm text-gray-500 mb-1">
                                    Tanggal Mulai Sewa
                                </p>

                                <h3 class="font-semibold">
                                    {{ \Carbon\Carbon::parse($order->rent_start)->format('d M Y') }}
                                </h3>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 mb-1">
                                    Tanggal Akhir Sewa
                                </p>

                                <h3 class="font-semibold">
                                    {{ \Carbon\Carbon::parse($order->rent_end)->format('d M Y') }}
                                </h3>
                            </div>

                        @endif

                    </div>

                </div>

                @php
                    $rentDays = 0;

                    if ($order->type == 'rent') {
                        $rentDays = \Carbon\Carbon::parse($order->rent_start)
                            ->diffInDays(\Carbon\Carbon::parse($order->rent_end));

                        if ($rentDays < 1) {
                            $rentDays = 1;
                        }
                    }
                @endphp

                {{-- ORDER ITEMS --}}
                <div class="bg-white rounded-3xl shadow-lg p-8">

                    <h2 class="text-2xl font-bold mb-6">
                        Detail Produk
                    </h2>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead>

                                <tr class="border-b">

                                    <th class="text-left py-4">
                                        Produk
                                    </th>

                                    <th class="text-center py-4">
                                        Qty
                                    </th>

                                    <th class="text-center py-4">
                                        Lama Sewa
                                    </th>

                                    <th class="text-right py-4">
                                        Harga
                                    </th>

                                    <th class="text-right py-4">
                                        Subtotal
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($order->items as $item)

                                    <tr class="border-b">

                                        <td class="py-5">

                                            <div class="font-semibold">
                                                {{ $item->product_name }}
                                            </div>

                                        </td>

                                        <td class="text-center">

                                            {{ $item->qty }}

                                        </td>

                                        <td class="text-center">

                                            @if($order->type == 'rent')
                                                {{ $rentDays }} Hari
                                            @else
                                                -
                                            @endif

                                        </td>

                                        <td class="text-right">

                                            @if($order->type == 'rent')
                                                Rp {{ number_format($item->price, 0, ',', '.') }}/hari
                                            @else
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            @endif

                                        </td>

                                        <td class="text-right font-semibold">

                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    {{-- TOTAL --}}
                    <div class="mt-8 flex justify-end">

                        <div class="w-full md:w-[350px] space-y-4">

                            <div class="flex justify-between text-lg">

                                <span>
                                    Total
                                </span>

                                <span class="font-bold text-purple-600">

                                    Rp {{ number_format($order->total, 0, ',', '.') }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="space-y-8">

                {{-- PAYMENT --}}
                <div class="bg-white rounded-3xl shadow-lg p-8">

                    <h2 class="text-2xl font-bold mb-6">
                        Cara Pembayaran
                    </h2>

                    <div class="border rounded-2xl p-5 bg-gray-50">

                        <h3 class="font-bold text-lg mb-4">

                            {{ $order->paymentMethod->bank_name }}

                        </h3>

                        <div class="space-y-4">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Nama Rekening
                                </p>

                                <h4 class="font-semibold text-lg">
                                    {{ $order->paymentMethod->account_name }}
                                </h4>

                            </div>

                            <div>

                                <p class="text-sm text-gray-500">
                                    Nomor Rekening
                                </p>

                                <h4 class="font-bold text-2xl text-purple-600 tracking-wide">
                                    {{ $order->paymentMethod->account_number }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- PAYMENT INSTRUCTION --}}
                <div class="bg-white rounded-3xl shadow-lg p-8">

                    <h2 class="text-2xl font-bold mb-6">
                        Instruksi Pembayaran
                    </h2>

                    <div class="space-y-5 text-sm text-gray-600 leading-relaxed">

                        <div class="flex gap-3">

                            <div
                                class="w-7 h-7 rounded-full bg-purple-500 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                1
                            </div>

                            <p>
                                Transfer sesuai total invoice ke rekening yang tertera.
                            </p>

                        </div>

                        <div class="flex gap-3">

                            <div
                                class="w-7 h-7 rounded-full bg-purple-500 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                2
                            </div>

                            <p>
                                Pastikan nominal transfer sesuai sebelum melakukan transfer.
                            </p>

                        </div>

                        <div class="flex gap-3">

                            <div
                                class="w-7 h-7 rounded-full bg-purple-500 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                3
                            </div>

                            <p>
                                Kirim bukti pembayaran Anda ke Nomor 083854655333.
                            </p>

                        </div>

                        <div class="flex gap-3">

                            <div
                                class="w-7 h-7 rounded-full bg-purple-500 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                4
                            </div>

                            <p>
                                Admin akan memproses pesanan setelah pembayaran dikonfirmasi.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- WHATSAPP --}}
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-3xl shadow-lg p-8 text-white">

                    <h2 class="text-2xl font-bold mb-3">
                        Butuh Bantuan?
                    </h2>

                    <p class="text-sm text-green-100 mb-6">
                        Hubungi admin untuk konfirmasi pembayaran atau pertanyaan lainnya.
                    </p>

                    <a href="https://wa.me/6283854655333?text=Halo%20Admin,%20Saya%20ingin%20konfirmasi%20invoice%20{{ $order->invoice_number }}"
                        target="_blank"
                        class="block w-full bg-white text-green-600 text-center py-4 rounded-2xl font-bold hover:scale-105 transition">

                        Hubungi WhatsApp

                    </a>

                </div>

            </div>

        </div>
    </div>
</body>

</html>