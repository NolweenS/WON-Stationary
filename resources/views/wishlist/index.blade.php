<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-light text-xl text-neutral-800 leading-tight tracking-wide">
                {{ __('Mijn Verlanglijstje') }}
            </h2>
            <a
                href="{{ route('profile.show', auth()->user()) }}"
                class="text-sm text-neutral-500 hover:text-neutral-900 underline decoration-stone-300 underline-offset-4"
            >
                Bekijk publiek profiel
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-stone-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-white border border-green-200 text-green-700 px-6 py-4 rounded-lg shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-white border border-red-200 text-red-700 px-6 py-4 rounded-lg shadow-sm text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-2xl border border-stone-100 p-8 mb-8">
                <div class="flex items-start">
                    <div class="text-neutral-400 mr-4 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <div class="w-full">
                        <h3 class="font-medium text-neutral-900 mb-1">Je verlanglijstje is publiek zichtbaar</h3>
                        <p class="text-neutral-500 text-sm font-light mb-4">
                            Iedereen kan je verlanglijstje zien op je profiel. Deel de link met vrienden en familie.
                        </p>
                        <div class="flex items-center gap-2">
                            <input
                                type="text"
                                value="{{ route('profile.show', auth()->user()) }}"
                                readonly
                                class="flex-1 bg-stone-50 border-stone-200 rounded-lg px-3 py-2 text-sm text-neutral-600 focus:ring-neutral-900 focus:border-neutral-900"
                                id="profile-link"
                            >
                            <button
                                onclick="copyProfileLink()"
                                class="bg-neutral-900 hover:bg-neutral-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300"
                            >
                                Kopiëren
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if($wishlistItems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($wishlistItems as $product)
                        <div class="bg-white rounded-lg border border-stone-100 overflow-hidden hover:shadow-md transition duration-300 group flex flex-col h-full">
                            <a href="{{ route('products.show', $product) }}" class="block">
                                @if($product->image)
                                    <img
                                        src="{{ $product->imageUrl() }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover bg-stone-50"
                                    >
                                @else
                                    <div class="w-full h-48 bg-stone-50 flex items-center justify-center">
                                        <span class="text-stone-300 text-xs uppercase tracking-widest">Geen afbeelding</span>
                                    </div>
                                @endif
                            </a>

                            <div class="p-4 flex flex-col flex-grow">
                                <p class="text-xs text-neutral-400 mb-1 uppercase tracking-wide">
                                    {{ $product->category->name }}
                                </p>

                                <h3 class="font-medium text-neutral-900 text-sm mb-1 group-hover:text-neutral-600 transition">
                                    <a href="{{ route('products.show', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-neutral-800 font-semibold text-sm">
                                        {{ $product->formattedPrice() }}
                                    </span>
                                    @if($product->isInStock())
                                        <span class="text-[10px] text-green-600 bg-green-50 px-2 py-0.5 rounded-full uppercase tracking-wide font-medium">Op voorraad</span>
                                    @else
                                        <span class="text-[10px] text-red-600 bg-red-50 px-2 py-0.5 rounded-full uppercase tracking-wide font-medium">Uitverkocht</span>
                                    @endif
                                </div>

                                <div class="mt-auto flex items-center gap-2 pt-4 border-t border-stone-50">
                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        class="flex-1 text-center bg-stone-100 hover:bg-stone-200 text-neutral-700 text-xs font-medium py-2 rounded-lg transition"
                                    >
                                        Bekijk
                                    </a>
                                    <form action="{{ route('wishlist.destroy', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="bg-white border border-stone-200 text-neutral-400 hover:text-red-600 hover:border-red-200 p-2 rounded-lg transition"
                                            title="Verwijderen"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 bg-white border border-stone-100 rounded-xl p-6">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-neutral-500 uppercase tracking-wide font-medium">
                            Totaal aantal items
                        </span>
                        <span class="text-neutral-900 font-semibold">
                            {{ $wishlistItems->count() }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-lg mt-2 pt-2 border-t border-stone-50">
                        <span class="text-neutral-500 uppercase tracking-wide font-medium text-sm">
                            Totaalprijs
                        </span>
                        <span class="text-neutral-900 font-bold">
                            €{{ number_format($totalPrice, 2, ',', '.') }}
                        </span>
                    </div>
                </div>

            @else
                <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-12 text-center">
                    <div class="mx-auto w-12 h-12 bg-stone-50 rounded-full flex items-center justify-center mb-4 text-neutral-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-neutral-900 mb-2">
                        Je verlanglijstje is leeg
                    </h3>
                    <p class="text-neutral-500 font-light mb-8 max-w-sm mx-auto">
                        Voeg producten toe aan je verlanglijstje om ze later terug te vinden.
                    </p>
                    <a
                        href="{{ route('products.index') }}"
                        class="inline-block bg-neutral-900 hover:bg-neutral-700 text-white text-xs uppercase tracking-widest font-medium px-8 py-3 rounded-full transition duration-300"
                    >
                        Bekijk producten
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyProfileLink() {
            const input = document.getElementById('profile-link');
            input.select();
            document.execCommand('copy');
            alert('Link gekopieerd');
        }
    </script>
</x-app-layout>
