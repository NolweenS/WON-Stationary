@props([
    'title',
    'value',
    'icon',
    'trend' => null,
    'percentage' => null,
    'color' => 'dark' 
])

@php
    $colors = [
        'dark'  => 'bg-[#5D4037]', // Warm Donkerbruin
        'taupe' => 'bg-[#8D7B6D]', // Middelbruin/Taupe
        'beige' => 'bg-[#C4B5A5]', // Zacht Beige
    ];

    // Bepaal de juiste achtergrondklasse
    $bgClass = $colors[$color] ?? $colors['dark'];
@endphp

<div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-stone-100 transition hover:shadow-md">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                {{-- Het icoon-vlak gebruikt nu de nude themakleuren --}}
                <div class="{{ $bgClass }} p-3 rounded-xl shadow-sm">
                    @if(isset($icon))
                        <div class="text-white w-6 h-6">
                            {{ $icon }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-[10px] uppercase tracking-widest font-bold text-neutral-400 truncate mb-1">
                        {{ $title }}
                    </dt>
                    <dd class="text-3xl font-light text-neutral-900 leading-none">
                        {{ $value }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    @if($percentage)
        <div class="bg-stone-50/50 px-6 py-3 border-t border-stone-50">
            <div class="text-sm">
            <span @class([
                'font-medium inline-flex items-baseline',
                'text-[#5D4037]' => $trend === 'up',
                'text-red-800' => $trend === 'down',
                'text-neutral-500' => $trend === 'neutral',
            ])>
                @if($trend === 'up')
                    &uarr;
                @elseif($trend === 'down')
                    &darr;
                @endif
                <span class="ml-1">{{ $percentage }}</span>
            </span>
                <span class="text-neutral-400 font-light text-xs"> t.o.v. vorig jaar</span>
            </div>
        </div>
    @endif
</div>
