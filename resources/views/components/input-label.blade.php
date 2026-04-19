@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-[10px] uppercase tracking-widest text-blue-600 dark:text-blue-400 mb-2 italic']) }}>
    {{ $value ?? $slot }}
</label>
