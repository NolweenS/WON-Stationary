<nav x-data="{ open: false }" class="bg-[#FDFBF7] border-b border-[#EAE5DE]">

    {{-- Bereken winkelwagen aantal (voor zowel desktop als mobiel) --}}
    @php
        $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-[#3E2C22]" />
                    </a>
                </div>

                {{-- Desktop Navigatie --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Producten') }}
                    </x-nav-link>

                    <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                        {{ __('Nieuws') }}
                    </x-nav-link>

                    <x-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.*')">
                        {{ __('FAQ') }}
                    </x-nav-link>

                    <x-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.*')">
                        {{ __('Contact') }}
                    </x-nav-link>

                    {{-- NIEUW: Winkelwagen Icoon --}}
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#8C7B70] group-hover:text-[#3E2C22]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute top-4 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </x-nav-link>

                    {{-- Admin Links --}}
                    @if(Auth::check() && Auth::user()->is_admin)
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Categorieën') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Users') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[#8C7B70] bg-[#FDFBF7] hover:text-[#3E2C22] focus:outline-none transition ease-in-out duration-150 uppercase tracking-widest text-xs">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profiel') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-widest font-medium transition duration-150 ease-in-out">
                        LOG IN
                    </a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-[#8C7B70] hover:text-[#3E2C22] hover:bg-[#F5F0EB] focus:outline-none focus:bg-[#F5F0EB] focus:text-[#3E2C22] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#FDFBF7]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                {{ __('Producten') }}
            </x-responsive-nav-link>

            {{-- NIEUW: Mobiele Winkelwagen Link --}}
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                <div class="flex items-center">
                    {{ __('Winkelwagen') }}
                    @if($cartCount > 0)
                        <span class="ml-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
                    @endif
                </div>
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                {{ __('Nieuws') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.*')">
                {{ __('FAQ') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.*')">
                {{ __('Contact') }}
            </x-responsive-nav-link>

            {{-- Mobile: Admin Links --}}
            @if(Auth::check() && Auth::user()->is_admin)
                <div class="border-t border-[#EAE5DE] mt-2 pt-2">
                    <div class="px-4 text-xs text-[#8C7B70] uppercase font-bold mb-1">
                        Admin Beheer
                    </div>

                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        {{ __('Categorieën') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Users') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-[#EAE5DE]">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-[#3E2C22]">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-[#8C7B70]">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
