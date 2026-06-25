<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-purple-950 border border-purple-200 dark:border-purple-700 rounded-md font-semibold text-xs text-purple-700 dark:text-purple-200 uppercase tracking-widest shadow-sm hover:bg-purple-50 dark:hover:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-purple-950 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
