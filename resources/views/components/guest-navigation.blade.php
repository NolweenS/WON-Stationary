<nav class="bg-white border-b border-border sticky top-0 z-50 shadow-sm" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="font-serif text-3xl text-primary tracking-wide font-bold">{{ config('app.name') }}</span>
                </a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('home') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">Home</a>
                <a href="{{ route('products.index') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">Producten</a>
                <a href="{{ route('news.index') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">Nieuws</a>
                <a href="{{ route('faq.index') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">FAQ</a>
                <a href="{{ route('contact.show') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">Contact</a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-6">
                <a href="{{ route('cart.index') }}" class="text-secondary hover:text-primary relative transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ count(session('cart')) }}</span>
                    @endif
                </a>
                <div class="h-4 w-px bg-border"></div>
                @auth
                    <div class="relative" x-data="{ userOpen: false }">
                        <button @click="userOpen = !userOpen" class="flex items-center text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300 focus:outline-none">
                            <div class="mr-1">{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                        <div x-show="userOpen" @click.away="userOpen = false" class="absolute right-0 mt-2 w-48 bg-white border border-border rounded-md shadow-lg py-1 z-50" style="display: none;">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-secondary hover:bg-beige hover:text-primary">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-secondary hover:bg-beige hover:text-primary">Profiel</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-secondary hover:bg-beige hover:text-primary">Uitloggen</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium transition duration-300">Log in</a>
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-[#2A1E17] text-white text-xs uppercase tracking-widest font-medium px-5 py-2 rounded-full transition duration-300 ml-4">Registreer</a>
                @endauth
            </div>

            <div class="flex items-center md:hidden space-x-4">
                <button @click="open = !open" class="text-primary hover:text-secondary focus:outline-none transition duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" class="md:hidden border-t border-border bg-white">
        <div class="px-4 pt-4 pb-6 space-y-1">
            <a href="{{ route('home') }}" class="block text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium py-3 border-b border-beige">Home</a>
            <a href="{{ route('products.index') }}" class="block text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium py-3 border-b border-beige">Producten</a>
            <a href="{{ route('news.index') }}" class="block text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium py-3 border-b border-beige">Nieuws</a>
            <a href="{{ route('faq.index') }}" class="block text-secondary hover:text-primary text-xs uppercase tracking-widest font-medium py-3 border-b border-beige">FAQ</a>
            @auth
                <div class="pt-4 mt-2 border-t border-beige">
                    <div class="font-medium text-base text-primary mb-2">{{ Auth::user()->name }}</div>
                    <a href="{{ route('dashboard') }}" class="block text-secondary text-xs uppercase tracking-widest font-medium py-2">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">@csrf<button type="submit" class="block w-full text-left text-secondary text-xs uppercase tracking-widest font-medium py-2">Uitloggen</button></form>
                </div>
            @else
                <div class="pt-4 grid grid-cols-2 gap-4">
                    <a href="{{ route('login') }}" class="block text-center border border-border text-secondary text-xs uppercase tracking-widest font-medium py-2 rounded-md hover:bg-beige">Log in</a>
                    <a href="{{ route('register') }}" class="block text-center bg-primary text-white text-xs uppercase tracking-widest font-medium py-2 rounded-md hover:bg-[#2A1E17]">Registreer</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
