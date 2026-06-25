@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-purple-500 dark:border-purple-300 text-start text-base font-medium text-purple-800 dark:text-purple-100 bg-purple-50 dark:bg-purple-900/60 focus:outline-none focus:text-purple-900 dark:focus:text-white focus:bg-purple-100 dark:focus:bg-purple-900 focus:border-purple-700 dark:focus:border-purple-200 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-purple-600 dark:text-purple-300 hover:text-purple-900 dark:hover:text-white hover:bg-purple-50 dark:hover:bg-purple-900 hover:border-purple-300 dark:hover:border-purple-700 focus:outline-none focus:text-purple-900 dark:focus:text-white focus:bg-purple-50 dark:focus:bg-purple-900 focus:border-purple-300 dark:focus:border-purple-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
