<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-4 bg-nude">
            <h2 class="font-serif text-3xl text-primary leading-tight tracking-wide">
                {{ __('Ons Assortiment') }}
            </h2>

            @auth
                @if(auth()->user()->is_admin ?? false)
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-full font-sans font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2A1E17] focus:outline-none transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Nieuw Product
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12 bg-nude min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Meldingen (Success) --}}
            @if(session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            {{-- Zoek & Filter Sectie --}}
            <div class="bg-white border border-border shadow-sm rounded-lg mb-8">
                <div class="p-6">
                    <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">
                        {{-- Zoekbalk --}}
                        <div class="flex-1">
                            <label for="search" class="sr-only">Zoeken</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       class="pl-10 block w-full rounded-md border-border bg-nude text-primary placeholder-secondary/70 focus:border-primary focus:ring-primary sm:text-sm"
                                       placeholder="Zoek op naam of omschrijving...">
                            </div>
                        </div>

                        {{-- Categorie Select --}}
                        <div class="w-full md:w-1/4">
                            <label for="category" class="sr-only">Categorie</label>
                            <select name="category" id="category" class="block w-full rounded-md border-border bg-nude text-primary focus:border-primary focus:ring-primary sm:text-sm">
                                <option value="">Alle categorieën</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Knoppen --}}
                        <div class="flex gap-2">
                            <button type="submit" class="inline-flex justify-center items-center px-6 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2A1E17] focus:outline-none transition ease-in-out duration-150">
                                Filteren
                            </button>

                            @if(request('search') || request('category'))
                                <a href="{{ route('products.index') }}" class="inline-flex justify-center items-center px-6 py-2 bg-white border border-border rounded-md font-semibold text-xs text-secondary uppercase tracking-widest hover:bg-beige focus:outline-none transition ease-in-out duration-150">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Product Grid --}}
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        {{-- HIER GEBRUIKEN WE NU HET COMPONENT --}}
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white border border-border rounded-lg p-12 text-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 mx-auto text-secondary mb-4 opacity-50">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <h3 class="text-xl font-serif text-primary">Geen producten gevonden</h3>
                    <p class="mt-2 text-secondary font-light">Probeer een andere zoekterm of categorie.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="text-primary hover:text-secondary underline underline-offset-4 text-sm font-medium">Bekijk alles</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
