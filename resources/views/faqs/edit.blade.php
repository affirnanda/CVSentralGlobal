<head>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('faqs.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors duration-150">
                &larr; Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit FAQ') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-[calc(100vh-70px)]">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">
                    <form action="{{ route('faqs.update', $faq) }}" method="POST" novalidate>
                        @csrf
                        @method('PATCH')

                        <div class="mb-5">
                            <label for="question" class="block text-sm font-medium text-gray-700 mb-1">
                                Pertanyaan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="question" name="question" required
                                   value="{{ old('question', $faq->question) }}"
                                   maxlength="100"
                                   oninput="validateField(this, 'question-count', 'question-error', 100, 'submit-btn')"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('question') border-red-500 @enderror"
                                   placeholder="Masukkan pertanyaan (maks. 100 karakter)...">
                            <div class="flex justify-between items-center mt-1">
                                <span id="question-error" class="text-sm text-red-500 hidden">&#10060; Pertanyaan terlalu panjang</span>
                                @error('question')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                                <span id="question-counter" class="text-xs text-gray-400 ml-auto"><span id="question-count">0</span>/100</span>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="answer" class="block text-sm font-medium text-gray-700 mb-1">
                                Jawaban <span class="text-red-500">*</span>
                            </label>
                            <textarea id="answer" name="answer" rows="5" required
                                      maxlength="300"
                                      oninput="validateField(this, 'answer-count', 'answer-error', 300, 'submit-btn')"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('answer') border-red-500 @enderror"
                                      placeholder="Masukkan jawaban (maks. 300 karakter)...">{{ old('answer', $faq->answer) }}</textarea>
                            <div class="flex justify-between items-center mt-1">
                                <span id="answer-error" class="text-sm text-red-500 hidden">&#10060; Jawaban terlalu panjang</span>
                                @error('answer')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                                <span id="answer-counter" class="text-xs text-gray-400 ml-auto"><span id="answer-count">0</span>/300</span>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                                Urutan Tampil
                            </label>
                            <select id="order" name="order" class="w-32 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                @for($i = 1; $i <= $maxOrder; $i++)
                                    <option value="{{ $i }}" {{ old('order', $faq->order) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Pilih posisi urutan FAQ ini.</p>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $faq->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500">
                                <span class="text-sm font-medium text-gray-700">Aktifkan FAQ ini</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" id="submit-btn"
                                    class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 transition ease-in-out duration-150">
                                Update FAQ
                            </button>
                            <a href="{{ route('faqs.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-700 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateField(input, countId, errorId, maxLen, btnId) {
            const count = input.value.length;
            const counterEl = document.getElementById(countId);
            const errorMsg = document.getElementById(errorId);
            const submitBtn = document.getElementById(btnId);

            counterEl.textContent = count;

            const isOverLimit = count > maxLen;

            const questionOver = document.getElementById('question').value.length > 100;
            const answerOver   = document.getElementById('answer').value.length > 300;

            if (isOverLimit) {
                input.classList.add('border-red-500');
                input.classList.remove('border-gray-300');
                errorMsg.classList.remove('hidden');
            } else {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
                errorMsg.classList.add('hidden');
            }

            submitBtn.disabled = questionOver || answerOver;
            if (submitBtn.disabled) {
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const question = document.getElementById('question');
            const answer   = document.getElementById('answer');
            if (question) validateField(question, 'question-count', 'question-error', 100, 'submit-btn');
            if (answer)   validateField(answer,   'answer-count',   'answer-error',   300, 'submit-btn');
        });
    </script>

</x-app-layout>
