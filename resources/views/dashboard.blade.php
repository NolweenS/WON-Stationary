<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-8">
                Welkom, {{ $user->name }}!
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase">Lopende Bestellingen</div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $activeOrdersCount }}</div>
                        </div>
                        <svg class="h-10 w-10 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline mt-4 block">Bekijk alle bestellingen &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-pink-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase">In je Wishlist</div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $wishlistCount }}</div>
                        </div>
                        <svg class="h-10 w-10 text-pink-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <a href="{{ route('wishlist.index') }}" class="text-sm text-pink-600 hover:underline mt-4 block">Naar je favorieten &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase">Reviews geschreven</div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $reviewsCount }}</div>
                        </div>
                        <svg class="h-10 w-10 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Recente Bestellingen</h3>

                    @if($recentOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Totaal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">€ {{ number_format($order->total_price, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">Bekijk</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Je hebt nog geen bestellingen geplaatst.</p>
                        <a href="{{ route('products.index') }}" class="text-blue-600 underline mt-2 inline-block">Ga winkelen</a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
