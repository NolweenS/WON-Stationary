<nav class="bg-white border-b border-border sticky top-0 z-50 shadow-sm" x-data="{ open: false, userMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <span class="font-serif text-3xl text-primary tracking-wide font-bold">{{ config('app.name') }}</span>
                </a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('dashboard') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">
                    Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">
                    Producten
                </a>
                <a href="{{ route('news.index') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">
                    Nieuws
                </a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-6">

                {{-- Winkelwagen --}}
                <a href="{{ route('cart.index') }}" class="text-secondary hover:text-primary relative transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <div class="h-4 w-px bg-border"></div>

                {{-- User Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300 focus:outline-none">
                        <div class="mr-1">{{ Auth::user()->name }}</div>
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white border border-border rounded-md shadow-lg py-1 z-50"
                         style="display: none;">

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-secondary hover:bg-beige hover:text-primary">
                            Profiel
                        </a>

                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-secondary hover:bg-beige hover:text-primary">
                                Admin Dashboard
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-secondary hover:bg-beige hover:text-primary">
                                Uitloggen
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="flex items-center md:hidden space-x-4">
                <button @click="open = !open" class="text-primary hover:text-secondary focus:outline-none transition duration-300">
                    <svg class="h-6 w-6" :class="{'hidden': open, 'block': !open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'block': open, 'hidden': !open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" class="md:hidden border-t border-border bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-primary text-primary font-medium text-sm bg-beige">Dashboard</a>
            <a href="{{ route('products.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-secondary hover:text-primary hover:bg-beige hover:border-primary font-medium text-sm transition">Producten</a>
            <a href="{{ route('news.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-secondary hover:text-primary hover:bg-beige hover:border-primary font-medium text-sm transition">Nieuws</a>
        </div>

        <div class="pt-4 pb-1 border-t border-border">
            <div class="px-4">
                <div class="font-medium text-base text-primary">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-secondary">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-secondary hover:text-primary hover:bg-beige font-medium text-sm transition">Profiel</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-secondary hover:text-primary hover:bg-beige font-medium text-sm transition">
                        Uitloggen
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
