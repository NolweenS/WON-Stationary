<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Winkelwagen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Meldingen --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(count($cart) > 0)
                        <div class="flex flex-col lg:flex-row gap-8">

                            {{-- Linkerkant: Productenlijst --}}
                            <div class="flex-1 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aantal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Totaal</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cart as $id => $details)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-16 w-16 flex-shrink-0 border border-gray-200 rounded overflow-hidden">
                                                        @if(isset($details['image']) && $details['image'])
                                                            <img class="h-full w-full object-cover" src="{{ Storage::url($details['image']) }}" alt="{{ $details['name'] }}">
                                                        @else
                                                            <div class="h-full w-full bg-gray-100 flex items-center justify-center text-xs text-gray-400">Geen foto</div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $details['name'] }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                € {{ number_format($details['price'], 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                                           class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-900 text-xs font-medium underline">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                € {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                                        &times; Verwijder
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Rechterkant: Totaal en Afrekenen --}}
                            <div class="w-full lg:w-1/3">
                                {{-- 'relative z-10' zorgt dat dit blok altijd bovenop ligt --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-100 relative z-10">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Overzicht</h3>

                                    <div class="flex justify-between mb-2 text-sm text-gray-600">
                                        <span>Subtotaal</span>
                                        <span class="font-medium">€ {{ number_format($total, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between mb-4 text-sm text-gray-600">
                                        <span>Verzendkosten</span>
                                        <span class="text-xs text-gray-500 italic">Wordt berekend bij checkout</span>
                                    </div>

                                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center mb-6">
                                        <span class="text-lg font-bold text-gray-900">Totaal</span>
                                        <span class="text-xl font-bold text-indigo-600">€ {{ number_format($total, 2, ',', '.') }}</span>
                                    </div>

                                    {{-- De knop die nu correct verwijst --}}
                                    <a href="{{ route('checkout.index') }}" class="block w-full bg-indigo-600 text-white text-center font-bold py-3 rounded-md hover:bg-indigo-700 transition shadow-md">
                                        Afrekenen
                                    </a>

                                    <a href="{{ route('products.index') }}" class="block w-full text-center text-gray-500 mt-4 text-sm hover:underline">
                                        Verder winkelen
                                    </a>
                                </div>
                            </div>

                        </div>
                    @else
                        {{-- Lege winkelwagen weergave --}}
                        <div class="text-center py-16">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Je winkelwagen is leeg</h3>
                            <p class="mt-1 text-gray-500">Je hebt nog geen producten toegevoegd.</p>
                            <div class="mt-6">
                                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                    Bekijk Producten
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
