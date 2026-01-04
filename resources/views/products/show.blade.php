<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Melding na bewerken/reviewen --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            {{-- PRODUCT DETAILS SECTIE --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-12">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                        {{-- Linkerkolom: Afbeelding --}}
                        <div class="relative">
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-gray-400 text-lg">Geen afbeelding</div>
                                @endif
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
                            <div class="mb-2 flex justify-between items-start">
                                <span class="text-sm text-gray-500 uppercase tracking-wide">
                                    {{ $product->category->name ?? 'Geen categorie' }}
                                </span>

                                {{-- Korte rating weergave bovenaan --}}
                                @if($product->reviews->count() > 0)
                                    <div class="flex items-center text-yellow-400 text-sm">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="ml-1 text-gray-600 font-medium">{{ number_format($product->averageRating(), 1) }}</span>
                                    </div>
                                @endif
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
                                    {{-- Toevoegen aan winkelwagen --}}
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

            {{-- SECTIE: REVIEWS EN BEOORDELINGEN --}}
            <div class="mt-12 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Klantbeoordelingen</h3>

                    {{-- Deel 1: Score Samenvatting --}}
                    <div class="flex items-center mb-10 bg-gray-50 p-4 rounded-lg inline-block border border-gray-100">
                        <div class="flex items-center">
                            @php $avgRating = round($product->averageRating()); @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="ml-3 text-sm font-medium text-gray-600">
                            <span class="text-gray-900 font-bold text-lg">{{ number_format($product->averageRating(), 1) }}</span> / 5
                            <span class="text-gray-300 mx-2">|</span>
                            {{ $product->reviews->count() }} reviews
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                        {{-- Deel 2: Het Review Formulier (Linkerkant - 5 kolommen) --}}
                        <div class="lg:col-span-5">
                            @auth
                                {{-- Check: Heeft deze user al een review geschreven? --}}
                                @if($product->reviews->where('user_id', auth()->id())->count() > 0)
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <h4 class="text-green-800 font-semibold text-lg">Bedankt voor uw feedback!</h4>
                                        <p class="text-green-700 mt-2 text-sm">U heeft dit product al beoordeeld.</p>
                                    </div>
                                @else
                                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                        <h4 class="text-lg font-bold text-gray-900 mb-4">Schrijf een review</h4>

                                        <form action="{{ route('reviews.store', $product) }}" method="POST">
                                            @csrf

                                            {{-- Rating Selectie --}}
                                            <div class="mb-5">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Uw waardering</label>
                                                <div class="flex flex-row-reverse justify-end gap-1 group">
                                                    {{-- Slimme CSS truck: flex-row-reverse zodat we hover effecten kunnen doen --}}
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" id="star{{$i}}" name="rating" value="{{ $i }}" class="peer hidden" required />
                                                        <label for="star{{$i}}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors">
                                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                        </label>
                                                    @endfor
                                                </div>
                                                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                            </div>

                                            {{-- Commentaar Veld --}}
                                            <div class="mb-5">
                                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Uw ervaring (optioneel)</label>
                                                <textarea name="comment" id="comment" rows="4"
                                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-gray-400"
                                                          placeholder="Vertel ons wat u van het product vindt..."></textarea>
                                                @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                            </div>

                                            <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 transition font-bold shadow-sm text-sm">
                                                Plaats Review
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                {{-- Niet ingelogd melding --}}
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    <h4 class="text-gray-900 font-medium mb-2">Wilt u een review schrijven?</h4>
                                    <p class="text-gray-500 mb-6 text-sm">Log in of maak een account aan om uw mening te delen.</p>
                                    <div class="flex gap-4 justify-center">
                                        <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Inloggen</a>
                                        <span class="text-gray-300">|</span>
                                        <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Registreren</a>
                                    </div>
                                </div>
                            @endauth
                        </div>

                        {{-- Deel 3: Lijst met Reviews (Rechterkant - 7 kolommen) --}}
                        <div class="lg:col-span-7">
                            @if($product->reviews->count() > 0)
                                <div class="space-y-6">
                                    @foreach($product->reviews as $review)
                                        <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                            <div class="flex justify-between items-start">
                                                <div class="flex items-center">
                                                    {{-- Avatar Placeholder (Initialen) --}}
                                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm border border-indigo-200">
                                                        {{ substr($review->user->name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-bold text-gray-900">
                                                            {{ $review->user->name }}
                                                            @if(auth()->check() && auth()->id() === $review->user_id)
                                                                <span class="ml-2 text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full border border-gray-200">Jij</span>
                                                            @endif
                                                        </p>
                                                        {{-- Gebruik de timeAgo methode uit je model --}}
                                                        <p class="text-xs text-gray-500">{{ $review->timeAgo() }}</p>
                                                    </div>
                                                </div>

                                                {{-- Sterren weergave bij review --}}
                                                <div class="flex text-yellow-400">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>

                                            @if($review->comment)
                                                <div class="mt-4 text-gray-700 text-sm leading-relaxed bg-gray-50 p-3 rounded-md border border-gray-50">
                                                    {{ $review->comment }}
                                                </div>
                                            @endif

                                            {{-- Verwijderknop: Alleen zichtbaar voor admin of de auteur --}}
                                            @auth
                                                @if(auth()->user()->is_admin || auth()->id() === $review->user_id)
                                                    <div class="mt-3 flex justify-end">
                                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Weet u zeker dat u deze review wilt verwijderen?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center transition-colors">
                                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Review verwijderen
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">Nog geen reviews.</p>
                                    <p class="text-sm text-gray-400">Wees de eerste om dit product te beoordelen!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gerelateerde Producten Sectie --}}
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="mt-12">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Andere klanten bekeken ook</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('products.show', $related) }}" class="group bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    @if($related->image)
                                        <img src="{{ Storage::url($related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">Geen foto</div>
                                    @endif
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
