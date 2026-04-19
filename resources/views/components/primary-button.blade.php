<button {{ $attributes->merge(['type' => 'submit', 'class' => 'rpg-button inline-flex items-center justify-center px-8 py-4 bg-blue-600 border border-transparent rounded-xl font-black text-white uppercase tracking-tighter italic hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
