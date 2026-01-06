<nav x-data="{ open: false }" class="bg-[#FDFBF7] border-b border-[#EAE5DE]">

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
                    <div class="relative mr-4" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-1 rounded-full text-[#8C7B70] hover:text-[#3E2C22] focus:outline-none transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-50 ring-1 ring-black ring-opacity-5"
                             style="display: none;">

                            <div class="py-2">
                                <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                                    <span class="text-xs font-semibold text-gray-600 uppercase">Notificaties</span>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <form action="{{ route('notifications.markRead') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs text-blue-500 hover:underline">Alles lezen</button>
                                        </form>
                                    @endif
                                </div>

                                @forelse(Auth::user()->notifications->take(5) as $notification)
                                    <a href="{{ $notification->data['link'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100 {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50' }}">
                                        <p class="text-sm text-gray-800">
                                            <span class="font-bold">{{ $notification->data['sender_name'] }}</span>
                                            @if(isset($notification->data['type']) && $notification->data['type'] === 'reply')
                                                reageerde op je:
                                            @else
                                                schreef een bericht:
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 truncate italic">"{{ $notification->data['content'] }}"</p>
                                        <p class="text-[10px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-4 text-center text-gray-500 text-sm">
                                        Geen nieuwe meldingen.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

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

                            <x-dropdown-link :href="route('wishlist.index')">
                                {{ __('Mijn Verlanglijstje') }}
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

                    <x-responsive-nav-link :href="route('wishlist.index')">
                        {{ __('Mijn Verlanglijstje') }}
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
