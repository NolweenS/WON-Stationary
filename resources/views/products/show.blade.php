<x-guest-layout>
    <div class="bg-nude border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <button onclick="window.history.back()"
               class="inline-flex items-center text-xs font-semibold text-secondary uppercase tracking-widest hover:text-primary transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Terug
            </button>
        </div>
    </div>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            <div class="max-w-4xl mx-auto">

                <div class="relative group mb-8">
                    <div class="rounded-lg overflow-hidden border border-border bg-nude max-w-2xl mx-auto">
                        @if($product->image)
                            <img src="{{ $product->imageUrl() }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-auto object-center object-cover">
                        @else
                            <div class="w-full h-64 flex items-center justify-center text-secondary opacity-50">
                                <span class="text-sm uppercase">Geen afbeelding</span>
                            </div>
                        @endif
                    </div>

                    @if($product->is_featured)
                        <span class="absolute top-4 left-4 bg-primary text-white text-xs px-3 py-1 rounded uppercase tracking-widest font-bold">
                            Topkeuze
                        </span>
                    @endif
                </div>

                <div class="px-2 sm:px-0">
                    <h2 class="text-sm tracking-widest text-secondary uppercase mb-2">{{ $product->category->name ?? 'Algemeen' }}</h2>
                    <h1 class="text-4xl font-serif text-primary tracking-tight mb-4">{{ $product->name }}</h1>

                    <div class="flex items-center mb-4">
                        <x-star-rating :rating="round($product->averageRating())" />
                        <span class="ml-2 text-xs text-secondary uppercase tracking-wide">
                            ({{ $product->reviews->count() }} reviews)
                        </span>
                    </div>

                    <div class="mt-3 flex items-end justify-between border-b border-border pb-6">
                        <p class="text-3xl text-primary font-serif">{{ $product->formattedPrice() }}</p>

                        @if($product->stock > 5)
                            <p class="text-sm text-green-600 font-medium flex items-center">
                                <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                Op voorraad
                            </p>
                        @elseif($product->stock > 0)
                            <p class="text-sm text-orange-500 font-medium flex items-center">
                                <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                                Bijna op ({{ $product->stock }})
                            </p>
                        @else
                            <p class="text-sm text-red-600 font-medium flex items-center">
                                <span class="w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                                Uitverkocht
                            </p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-primary uppercase tracking-wider mb-2">Omschrijving</h3>
                        <div class="text-secondary font-light leading-relaxed text-sm">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="mt-10">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center gap-4">
                                    <button type="submit" class="flex-1 bg-primary border border-transparent rounded-full py-4 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-[#2A1E17] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition duration-300 uppercase tracking-widest text-xs">
                                        In Winkelwagen
                                    </button>

                                    @auth
                                        <button onclick="toggleWishlist(event, this)" data-url="{{ route('wishlist.toggle', $product) }}" class="p-4 rounded-full border border-border text-secondary hover:text-primary hover:border-primary transition group">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 icon-outline {{ auth()->user()->hasInWishlist($product) ? 'hidden' : '' }}">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-500 icon-filled {{ auth()->user()->hasInWishlist($product) ? '' : 'hidden' }}">
                                                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.5 3c1.76 0 3.31.81 4.25 2.09C12.69 3.81 14.24 3 16.5 3 19.285 3 21.75 5.322 21.75 8.25c0 3.926-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                            </svg>
                                        </button>
                                    @endauth
                                </div>
                            </form>
                        @else
                            <button disabled class="w-full bg-border border border-transparent rounded-full py-4 px-8 flex items-center justify-center text-base font-medium text-secondary cursor-not-allowed uppercase tracking-widest text-xs">
                                Niet beschikbaar
                            </button>
                        @endif
                    </div>

                    @auth
                        @if(auth()->user()->is_admin)
                            <div class="mt-6 flex items-center space-x-3 pt-6 border-t border-border">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-[#8C7B70] hover:text-[#3E2C22] transition" title="Bewerken">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');" class="inline-flex">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[#8C7B70] hover:text-red-700 transition" title="Verwijderen">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="mt-24 border-t border-border pt-16">
                <h2 class="text-2xl font-serif text-primary mb-8">Klantbeoordelingen</h2>

                <div class="lg:grid lg:grid-cols-12 lg:gap-12">
                    <div class="lg:col-span-4 mb-12 lg:mb-0">
                        @auth
                            <div class="bg-beige p-6 rounded-lg border border-border">
                                <h3 class="text-lg font-serif text-primary mb-4">Schrijf een review</h3>
                                <form action="{{ route('reviews.store', $product) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-xs uppercase tracking-widest text-secondary mb-2">Waardering</label>
                                        <div class="flex flex-row-reverse justify-end gap-1 group">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="star{{$i}}" name="rating" value="{{ $i }}" class="peer hidden" />
                                                <label for="star{{$i}}" class="cursor-pointer text-border peer-checked:text-primary hover:text-primary peer-hover:text-primary transition-colors">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-xs uppercase tracking-widest text-secondary mb-2">Opmerking</label>
                                        <textarea name="comment" rows="3" class="w-full rounded-md border-border bg-white focus:border-primary focus:ring-primary sm:text-sm"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-primary text-white py-2 rounded text-xs uppercase tracking-widest font-bold hover:bg-[#2A1E17] transition">Plaatsen</button>
                                </form>
                            </div>
                        @else
                            <div class="bg-beige p-6 rounded-lg border border-border text-center">
                                <p class="text-secondary text-sm mb-4">Log in om een review te schrijven.</p>
                                <a href="{{ route('login') }}" class="text-primary font-bold underline text-xs uppercase tracking-widest">Inloggen</a>
                            </div>
                        @endauth
                    </div>

                    <div class="lg:col-span-8 space-y-6">
                        @forelse($product->reviews as $review)
                            <x-review-card :review="$review" />
                        @empty
                            <p class="text-secondary italic">Nog geen reviews voor dit product.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="mt-24">
                    <h3 class="text-2xl font-serif text-primary mb-8 text-center">Ook interessant</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($relatedProducts as $related)
                            <x-product-card :product="$related" />
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    @auth
        <script>
            function toggleWishlist(event, button) {
                event.preventDefault();
                const url = button.dataset.url;
                const filledIcon = button.querySelector('.icon-filled');
                const outlineIcon = button.querySelector('.icon-outline');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (data.in_wishlist) {
                                filledIcon.classList.remove('hidden');
                                outlineIcon.classList.add('hidden');
                            } else {
                                filledIcon.classList.add('hidden');
                                outlineIcon.classList.remove('hidden');
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
    @endauth
</x-guest-layout>
