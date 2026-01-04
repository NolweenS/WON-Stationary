<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bestelling: {{ $order->order_number }}
            </h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Terug naar overzicht
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Meldingen --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Linkerkolom: Items (2/3 breedte) --}}
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Artikelen</h3>

                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <li class="flex py-6">
                                        {{-- Afbeelding --}}
                                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                            @else
                                                <div class="h-full w-full bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                                                    Geen foto
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-4 flex flex-1 flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                    <h3>
                                                        {{ $item->product ? $item->product->name : 'Verwijderd product' }}
                                                    </h3>
                                                    <p class="ml-4">{{ $item->formattedSubtotal() }}</p>
                                                </div>
                                            </div>
                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                <p class="text-gray-500">
                                                    {{ $item->quantity }} x {{ $item->formattedPrice() }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Rechterkolom: Info (1/3 breedte) --}}
                <div class="md:col-span-1 space-y-6">

                    {{-- Status en Totaal --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Details</h3>

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Datum</span>
                            <span class="font-medium">{{ $order->created_at->format('d-m-Y') }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Status</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->statusColor() }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-4 text-lg font-bold">
                            <span>Totaal</span>
                            <span>{{ $order->formattedPrice() }}</span>
                        </div>

                        {{-- Annuleer Knop (Als status pending is) --}}
                        @if($order->canBeCancelled())
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze bestelling wilt annuleren?');" class="mt-4">
                                @csrf
                                <button type="submit" class="w-full bg-red-50 text-red-700 border border-red-200 py-2 rounded hover:bg-red-100 transition text-sm font-medium">
                                    Bestelling Annuleren
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Verzendadres --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Verzendadres</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $order->user->name }}<br> {{-- Naam uit User model halen, want shipping_name zat niet in migratie --}}
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_postal }} {{ $order->shipping_city }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
