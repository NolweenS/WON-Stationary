<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Statistieken Rij --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- Card 1: Gebruikers --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-gray-300">
                    <div class="text-gray-500 text-sm font-medium uppercase">Totaal Gebruikers</div>
                    <div class="mt-2 flex items-center">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</div>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-600 hover:underline mt-2 inline-block">Beheer gebruikers &rarr;</a>
                </div>

                {{-- Card 2: Omzet --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-gray-300">
                    <div class="text-gray-500 text-sm font-medium uppercase">Totale Omzet</div>
                    <div class="mt-2 flex items-center">
                        <div class="text-3xl font-bold text-gray-900">€ {{ number_format($revenue, 2, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Card 3: Open Orders --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-gray-300">
                    <div class="text-gray-500 text-sm font-medium uppercase">Openstaande Orders</div>
                    <div class="mt-2 flex items-center">
                        <div class="text-3xl font-bold text-gray-900">{{ $openOrders }}</div>
                    </div>
                    <a href="{{ route('orders.index') }}" class="text-xs text-blue-600 hover:underline mt-2 inline-block">Bekijk orders &rarr;</a>
                </div>

            </div>

            {{-- Recente Bestellingen Tabel --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Nieuwste Bestellingen (Alle klanten)</h3>
                        <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline">Alles bekijken</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bedrag</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $order->user ? $order->user->name : 'Gast' }}
                                        <div class="text-xs text-gray-500">{{ $order->user ? $order->user->email : '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">€ {{ number_format($order->total_price, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Geen bestellingen gevonden.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
