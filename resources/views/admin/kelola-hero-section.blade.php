<head>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Hero Section') }}
        </h2>
    </x-slot>

    @if (session('status'))
<<<<<<< HEAD
    <div id="popup-success"
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm"
         onclick="if(event.target===this)closePopup('popup-success')">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center animate-[popIn_0.3s_ease-out]">
            <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mx-auto mb-4">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">Berhasil Disimpan!</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ session('status') }}</p>
            <button onclick="closePopup('popup-success')"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-xl transition">
                OK
            </button>
=======
        <div id="popup-success" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm"
            onclick="if(event.target===this)closePopup('popup-success')">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center animate-[popIn_0.3s_ease-out]">
                <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">Berhasil Disimpan!</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ session('status') }}</p>
                <button onclick="closePopup('popup-success')"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-xl transition">
                    OK
                </button>
            </div>
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
        </div>
    @endif

    @if ($errors->any())
<<<<<<< HEAD
    <div id="popup-error"
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm"
         onclick="if(event.target===this)closePopup('popup-error')">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center animate-[popIn_0.3s_ease-out]">
            <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mx-auto mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">Input Tidak Valid!</h3>
            <ul class="text-sm text-red-500 text-left space-y-1 mb-6 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button onclick="closePopup('popup-error')"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-xl transition">
                Tutup &amp; Perbaiki
            </button>
=======
        <div id="popup-error" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm"
            onclick="if(event.target===this)closePopup('popup-error')">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center animate-[popIn_0.3s_ease-out]">
                <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">Input Tidak Valid!</h3>
                <ul class="text-sm text-red-500 text-left space-y-1 mb-6 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button onclick="closePopup('popup-error')"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-xl transition">
                    Tutup &amp; Perbaiki
                </button>
            </div>
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
        </div>
    @endif

    <style>
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.85); }
            to   { opacity: 1; transform: scale(1); }
        }
    </style>

    <script>
        function closePopup(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        }
<<<<<<< HEAD
        // Auto-tutup popup sukses setelah 4 detik
=======
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
        document.addEventListener('DOMContentLoaded', function () {
            const s = document.getElementById('popup-success');
            if (s) setTimeout(() => s.style.display = 'none', 4000);
        });
    </script>

    <div class="py-12 bg-gray-50 min-h-[calc(100vh-70px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('admin.hero-section.update') }}" enctype="multipart/form-data">
                        @csrf

<<<<<<< HEAD
                        {{-- ===== HERO SECTION ===== --}}
                        <h3 class="text-base font-bold mb-4 text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">
                             Hero Section
=======
                        <h3 class="text-base font-bold mb-4 text-purple-600 uppercase tracking-wide border-b pb-2">
                            Hero Section
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
                        </h3>

                        <div class="mb-4">
<<<<<<< HEAD
                            <x-input-label for="hero_title" :value="__('Hero Title')" />
                            <x-text-input id="hero_title" class="block mt-1 w-full {{ $errors->has('hero_title') ? 'border-red-500 ring-red-500' : '' }}"
                                          type="text" name="hero_title"
                                          :value="old('hero_title', $data['hero_title'] ?? '')"
                                          autofocus />
                        </div>

                        <!-- Hero Subtitle -->
                        <div class="mb-4">
                            <x-input-label for="hero_subtitle" :value="__('Hero Subtitle')" />
                            <textarea id="hero_subtitle" name="hero_subtitle" rows="3"
                                      class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('hero_subtitle') ? 'border-red-500 ring-red-500' : '' }}"
                            >{{ old('hero_subtitle', $data['hero_subtitle'] ?? '') }}</textarea>
                        </div>

                        <!-- Hero Image -->
                        <div class="mb-4">
                            <x-input-label for="hero_image" :value="__('Hero Image (jpg, jpeg, png, maks. 2 MB)')" />
                            <input type="file" id="hero_image" name="hero_image" accept=".jpg,.jpeg,.png"
                                   class="block mt-1 w-full text-sm text-gray-500 dark:text-gray-300
=======
                            <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-1">Judul Hero
                                Section <span class="text-red-500">*</span></label>
                            <input id="hero_title"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 {{ $errors->has('hero_title') ? 'border-red-500 ring-red-500' : '' }}"
                                type="text" name="hero_title" value="{{ old('hero_title', $data['hero_title'] ?? '') }}"
                                autofocus />
                            <p id="hero_title_counter" class="text-xs text-gray-400 mt-1 text-right">0/100</p>
                        </div>

                        <div class="mb-8">
                            <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-1">Gambar
                                Background Hero Section (jpg, jpeg, png, maks. 2 MB)</label>
                            <input type="file" id="hero_image" name="hero_image" accept=".jpg,.jpeg,.png" class="block mt-1 w-full text-sm text-gray-500
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
                                          file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                          file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700
                                          hover:file:bg-purple-100
                                          {{ $errors->has('hero_image') ? 'border border-red-500 rounded' : '' }}">
                            <p id="hero_image_hint" class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG. Ukuran
                                file maks: 2 MB. <br><span class="font-semibold text-purple-600">Rekomendasi
                                    Resolusi:</span> 1920 x 1080 piksel (Rasio 16:9) agar layar tertutupi sempurna.</p>
                            @if(!empty($data['hero_image']))
                                <div class="mt-2">
