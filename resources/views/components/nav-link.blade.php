@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#3E2C22] text-sm font-medium leading-5 text-[#3E2C22] focus:outline-none focus:border-[#5D4037] transition duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#8C7B70] hover:text-[#3E2C22] hover:border-[#EAE5DE] focus:outline-none focus:text-[#3E2C22] focus:border-[#EAE5DE] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
