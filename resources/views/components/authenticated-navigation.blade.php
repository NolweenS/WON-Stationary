<nav x-data="{ open: false }" class="bg-[#FDFBF7] border-b border-[#EAE5DE]">
    @php
        $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Flex container die de drie hoofdonderdelen verdeelt --}}
        <div class="flex justify-between h-20 items-center">

            {{-- 1. LINKERKANT: Het Logo --}}
            <div class="flex-shrink-0 flex items-center w-1/4">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="font-serif text-3xl text-[#3E2C22] tracking-wide font-bold">
                        {{ config('app.name') }}
                    </span>
                </a>
            </div>

            {{-- 2. MIDDEN: Navigatie links (gecentreerd) --}}
            <div class="hidden md:flex flex-grow justify-center">
                <div class="flex space-x-10 items-center">
                    <a href="{{ route('home') }}" class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-[0.2em] font-medium transition {{ request()->routeIs('home') ? 'text-[#3E2C22] border-b-2 border-[#3E2C22] pb-1' : '' }}">Home</a>
                    <a href="{{ route('products.index') }}" class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-[0.2em] font-medium transition {{ request()->routeIs('products.*') ? 'text-[#3E2C22] border-b-2 border-[#3E2C22] pb-1' : '' }}">Producten</a>
                    <a href="{{ route('news.index') }}" class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-[0.2em] font-medium transition {{ request()->routeIs('news.*') ? 'text-[#3E2C22] border-b-2 border-[#3E2C22] pb-1' : '' }}">Nieuws</a>
                    <a href="{{ route('faq.index') }}" class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-[0.2em] font-medium transition {{ request()->routeIs('faq.*') ? 'text-[#3E2C22] border-b-2 border-[#3E2C22] pb-1' : '' }}">FAQ</a>
                    <a href="{{ route('contact.show') }}" class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-[0.2em] font-medium transition {{ request()->routeIs('contact.*') ? 'text-[#3E2C22] border-b-2 border-[#3E2C22] pb-1' : '' }}">Contact</a>
                </div>
            </div>

            {{-- 3. RECHTERKANT: Cart & User (rechts uitgelijnd) --}}
            <div class="flex items-center justify-end w-1/4 space-x-6">
                <a href="{{ route('cart.index') }}" class="text-[#8C7B70] hover:text-[#3E2C22] relative transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-[#8C7B70] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $cartCount }}</span>
                    @endif
                </a>

                <div class="h-4 w-px bg-[#EAE5DE]"></div>

                @auth
                    <div class="relative" x-data="{ userOpen: false }">
                        <button @click="userOpen = !userOpen" class="flex items-center text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-widest font-medium transition focus:outline-none">
                            <div class="mr-1">{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
                        </button>

                        <div x-show="userOpen" @click.away="userOpen = false" class="absolute right-0 mt-2 w-48 bg-white border border-[#EAE5DE] rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22]">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22]">Profiel</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22]">Uitloggen</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-widest font-medium transition">Log in</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
