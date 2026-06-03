    <x-app-layout>

        <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        Detail Pesanan
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ $order->invoice_number }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center gap-3 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white text-base font-semibold rounded-xl shadow-md transition duration-150">
                    <span class="text-xl">←</span>
                    <span>Kembali</span>
                    </a>

                    @if($order->status == 'pending')

                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            Pending
                        </span>

                    @elseif($order->status == 'paid')

                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Paid
                        </span>

                    @else

                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Rejected
                        </span>

                    @endif

                    <form method="POST"
                        action="{{ route('admin.orders.updateStatus', $order) }}">

                        @csrf
                        @method('PATCH')

                        <select name="status"
                                onchange="this.form.submit()"
                                @disabled(in_array($order->status, ['paid', 'rejected']))
                                class="bg-gray-800 dark:bg-gray-700 text-white border border-gray-600 rounded-lg px-4 py-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            <option value="pending" 
                                    class="bg-gray-800 text-white"
                                    {{ $order->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="paid"
                                    class="bg-gray-800 text-white"
                                    {{ $order->status == 'paid' ? 'selected' : '' }}>
                                Paid
                            </option>

                            <option value="rejected"
                                    class="bg-gray-800 text-white"
                                    {{ $order->status == 'rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>

                        </select>

                    </form>

                </div>

            </div>
        </x-slot>

        <div class="py-10">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if(session('success'))

                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>

                @endif

                <div class="grid lg:grid-cols-2 gap-6 mb-6">

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                        <div class="p-6">

                            <div class="flex items-center gap-3 mb-6">

                                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-xl">
                                    👤
                                </div>

                                <div>

                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Customer
                                    </h3>

                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Informasi customer
                                    </p>

                                </div>

                            </div>

                            <div class="space-y-5">

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        Nama Lengkap
                                    </p>

                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->full_name }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        Email
                                    </p>

                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->email }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        Nomor Handphone
                                    </p>

                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->phone }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        Alamat
                                    </p>

                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->province }},
                                        {{ $order->city }},
                                        {{ $order->district }},
                                        {{ $order->address }},
                                        {{ $order->postal_code }}
                                    </p>
                                </div>

                                @if($order->type == 'rent')

                                    <div class="grid grid-cols-2 gap-4">

                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                                Mulai Sewa
                                            </p>

                                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($order->rent_start)->format('d M Y') }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                                Akhir Sewa
                                            </p>

                                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($order->rent_end)->format('d M Y') }}
                                            </p>
                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                        <div class="p-6">

                            <div class="flex items-center gap-3 mb-6">

                                <div class="w-12 h-12 rounded-xl bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xl">
                                    💳
                                </div>

                                <div>

                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Payment Method
                                    </h3>

                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Metode pembayaran customer
                                    </p>

                                </div>

                            </div>

                            <div class="space-y-5">

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        Nama Bank
                                    </p>

                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->paymentMethod->bank_name }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        Nama Rekening
                                    </p>

                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->paymentMethod->account_name }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        Nomor Rekening
                                    </p>

                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->paymentMethod->account_number }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6">

                        <div class="flex items-center justify-between mb-6">

                            <div>

                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                    Produk Pesanan
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Daftar produk yang dibeli/disewa customer
                                </p>

                            </div>

                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                {{ $order->items->count() }} Produk
                            </span>

                        </div>

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                                <thead class="bg-gray-50 dark:bg-gray-700">

                                    <tr>

                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Produk
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Qty
                                        </th>

                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Subtotal
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                                    @foreach($order->items as $item)

                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">

                                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $item->product_name }}
                                            </td>

                                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item->qty }}
                                            </td>

                                            <td class="px-4 py-4 text-right text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($item->subtotal,0,',','.') }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        <div class="mt-8 flex justify-end">

                            <div class="bg-gray-100 dark:bg-gray-700 rounded-xl px-8 py-5">

                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    Total Pembayaran
                                </p>

                                <p class="text-3xl font-bold text-indigo-700 dark:text-indigo-400">
                                    Rp {{ number_format($order->total,0,',','.') }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </x-app-layout>