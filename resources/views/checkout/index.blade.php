<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Afrekenen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <x-alert type="error" :message="session('error')" class="mb-6" />
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Linkerkolom: Formulier --}}
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Verzendgegevens</h3>

                    <form method="POST" action="{{ route('checkout.store') }}" class="space-y-4">
                        @csrf

                        {{-- Let op: Naam slaan we niet op in orders tabel (niet in migration),
                             dus we tonen hem puur visueel of halen hem uit Auth --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Naam (van account)</label>
                            <input type="text" value="{{ auth()->user()->name }}" disabled
                                   class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-500 sm:text-sm cursor-not-allowed">
                        </div>

                        {{-- Adres --}}
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700">Straat en huisnummer</label>
                            <input type="text" name="shipping_address" id="shipping_address" required
                                   value="{{ old('shipping_address') }}" placeholder="Kerkstraat 1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Postcode --}}
                            <div>
                                <label for="shipping_postal" class="block text-sm font-medium text-gray-700">Postcode</label>
                                <input type="text" name="shipping_postal" id="shipping_postal" required
                                       value="{{ old('shipping_postal') }}" placeholder="1000"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            {{-- Stad --}}
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700">Stad</label>
                                <input type="text" name="shipping_city" id="shipping_city" required
                                       value="{{ old('shipping_city') }}" placeholder="Brussel"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded hover:bg-indigo-700 transition">
                                Plaats Bestelling
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Rechterkolom: Samenvatting --}}
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm h-fit">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Overzicht Bestelling</h3>
                    <div class="flow-root">
                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                            @foreach($cartItems as $cartItem)
                                <li class="flex py-6">
                                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                        <img src="{{ $cartItem->product->imageUrl() }}" alt="{{ $cartItem->product->name }}" class="h-full w-full object-cover object-center">
                                    </div>

                                    <div class="ml-4 flex flex-1 flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>{{ $cartItem->product->name }}</h3>
                                                <p class="ml-4">€ {{ number_format($cartItem->product->price * $cartItem->quantity, 2, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-1 items-end justify-between text-sm">
                                            <p class="text-gray-500">Aantal: {{ $cartItem->quantity }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <p>Totaal</p>
                            <p>€ {{ number_format($total, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
