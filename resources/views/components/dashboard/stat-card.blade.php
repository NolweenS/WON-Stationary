@props([
    'title',
    'value',
    'icon',
    'trend' => null, // bijvoorbeeld: 'up', 'down', 'neutral'
    'percentage' => null,
    'color' => 'blue' // kleur van het icoon
])

<div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="rounded-md bg-{{ $color }}-500 p-3">
                    @if(isset($icon))
                        {{ $icon }}
                    @endif
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        {{ $title }}
                    </dt>
                    <dd class="text-lg font-medium text-gray-900">
                        {{ $value }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    @if($percentage)
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
            <span @class([
                'font-medium inline-flex items-baseline',
                'text-green-700' => $trend === 'up',
                'text-red-700' => $trend === 'down',
                'text-gray-700' => $trend === 'neutral',
            ])>
                @if($trend === 'up')
                    &uarr;
                @elseif($trend === 'down')
                    &darr;
                @endif
                <span class="ml-1">{{ $percentage }}</span>
            </span>
                <span class="text-gray-500"> t.o.v. vorige periode</span>
            </div>
        </div>
    @endif
</div>
