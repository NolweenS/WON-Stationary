@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-primary text-left text-base font-medium text-primary bg-beige focus:outline-none focus:text-primary focus:bg-beige focus:border-primary transition duration-150 ease-in-out'
                : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-secondary hover:text-primary hover:bg-beige hover:border-border focus:outline-none focus:text-primary focus:bg-beige focus:border-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
