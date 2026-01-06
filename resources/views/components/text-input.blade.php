@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-border bg-white text-primary placeholder-secondary/50 focus:border-secondary focus:ring-secondary rounded-md shadow-sm']) !!}>
