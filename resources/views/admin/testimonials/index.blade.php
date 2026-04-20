<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Testimoni</h2>
            <span class="text-sm text-gray-500">Setujui testimoni agar tampil di landing page</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pesan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($testimonials as $t)
                        <tr class="{{ $t->is_approved ? '' : 'bg-yellow-50' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $t->name ?? 'Anonim' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">
                                {{ Str::limit($t->message, 80) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $t->rating ? '★' : '☆' }}
                                @endfor
                            </td>
                            <td class="px-6 py-4">
                                @if($t->is_approved)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        ✓ Ditampilkan
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                        ⏳ Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-400">
                                {{ $t->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                {{-- Toggle Approve --}}
                                <form action="{{ route('admin.testimonials.approve', $t) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="{{ $t->is_approved ? 'text-yellow-600 hover:underline' : 'text-green-600 hover:underline' }}">
                                        {{ $t->is_approved ? 'Sembunyikan' : 'Setujui' }}
                                    </button>
                                </form>
                                {{-- Hapus --}}
                                <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus testimoni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                Belum ada testimoni masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $testimonials->links() }}</div>
            </div>

        </div>
    </div>
</x-app-layout>
