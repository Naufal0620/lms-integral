@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 focus:border-blue-500 focus:ring-0 rounded-xl px-4 py-3 text-slate-900 dark:text-white transition duration-200 placeholder-slate-400 font-bold']) }}>