<<<<<<< HEAD
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/landing/' . $data['hero_image']) }}" alt="Hero Image" class="max-w-[200px] rounded shadow-sm">
=======
                                    <p class="text-sm text-gray-500 mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/landing/' . $data['hero_image']) }}" alt="Hero Image"
                                        class="max-w-[200px] rounded shadow-sm border">
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
                                </div>
                            @endif
                        </div>

<<<<<<< HEAD
                        <!-- Section Text -->
                        <div class="mb-4">
                            <x-input-label for="section_text" :value="__('Teks Tambahan Seksi')" />
                            <textarea id="section_text" name="section_text" rows="3"
                                      class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('section_text') ? 'border-red-500 ring-red-500' : '' }}"
                            >{{ old('section_text', $data['section_text'] ?? '') }}</textarea>
                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-700">

                        {{-- ===== PROFILE SECTION ===== --}}
                        <h3 class="text-base font-bold mb-4 text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">
                            Bagian Profile (Berpengalaman di Bidangnya)
=======
                        <h3 class="text-base font-bold mb-4 text-purple-600 uppercase tracking-wide border-b pb-2">
                            Bagian Profile (About Us)
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
                        </h3>

                        <div class="mb-4">
<<<<<<< HEAD
                            <x-input-label for="profile_title" :value="__('Profile Title')" />
                            <x-text-input id="profile_title" class="block mt-1 w-full {{ $errors->has('profile_title') ? 'border-red-500 ring-red-500' : '' }}"
                                          type="text" name="profile_title"
                                          :value="old('profile_title', $data['profile_title'] ?? '')" />
=======
                            <label for="profile_title" class="block text-sm font-medium text-gray-700 mb-1">Judul
                                Profile <span class="text-red-500">*</span></label>
                            <input id="profile_title"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 {{ $errors->has('profile_title') ? 'border-red-500 ring-red-500' : '' }}"
                                type="text" name="profile_title"
                                value="{{ old('profile_title', $data['profile_title'] ?? '') }}" />
                            <p id="profile_title_counter" class="text-xs text-gray-400 mt-1 text-right">0/100</p>
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
                        </div>

                        <div class="mb-4">
<<<<<<< HEAD
                            <x-input-label for="profile_image" :value="__('Profile Image (jpg, jpeg, png, maks. 2 MB)')" />
                            <input type="file" id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png"
                                   class="block mt-1 w-full text-sm text-gray-500 dark:text-gray-300
=======
                            <label for="section_text" class="block text-sm font-medium text-gray-700 mb-1">Paragraf
                                Profile <span class="text-red-500">*</span></label>
                            <textarea id="section_text" name="section_text" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm {{ $errors->has('section_text') ? 'border-red-500 ring-red-500' : '' }}">{{ old('section_text', $data['section_text'] ?? '') }}</textarea>
                            <p id="section_text_counter" class="text-xs text-gray-400 mt-1 text-right">0/255</p>
                        </div>

                        <div class="mb-8">
                            <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">Gambar
                                Profile (jpg, jpeg, png, maks. 2 MB)</label>
                            <input type="file" id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png" class="block mt-1 w-full text-sm text-gray-500
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
                                          file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                          file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700
                                          hover:file:bg-purple-100
                                          {{ $errors->has('profile_image') ? 'border border-red-500 rounded' : '' }}">
                            <p id="profile_image_hint" class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG. Ukuran
                                file maks: 2 MB. <br><span class="font-semibold text-purple-600">Rekomendasi
                                    Resolusi:</span> 800 x 800 piksel (Persegi) atau 800 x 1000 piksel (Potret).</p>
                            @if(!empty($data['profile_image']))
                                <div class="mt-2">
<<<<<<< HEAD
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/landing/' . $data['profile_image']) }}" alt="Profile Image" class="max-w-[200px] rounded shadow-sm">
=======
                                    <p class="text-sm text-gray-500 mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/landing/' . $data['profile_image']) }}" alt="Profile Image"
                                        class="max-w-[200px] rounded shadow-sm border">
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 transition ease-in-out duration-150">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function fileGuard(inputId, hintId, maxMb) {
            const input = document.getElementById(inputId);
            if (!input) return;
            input.addEventListener('change', function () {
                const file = this.files[0];
                const hint = document.getElementById(hintId);
                if (!file) return;

                const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (!allowedExtensions.exec(this.value)) {
                    showClientPopup(`Format file "${file.name}" tidak didukung. Harap gunakan format JPG, JPEG, atau PNG.`);
                    this.value = '';
                    if (hint) hint.classList.add('text-red-500');
                    return;
                }

                if (file.size > maxMb * 1024 * 1024) {
                    showClientPopup(`File "${file.name}" terlalu besar (${(file.size / 1024 / 1024).toFixed(2)} MB). Maksimum ${maxMb} MB.`);
                    this.value = '';
                    if (hint) hint.classList.add('text-red-500');
                } else {
                    if (hint) hint.classList.remove('text-red-500');
                }
            });
        }
        fileGuard('hero_image',    'hero_image_hint',    2);
        fileGuard('profile_image', 'profile_image_hint', 2);

