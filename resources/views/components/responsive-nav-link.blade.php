@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-blue-600 text-start text-base font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 focus:outline-none focus:text-blue-800 dark:focus:text-blue-300 focus:bg-blue-100 dark:focus:bg-blue-900/30 focus:border-blue-700 dark:focus:border-blue-500 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5 hover:border-slate-300 dark:hover:border-slate-700 focus:outline-none focus:text-slate-800 dark:focus:text-slate-200 focus:bg-slate-50 dark:focus:bg-white/5 focus:border-slate-300 dark:focus:border-slate-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
