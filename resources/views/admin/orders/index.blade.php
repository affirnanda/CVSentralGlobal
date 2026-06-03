<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Manage Orders') }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola semua pesanan pembelian dan penyewaan
                </p>
            </div>

            {{-- FILTER --}}
            <form method="GET" class="flex flex-row sm:flex-row gap-3">

                <select name="type"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    <option value=""
                    {{ request('type') == '' ? 'selected' : '' }}>
                        Semua Type
                    </option>
                    
                    <option value="buy"
                        {{ request('type') == 'buy' ? 'selected' : '' }}>
                        Pembelian
                    </option>

                    <option value="rent"
                        {{ request('type') == 'rent' ? 'selected' : '' }}>
                        Penyewaan
                    </option>

                </select>

                <select name="status"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    <option value="">
                        Semua Status
                    </option>

                    <option value="pending" class="text-white"
                        {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="paid"
                        {{ request('status') == 'paid' ? 'selected' : '' }}>
                        Paid
                    </option>

                    <option value="rejected"
                        {{ request('status') == 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>

                </select>

                <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-lg font-semibold text-sm text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white transition duration-150">

                    Filter

                </button>

            </form>

        </div>
    </x-slot>

    <div class="py-10">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- FLASH MESSAGE --}}
            @if(session('success'))

                <div class="mb-5 p-4 rounded-lg bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200">

                    {{ session('success') }}

                </div>

            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">

                <div class="p-6">

                    @if($orders->count() > 0)

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                                <thead class="bg-gray-50 dark:bg-gray-700">

                                    <tr>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Invoice
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Customer
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Type
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Total
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status Pengembalian
                                        </th>

                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Action
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                                    @foreach($orders as $order)

                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">

                                            <td class="px-6 py-5">

                                                <div class="font-semibold text-gray-900 dark:text-gray-100">

                                                    {{ $order->invoice_number }}

                                                </div>

                                            </td>

                                            <td class="px-6 py-5">

                                                <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $order->full_name }}
                                                </div>

                                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $order->email }}
                                                </div>

                                            </td>

                                            <td class="px-6 py-5">

                                                @if($order->type == 'buy')

                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">

                                                        Pembelian

                                                    </span>

                                                @else

                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">

                                                        Penyewaan

                                                    </span>

                                                @endif

                                            </td>

                                            <td class="px-6 py-5">

                                                <div class="font-bold text-gray-900 dark:text-gray-100">

                                                    Rp {{ number_format($order->total,0,',','.') }}

                                                </div>

                                            </td>

                                            <td class="px-6 py-5">

                                                @if($order->status == 'pending')

                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">

                                                        Pending

                                                    </span>

                                                @elseif($order->status == 'paid')

                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">

                                                        Paid

                                                    </span>

                                                @else

                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">

                                                        Rejected

                                                    </span>

                                                @endif

                                            </td>

                                            <td class="px-6 py-5">

                                            @if($order->type == 'rent')

                                                <form action="{{ route('admin.orders.updateReturnStatus', $order) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <select name="return_status"
                                                            onchange="this.form.submit()"
                                                            @disabled($order->return_status == 'returned')
                                                            class="border-gray-300 rounded-lg text-sm">

                                                        <option value="not_returned"
                                                            {{ $order->return_status == 'not_returned' ? 'selected' : '' }}>
                                                            Belum Dikembalikan
                                                        </option>

                                                        <option value="returned"
                                                            {{ $order->return_status == 'returned' ? 'selected' : '' }}>
                                                            Sudah Dikembalikan
                                                        </option>

                                                    </select>
                                                </form>

                                            @else

                                                <span class="text-gray-400 text-sm">-</span>

                                            @endif

                                        </td>

                                            <td class="px-6 py-5 text-center">

                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition duration-150">

                                                    Detail

                                                </a>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center py-16">

                            <div class="text-gray-500 dark:text-gray-400 text-lg">

                                Belum ada pesanan

                            </div>

                        </div>

                    @endif

                </div>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">

                {{ $orders->links() }}

            </div>

        </div>

    </div>

</x-app-layout>