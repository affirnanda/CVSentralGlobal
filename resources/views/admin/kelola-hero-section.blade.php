<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Hero Section') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.hero-section.update') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Hero Title -->
                        <div class="mb-4">
                            <x-input-label for="hero_title" :value="__('Hero Title (Opsional)')" />
                            <x-text-input id="hero_title" class="block mt-1 w-full" type="text" name="hero_title" :value="old('hero_title', $data['hero_title'] ?? '')" autofocus />
                            <x-input-error :messages="$errors->get('hero_title')" class="mt-2" />
                        </div>

                        <!-- Hero Subtitle -->
                        <div class="mb-4">
                            <x-input-label for="hero_subtitle" :value="__('Hero Subtitle')" />
                            <textarea id="hero_subtitle" name="hero_subtitle" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3">{{ old('hero_subtitle', $data['hero_subtitle'] ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('hero_subtitle')" class="mt-2" />
                        </div>

                        <!-- Hero Image -->
                        <div class="mb-4">
                            <x-input-label for="hero_image" :value="__('Hero Image')" />
                            <input type="file" id="hero_image" name="hero_image" class="block mt-1 w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-indigo-300">
                            <x-input-error :messages="$errors->get('hero_image')" class="mt-2" />
                            
                            @if(!empty($data['hero_image']))
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Current image:</p>
                                    <img src="{{ asset('storage/landing/' . $data['hero_image']) }}" alt="Hero Image" class="max-w-[200px] rounded shadow-sm">
                                </div>
                            @endif
                        </div>

                        <!-- Section Text -->
                        <div class="mb-4">
                            <x-input-label for="section_text" :value="__('Additional Section Text (Optional)')" />
                            <textarea id="section_text" name="section_text" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3">{{ old('section_text', $data['section_text'] ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('section_text')" class="mt-2" />
                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-700">
                        <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-200">Bagian Profile (Berpengalaman di Bidangnya)</h3>

                        <!-- Profile Title -->
                        <div class="mb-4">
                            <x-input-label for="profile_title" :value="__('Profile Title (Opsional)')" />
                            <x-text-input id="profile_title" class="block mt-1 w-full" type="text" name="profile_title" :value="old('profile_title', $data['profile_title'] ?? '')" />
                            <x-input-error :messages="$errors->get('profile_title')" class="mt-2" />
                        </div>

                        <!-- Profile Image -->
                        <div class="mb-4">
                            <x-input-label for="profile_image" :value="__('Profile Image (Opsional)')" />
                            <input type="file" id="profile_image" name="profile_image" class="block mt-1 w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-indigo-300">
                            <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
                            
                            @if(!empty($data['profile_image']))
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Current profile image:</p>
                                    <img src="{{ asset('storage/landing/' . $data['profile_image']) }}" alt="Profile Image" class="max-w-[200px] rounded shadow-sm">
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
