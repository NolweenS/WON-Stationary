<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-full font-sans font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2A1E17] focus:bg-[#2A1E17] active:bg-primary focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
