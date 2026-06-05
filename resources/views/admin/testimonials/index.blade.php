<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Testimoni</h2>
            <span class="text-sm font-bold text-white tracking-wider">Setujui testimoni agar tampil di landing
                page</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-[calc(100vh-70px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-purple-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Pesan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Rating</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">
                                Aksi</th>
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
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                            ⏳ Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-400">
                                    {{ $t->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.testimonials.approve', $t) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white transition-colors duration-150 {{ $t->is_approved ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-purple-600 hover:bg-purple-700' }}">
                                                {{ $t->is_approved ? 'Sembunyikan' : 'Setujui' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Hapus testimoni ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-colors duration-150">Hapus</button>
                                        </form>
                                    </div>
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