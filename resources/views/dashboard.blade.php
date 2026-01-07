<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="font-semibold text-2xl text-gray-800 mb-8">
                Welkom, {{ $user->name }}!
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-[#5D4037]">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase">Lopende Bestellingen</div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $activeOrdersCount }}</div>
                        </div>
                        <svg class="h-10 w-10 text-[#5D4037] opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <a href="{{ route('orders.index') }}" class="text-sm text-[#5D4037] hover:underline mt-4 block font-semibold">Bekijk alle bestellingen &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-[#8D7B6D]">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase">In je Wishlist</div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $wishlistCount }}</div>
                        </div>
                        <svg class="h-10 w-10 text-[#8D7B6D] opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <a href="{{ route('wishlist.index') }}" class="text-sm text-[#8D7B6D] hover:underline mt-4 block font-semibold">Naar je favorieten &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-[#C4B5A5]">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase">Reviews geschreven</div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $reviewsCount }}</div>
                        </div>
                        <svg class="h-10 w-10 text-[#C4B5A5] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div class="text-xs text-gray-400 mt-4 italic">Bedankt voor je feedback</div>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-[#EAE5DE]">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-900">Recente Bestellingen</h3>

                    {{-- Tabel of Lege Staat --}}
                    @if($recentOrders->count() > 0)
                        {{-- ... Tabel code ... --}}
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-500 mb-4">Je hebt nog geen bestellingen geplaatst.</p>
                            <a href="{{ route('products.index') }}" class="inline-block bg-[#2A1E17] hover:bg-[#1A120E] text-white text-xs uppercase tracking-widest font-bold px-10 py-4 rounded-full transition shadow-md">
                                Ga winkelen
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
