<x-app-layout>
    <x-slot name="header">
        <h2 class="font-light text-xl text-neutral-800 leading-tight tracking-wide">
            {{ __('Afrekenen') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-stone-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <x-alert type="error" :message="session('error')" class="mb-6" />
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Linkerkolom: Formulier --}}
                <div class="bg-white p-8 rounded-2xl border border-stone-100 shadow-sm">
                    <h3 class="text-lg font-medium text-neutral-900 mb-6 uppercase tracking-wide">Verzendgegevens</h3>

                    <form method="POST" action="{{ route('checkout.store') }}" class="space-y-6">
                        @csrf

                        {{-- Naam (Read-only) --}}
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Naam</label>
                            <input type="text" value="{{ auth()->user()->name }}" disabled
                                   class="block w-full rounded-lg border-stone-200 bg-stone-50 text-neutral-500 text-sm cursor-not-allowed">
                        </div>

                        {{-- Adres --}}
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-neutral-700 mb-2">Straat en huisnummer</label>
                            <input type="text" name="shipping_address" id="shipping_address" required
                                   value="{{ old('shipping_address') }}" placeholder="Kerkstraat 1"
                                   class="block w-full rounded-lg border-stone-200 bg-white text-neutral-900 focus:border-neutral-900 focus:ring-neutral-900 text-sm placeholder-stone-400">
                            @error('shipping_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            {{-- Postcode --}}
                            <div>
                                <label for="shipping_postal" class="block text-sm font-medium text-neutral-700 mb-2">Postcode</label>
                                <input type="text" name="shipping_postal" id="shipping_postal" required
                                       value="{{ old('shipping_postal') }}" placeholder="1000"
                                       pattern="[0-9]{4}" title="Voer een geldige 4-cijferige postcode in"
                                       class="block w-full rounded-lg border-stone-200 bg-white text-neutral-900 focus:border-neutral-900 focus:ring-neutral-900 text-sm placeholder-stone-400">
                                @error('shipping_postal')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Stad --}}
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-neutral-700 mb-2">Stad</label>
                                <input type="text" name="shipping_city" id="shipping_city" required
                                       value="{{ old('shipping_city') }}" placeholder="Brussel"
                                       class="block w-full rounded-lg border-stone-200 bg-white text-neutral-900 focus:border-neutral-900 focus:ring-neutral-900 text-sm placeholder-stone-400">
                                @error('shipping_city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-stone-100">
                            <button type="submit" class="w-full bg-neutral-900 hover:bg-neutral-700 text-white text-xs uppercase tracking-widest font-medium py-4 rounded-full transition duration-300 shadow-md">
                                Plaats Bestelling
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Rechterkolom: Samenvatting --}}
                <div class="bg-stone-50 p-8 rounded-2xl border border-stone-200 h-fit">
                    <h3 class="text-lg font-medium text-neutral-900 mb-6 uppercase tracking-wide">Overzicht Bestelling</h3>
                    <div class="flow-root">
                        <ul role="list" class="-my-6 divide-y divide-stone-200">
                            @foreach($cartItems as $cartItem)
                                <li class="flex py-6">
                                    <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg border border-stone-200 bg-white">
                                        <img src="{{ $cartItem->product->imageUrl() }}" alt="{{ $cartItem->product->name }}" class="h-full w-full object-cover object-center">
                                    </div>

                                    <div class="ml-4 flex flex-1 flex-col justify-center">
                                        <div>
                                            <div class="flex justify-between text-sm font-medium text-neutral-900">
                                                <h3>{{ $cartItem->product->name }}</h3>
                                                <p class="ml-4">€ {{ number_format($cartItem->product->price * $cartItem->quantity, 2, ',', '.') }}</p>
                                            </div>
                                            <p class="mt-1 text-xs text-neutral-500">{{ $cartItem->product->category->name ?? 'Algemeen' }}</p>
                                        </div>
                                        <div class="flex flex-1 items-end justify-between text-sm mt-2">
                                            <p class="text-neutral-500">Aantal: {{ $cartItem->quantity }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="border-t border-stone-200 mt-8 pt-6">
                        <div class="flex justify-between text-base font-medium text-neutral-900">
                            <p>Totaal</p>
                            <p>€ {{ number_format($total, 2, ',', '.') }}</p>
                        </div>
                        <p class="mt-2 text-xs text-neutral-400 italic">Inclusief BTW en verzendkosten</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
