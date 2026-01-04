<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Melding na bewerken --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                        {{-- Linkerkolom: Afbeelding --}}
                        <div class="relative">
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>

                            @if($product->is_featured)
                                <span class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-bold shadow flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    Topkeuze
                                </span>
                            @endif
                        </div>

                        {{-- Rechterkolom: Details --}}
                        <div class="flex flex-col">
                            <div class="mb-2">
                                <span class="text-sm text-gray-500 uppercase tracking-wide">
                                    {{ $product->category->name ?? 'Geen categorie' }}
                                </span>
                            </div>

                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                            <div class="prose prose-sm text-gray-600 mb-6">
                                <p>{{ $product->description }}</p>
                            </div>

                            <div class="mt-auto">
                                <div class="flex items-baseline mb-6">
                                    <span class="text-4xl font-bold text-gray-900">
                                        {{ $product->formattedPrice() }}
                                    </span>
                                </div>

                                {{-- Voorraad Status --}}
                                <div class="mb-6 flex items-center">
                                    @if($product->stock > 5)
                                        <span class="flex items-center text-green-600 font-medium">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Op voorraad
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span class="flex items-center text-orange-600 font-medium">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            Bijna uitverkocht (nog {{ $product->stock }})
                                        </span>
                                    @else
                                        <span class="flex items-center text-red-600 font-medium">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Niet op voorraad
                                        </span>
                                    @endif
                                </div>

                                {{-- Actieknoppen --}}
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit"
                                                @if($product->stock <= 0) disabled @endif
                                                class="w-full bg-gray-900 text-white px-8 py-3 rounded-md font-semibold hover:bg-gray-800 transition disabled:opacity-50 disabled:cursor-not-allowed text-center flex items-center justify-center"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                            </svg>
                                            In Winkelwagen
                                        </button>
                                    </form>

                                    {{-- Admin Acties --}}
                                    @auth
                                        @if(auth()->user()->is_admin)
                                            <a href="{{ route('admin.products.edit', $product) }}" class="flex-none bg-yellow-100 text-yellow-700 px-6 py-3 rounded-md font-semibold hover:bg-yellow-200 transition text-center border border-yellow-300 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                Bewerken
                                            </a>

                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full sm:w-auto flex-none bg-red-100 text-red-700 px-6 py-3 rounded-md font-semibold hover:bg-red-200 transition text-center border border-red-300 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                    Verwijderen
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gerelateerde Producten --}}
            @if($relatedProducts->count() > 0)
                <div class="mt-12">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Andere klanten bekeken ook</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('products.show', $related) }}" class="group bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    <img src="{{ $related->imageUrl() }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                                <div class="p-4">
                                    <p class="text-sm text-gray-500 mb-1">{{ $related->category->name }}</p>
                                    <h4 class="font-semibold text-gray-900 truncate">{{ $related->name }}</h4>
                                    <p class="text-blue-600 font-bold mt-2">{{ $related->formattedPrice() }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
