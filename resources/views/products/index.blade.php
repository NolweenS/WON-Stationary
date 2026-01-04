<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ons Assortiment') }}
            </h2>
            @auth
                {{-- Controleer of de gebruiker admin is (pas de check aan op basis van jouw User model) --}}
                @if(auth()->user()->is_admin ?? false)
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Nieuw Product
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">
                        {{-- Search --}}
                        <div class="flex-1">
                            <label for="search" class="sr-only">Zoeken</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="Zoek op naam of omschrijving...">
                            </div>
                        </div>

                        {{-- Category Filter --}}
                        <div class="w-full md:w-1/4">
                            <label for="category" class="sr-only">Categorie</label>
                            <select name="category" id="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Alle categorieën</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Filteren
                        </button>

                        {{-- Reset --}}
                        @if(request('search') || request('category'))
                            <a href="{{ route('products.index') }}" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Products Grid --}}
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                            {{-- Image Container --}}
                            <div class="relative h-48 bg-gray-100 overflow-hidden group">
                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                                {{-- Badges --}}
                                <div class="absolute top-2 left-2 flex flex-col gap-1">
                                    @if($product->is_featured)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 mr-1">
                                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                            </svg>
                                            Topkeuze
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="text-xs text-gray-500 mb-1 uppercase tracking-wider">
                                    {{ $product->category->name }}
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">
                                    <a href="{{ route('products.show', $product) }}" class="hover:text-indigo-600 transition-colors">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="mt-auto pt-4 flex items-end justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-2xl font-bold text-gray-900">
                                            {{ $product->formattedPrice() }}
                                        </span>
                                        {{-- Stock indicator --}}
                                        @if($product->stock <= 0)
                                            <span class="text-xs text-red-600 font-medium mt-1">Uitverkocht</span>
                                        @elseif($product->stock < 5)
                                            <span class="text-xs text-orange-600 font-medium mt-1">Nog slechts {{ $product->stock }}!</span>
                                        @else
                                            <span class="text-xs text-green-600 font-medium mt-1">Op voorraad</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900 p-2 bg-indigo-50 rounded-full hover:bg-indigo-100 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Geen producten gevonden</h3>
                    <p class="mt-1 text-gray-500">Probeer een andere zoekterm of categorie.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