<<<<<<< HEAD
        // Client-side popup untuk error file sebelum submit

            function showClientPopup(msg) {
    const overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.4);backdrop-filter:blur(4px)';
    overlay.innerHTML = `
=======
        function showClientPopup(msg) {
            const overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.4);backdrop-filter:blur(4px)';
            overlay.innerHTML = `
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
        <div style="background:#fff;border-radius:1rem;padding:2rem;max-width:360px;width:90%;text-align:center;box-shadow:0 25px 50px rgba(0,0,0,.2)">
            <div style="width:64px;height:64px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
                <svg width="32" height="32" fill="none" stroke="#ef4444" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <h3 style="font-weight:700;font-size:1.1rem;margin-bottom:.5rem;color:#1f2937">File Tidak Valid!</h3>
            <p style="font-size:.875rem;color:#6b7280;margin-bottom:1.5rem">${msg}</p>
            <button onclick="this.closest('[style]').remove()"
                    style="width:100%;background:#ef4444;color:#fff;font-weight:600;padding:.6rem 0;border-radius:.75rem;border:none;cursor:pointer">
                OK, Mengerti
            </button>
        </div>`;
    document.body.appendChild(overlay);
    overlay.addEventListener('click', e => { if (e.target === overlay) overlay.remove(); });
}

<<<<<<< HEAD
// Monitor hero title length and update counter
const heroTitleInput = document.getElementById('hero_title');
if (heroTitleInput) {
    const counterEl = document.getElementById('hero_title_counter');
    heroTitleInput.addEventListener('input', function () {
        const max = 100;
        const len = this.value.length;
        if (counterEl) {
            counterEl.textContent = `${len}/${max}`;
        }
        if (len > max) {
            showClientPopup('Judul Hero terlalu panjang. Maksimum 100 karakter.');
=======
        function monitorLength(inputId, counterId, maxLen, errorMsg) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            if (!input || !counter) return;

            const initLen = input.value.length;
            counter.textContent = `${initLen}/${maxLen}`;

            input.addEventListener('input', function () {
                const len = this.value.length;
                counter.textContent = `${len}/${maxLen}`;
                if (len > maxLen) {
                    showClientPopup(errorMsg);
                    this.value = this.value.substring(0, maxLen);
                    counter.textContent = `${maxLen}/${maxLen}`;
                }
            });
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
        }
    });
}
 // Monitor profile title length and show popup if exceeds 255 characters
 const profileTitleInput = document.getElementById('profile_title');
 if (profileTitleInput) {
     profileTitleInput.addEventListener('input', function () {
         const max = 255;
         if (this.value.length > max) {
             showClientPopup('Judul Profile terlalu panjang. Maksimum 255 karakter.');
         }
     });
 }

<<<<<<< HEAD
            overlay.style.cssText = 'position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.4);backdrop-filter:blur(4px)';
            overlay.innerHTML = `
                <div style="background:#fff;border-radius:1rem;padding:2rem;max-width:360px;width:90%;text-align:center;box-shadow:0 25px 50px rgba(0,0,0,.2)">
                    <div style="width:64px;height:64px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
                        <svg width="32" height="32" fill="none" stroke="#ef4444" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <h3 style="font-weight:700;font-size:1.1rem;margin-bottom:.5rem;color:#1f2937">File Tidak Valid!</h3>
                    <p style="font-size:.875rem;color:#6b7280;margin-bottom:1.5rem">${msg}</p>
                    <button onclick="this.closest('[style]').remove()"
                            style="width:100%;background:#ef4444;color:#fff;font-weight:600;padding:.6rem 0;border-radius:.75rem;border:none;cursor:pointer">
                        OK, Mengerti
                    </button>
                </div>`;
            document.body.appendChild(overlay);
            overlay.addEventListener('click', e => { if (e.target === overlay) overlay.remove(); });
        
=======
        monitorLength('hero_title', 'hero_title_counter', 100, 'Judul hero section terlalu panjang');
        monitorLength('profile_title', 'profile_title_counter', 100, 'Judul profile terlalu panjang');
        monitorLength('section_text', 'section_text_counter', 255, 'Paragraf profile terlalu panjang');

        document.querySelector('form').addEventListener('submit', function (e) {
            const heroTitle = document.getElementById('hero_title').value.trim();
            const profileTitle = document.getElementById('profile_title').value.trim();
            const sectionText = document.getElementById('section_text').value.trim();

            if (!heroTitle) {
                e.preventDefault();
                showClientPopup('Judul hero section tidak boleh kosong');
                return;
            }
            if (!profileTitle) {
                e.preventDefault();
                showClientPopup('Judul profile tidak boleh kosong');
                return;
            }
            if (!sectionText) {
                e.preventDefault();
                showClientPopup('Paragraf profile tidak boleh kosong');
                return;
            }
        });
>>>>>>> d6b921aaee86fcfea0c3bacc79468018fa6023f5
    </script>
</x-app-layout>
