<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl text-primary leading-tight tracking-wide">
            Winkelwagen
        </h2>
    </x-slot>

    <div class="py-12 bg-nude min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <x-alert type="success" :message="session('success')" class="mb-6" />
            @endif

            @if(session('error'))
                <x-alert type="error" :message="session('error')" class="mb-6" />
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-border">
                <div class="p-6 text-gray-900">

                    {{-- VERBETERING: We controleren op $cartItems (uit je controller) --}}
                    @if($cartItems && $cartItems->count() > 0)
                        <div class="flex flex-col lg:flex-row gap-8">

                            <div class="flex-1 overflow-x-auto">
                                <table class="min-w-full divide-y divide-border">
                                    <thead class="bg-beige/30">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Prijs</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Aantal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary uppercase tracking-wider">Totaal</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-secondary uppercase tracking-wider">Acties</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-border">
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-16 w-16 flex-shrink-0 border border-border rounded overflow-hidden bg-nude">
                                                        {{-- VERBETERING: Gebruik de dynamische imageUrl() functie --}}
                                                        <img class="h-full w-full object-cover"
                                                             src="{{ $item->product->imageUrl() }}"
                                                             alt="{{ $item->product->name }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-serif text-primary">{{ $item->product->name }}</div>
                                                        <div class="text-xs text-secondary uppercase">{{ $item->product->category->name ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary">
                                                € {{ number_format($item->product->price, 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                           class="w-16 rounded-md border-border bg-nude text-primary focus:border-primary focus:ring-primary sm:text-sm">
                                                    <button type="submit" class="ml-2 text-primary hover:text-secondary text-xs font-bold uppercase tracking-widest">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-primary">
                                                {{-- VERBETERING: Gebruik de subtotal() functie uit je Model --}}
                                                € {{ number_format($item->subtotal(), 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold uppercase text-xs tracking-widest">
                                                        Verwijder
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="w-full lg:w-1/3">
                                <div class="bg-beige/20 p-6 rounded-lg border border-border shadow-sm">
                                    <h3 class="font-serif text-xl text-primary mb-4">Overzicht</h3>

                                    <div class="flex justify-between mb-2 text-sm text-secondary">
                                        <span>Subtotaal</span>
                                        <span class="font-medium">€ {{ number_format($total, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between mb-4 text-sm text-secondary">
                                        <span>Verzendkosten</span>
                                        <span class="text-xs italic">Berekend bij checkout</span>
                                    </div>

                                    <div class="border-t border-border pt-4 flex justify-between items-center mb-6">
                                        <span class="text-lg font-serif text-primary">Totaal</span>
                                        <span class="text-xl font-bold text-primary">€ {{ number_format($total, 2, ',', '.') }}</span>
                                    </div>

                                    <a href="{{ route('checkout.index') }}" class="block w-full bg-primary text-white text-center font-bold py-3 rounded-full hover:bg-[#2A1E17] transition shadow-md uppercase tracking-widest text-xs">
                                        Afrekenen
                                    </a>

                                    <a href="{{ route('products.index') }}" class="block w-full text-center text-secondary mt-4 text-xs uppercase tracking-widest hover:text-primary transition">
                                        &larr; Verder winkelen
                                    </a>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="mx-auto h-16 w-16 text-secondary opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            <h3 class="mt-4 text-xl font-serif text-primary">Je winkelwagen is leeg</h3>
                            <p class="mt-1 text-secondary font-light">Je hebt nog geen producten toegevoegd aan je mandje.</p>
                            <div class="mt-8">
                                <a href="{{ route('products.index') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-xs font-bold rounded-full text-white bg-primary hover:bg-[#2A1E17] transition uppercase tracking-widest">
                                    Bekijk Assortiment
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
