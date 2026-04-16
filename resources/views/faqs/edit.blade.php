<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('faqs.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-150">
                &larr; Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit FAQ') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('faqs.update', $faq) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        {{-- Pertanyaan --}}
                        <div class="mb-5">
                            <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Pertanyaan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="question" name="question"
                                   value="{{ old('question', $faq->question) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('question') border-red-500 @enderror"
                                   placeholder="Masukkan pertanyaan...">
                            @error('question')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jawaban --}}
                        <div class="mb-5">
                            <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Jawaban <span class="text-red-500">*</span>
                            </label>
                            <textarea id="answer" name="answer" rows="5"
                                      class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('answer') border-red-500 @enderror"
                                      placeholder="Masukkan jawaban...">{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Urutan --}}
                        <div class="mb-5">
                            <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Urutan Tampil
                            </label>
                            <input type="number" id="order" name="order"
                                   value="{{ old('order', $faq->order) }}" min="0"
                                   class="w-32 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Angka lebih kecil tampil lebih dulu.</p>
                        </div>

                        {{-- Status Aktif --}}
                        <div class="mb-6">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $faq->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aktifkan FAQ ini</span>
                            </label>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center gap-3">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
                                Update FAQ
                            </button>
                            <a href="{{ route('faqs.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
