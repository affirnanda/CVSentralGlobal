@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-purple-500 dark:border-purple-300 text-sm font-medium leading-5 text-purple-900 dark:text-purple-100 focus:outline-none focus:border-purple-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-black dark:text-purple-300 hover:text-purple-900 dark:hover:text-white hover:border-purple-300 dark:hover:border-purple-600 focus:outline-none focus:text-purple-900 dark:focus:text-white focus:border-purple-300 dark:focus:border-purple-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
