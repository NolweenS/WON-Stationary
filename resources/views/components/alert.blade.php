@props(['type' => 'success', 'message'])

@php
    $classes = match($type) {
        'success' => 'bg-beige border-l-4 border-green-500 text-primary',
        'error'   => 'bg-red-50 border-l-4 border-red-500 text-red-800',
        'info'    => 'bg-blue-50 border-l-4 border-blue-500 text-blue-800',
        default   => 'bg-white border border-border text-secondary',
    };
@endphp

@if($message)
    <div {{ $attributes->merge(['class' => "p-4 shadow-sm mb-6 $classes"]) }}>
        <div class="flex justify-between">
            <p class="text-sm font-medium">{{ $message }}</p>
        </div>
    </div>
@endif
