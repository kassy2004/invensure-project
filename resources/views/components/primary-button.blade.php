<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2 bg-primary border border-transparent rounded-md font-semibold text-sm text-white tracking-wide hover:bg-accent focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
