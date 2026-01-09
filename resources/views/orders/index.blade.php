<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->isAdmin())
                    {{ __('Alle Bestellingen') }}
                @else
                    {{ __('Mijn Bestellingen') }}
                @endif
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-[#8C7B70] hover:text-[#3E2C22] transition font-medium">
                    &larr; Terug naar Dashboard
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-[#EAE5DE]">
                <div class="p-8 text-gray-900">

                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#F5F0EB]">
                                <thead>
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#8C7B70] uppercase tracking-widest">Order Nr.</th>
                                    @if(Auth::user()->isAdmin())
                                        <th class="px-6 py-4 text-left text-[10px] font-bold text-[#8C7B70] uppercase tracking-widest">Klant</th>
                                    @endif
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#8C7B70] uppercase tracking-widest">Datum</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#8C7B70] uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#8C7B70] uppercase tracking-widest">Totaal</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-[#8C7B70] uppercase tracking-widest">Items</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-bold text-[#8C7B70] uppercase tracking-widest">Actie</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-[#F5F0EB]">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-[#FDFBF7] transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[#3E2C22]">
                                            {{ $order->order_number }}
                                        </td>
                                        @if(Auth::user()->isAdmin())
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#3E2C22]">
                                                {{ $order->user ? $order->user->name : 'Gast' }}
                                                <div class="text-xs text-[#8C7B70]">{{ $order->user ? $order->user->email : '' }}</div>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8C7B70]">
                                            {{ $order->created_at->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full uppercase tracking-wider bg-[#FDFBF7] text-[#8C7B70] border border-[#EAE5DE]">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#3E2C22] font-bold">
                                            {{ $order->formattedPrice() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8C7B70]">
                                            {{ $order->totalItems() }} stuks
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('orders.show', $order) }}" class="text-[#5D4037] hover:text-[#3E2C22] font-bold transition underline uppercase text-[10px] tracking-widest">
                                                Bekijken
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <h3 class="text-lg font-semibold text-[#3E2C22] mb-6">
                                @if(Auth::user()->isAdmin())
                                    Er zijn nog geen bestellingen gevonden.
                                @else
                                    Je hebt nog geen bestellingen geplaatst.
                                @endif
                            </h3>
                            @if(!Auth::user()->isAdmin())
                                <a href="{{ route('products.index') }}" class="inline-block bg-[#2A1E17] hover:bg-[#1A120E] text-white text-[10px] uppercase tracking-[0.2em] font-bold px-10 py-4 rounded-full transition shadow-md">
                                    Ga naar de winkel
                                </a>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
