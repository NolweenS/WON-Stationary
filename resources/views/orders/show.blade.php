<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bestelling: {{ $order->order_number }}
            </h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-[#8C7B70] hover:text-[#3E2C22] transition font-medium">
                &larr; Terug naar overzicht
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Meldingen --}}
            @if(session('success'))
                <div class="mb-6 bg-white border-l-4 border-[#5D4037] text-[#3E2C22] px-4 py-3 rounded-lg shadow-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Linkerkolom: Items --}}
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm rounded-2xl border border-[#EAE5DE]">
                    <div class="p-8 text-gray-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-widest text-xs">Artikelen</h3>

                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-[#EAE5DE]">
                                @foreach($order->items as $item)
                                    <li class="flex py-6">
                                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-xl border border-[#EAE5DE]">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                            @else
                                                <div class="h-full w-full bg-[#FDFBF7] flex items-center justify-center text-[10px] text-[#8C7B70] uppercase tracking-tighter">
                                                    Geen foto
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-6 flex flex-1 flex-col">
                                            <div class="flex justify-between text-base font-semibold text-gray-900">
                                                <h3>{{ $item->product ? $item->product->name : 'Verwijderd product' }}</h3>
                                                <p class="ml-4 font-bold">{{ $item->formattedSubtotal() }}</p>
                                            </div>
                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                <p class="text-[#8C7B70]">{{ $item->quantity }} x {{ $item->formattedPrice() }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Rechterkolom: Details & Adres --}}
                <div class="md:col-span-1 space-y-8">
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-[#EAE5DE] p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-widest text-xs">Details</h3>
                        <div class="flex justify-between items-center py-3 border-b border-[#F5F0EB]">
                            <span class="text-[#8C7B70] text-sm">Datum</span>
                            <span class="font-semibold text-sm">{{ $order->created_at->format('d-m-Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-[#F5F0EB]">
                            <span class="text-[#8C7B70] text-sm">Status</span>
                            <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full uppercase tracking-wider bg-[#FDFBF7] text-[#8C7B70] border border-[#EAE5DE]">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-6 text-xl font-bold text-[#3E2C22]">
                            <span>Totaal</span>
                            <span>{{ $order->formattedPrice() }}</span>
                        </div>

                        @if($order->canBeCancelled())
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze bestelling wilt annuleren?');" class="mt-4">
                                @csrf
                                <button type="submit" class="w-full bg-white text-[#8C7B70] border border-[#EAE5DE] py-3 rounded-full hover:bg-[#FDFBF7] transition text-[10px] font-bold uppercase tracking-widest">
                                    Bestelling Annuleren
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-[#EAE5DE] p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-widest text-xs">Verzendadres</h3>
                        <p class="text-[#3E2C22] text-sm leading-relaxed font-medium">
                            <span class="text-[#8C7B70] font-normal uppercase text-[10px] block mb-1">Ontvanger</span>
                            {{ $order->user->name }}<br>
                            <span class="text-[#8C7B70] font-normal uppercase text-[10px] block mt-3 mb-1">Adres</span>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_postal }} {{ $order->shipping_city }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
