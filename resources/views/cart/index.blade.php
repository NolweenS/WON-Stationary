<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Winkelwagen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aantal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Totaal</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cart as $id => $details)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    @if($details['image'])
                                                        <img class="h-10 w-10 rounded object-cover" src="{{ Storage::url($details['image']) }}" alt="{{ $details['name'] }}">
                                                    @else
                                                        <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs">Geen</div>
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
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" max="{{ $details['stock'] }}"
                                                       class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-900 text-sm font-medium">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            € {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Verwijderen</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <div class="w-full sm:w-1/3 bg-gray-50 p-6 rounded-lg">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Subtotaal</span>
                                    <span class="font-bold">€ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between mb-4">
                                    <span class="text-gray-600">Verzendkosten</span>
                                    <span class="text-sm text-gray-500">Wordt berekend bij checkout</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4 flex justify-between items-center mb-6">
                                    <span class="text-lg font-bold">Totaal</span>
                                    <span class="text-xl font-bold text-indigo-600">€ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                                <a href="#" class="block w-full bg-indigo-600 text-white text-center font-bold py-3 rounded hover:bg-indigo-700 transition">
                                    Afrekenen
                                </a>
                                <a href="{{ route('products.index') }}" class="block w-full text-center text-gray-600 mt-4 text-sm hover:underline">
                                    Verder winkelen
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <h3 class="text-lg font-medium text-gray-900">Je winkelwagen is leeg</h3>
                            <p class="mt-1 text-gray-500">Ontdek onze producten en voeg ze toe.</p>
                            <a href="{{ route('products.index') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Bekijk Producten
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout><x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Winkelwagen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aantal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Totaal</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cart as $id => $details)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    @if($details['image'])
                                                        <img class="h-10 w-10 rounded object-cover" src="{{ Storage::url($details['image']) }}" alt="{{ $details['name'] }}">
                                                    @else
                                                        <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs">Geen</div>
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
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" max="{{ $details['stock'] }}"
                                                       class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-900 text-sm font-medium">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            € {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Verwijderen</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <div class="w-full sm:w-1/3 bg-gray-50 p-6 rounded-lg">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Subtotaal</span>
                                    <span class="font-bold">€ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between mb-4">
                                    <span class="text-gray-600">Verzendkosten</span>
                                    <span class="text-sm text-gray-500">Wordt berekend bij checkout</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4 flex justify-between items-center mb-6">
                                    <span class="text-lg font-bold">Totaal</span>
                                    <span class="text-xl font-bold text-indigo-600">€ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                                <a href="#" class="block w-full bg-indigo-600 text-white text-center font-bold py-3 rounded hover:bg-indigo-700 transition">
                                    Afrekenen
                                </a>
                                <a href="{{ route('products.index') }}" class="block w-full text-center text-gray-600 mt-4 text-sm hover:underline">
                                    Verder winkelen
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <h3 class="text-lg font-medium text-gray-900">Je winkelwagen is leeg</h3>
                            <p class="mt-1 text-gray-500">Ontdek onze producten en voeg ze toe.</p>
                            <a href="{{ route('products.index') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Bekijk Producten
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
