<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen FAQ') }}
            </h2>
            <a href="{{ route('faqs.create') }}"
               class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Tambah FAQ
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-[calc(100vh-70px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                    @if ($faqs->isEmpty())
                        <div class="p-6">
                            <p class="text-gray-500 text-center py-8">Belum ada data FAQ. Klik "+ Tambah FAQ" untuk menambahkan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-purple-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-10">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Pertanyaan</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-32">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-16">Urutan</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-32">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($faqs as $index => $faq)
                                        <tr class="hover:bg-purple-50 transition-colors duration-150">
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $faq->question }}</p>
                                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($faq->answer, 100) }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($faq->is_active)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-500 text-center">{{ $faq->order }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('faqs.edit', $faq) }}"
                                                       class="inline-flex items-center px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium rounded-md transition-colors duration-150">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('faqs.destroy', $faq) }}" method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-colors duration-150">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
            </div>

        </div>
    </div>
</x-app-layout>
