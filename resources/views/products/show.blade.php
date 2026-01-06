<x-guest-layout>
    {{-- Breadcrumbs (Pad) --}}
    <div class="bg-nude border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex text-xs font-medium text-secondary uppercase tracking-wider">
                <a href="{{ route('home') }}" class="hover:text-primary transition">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-primary transition">Shop</a>
                <span class="mx-2">/</span>
                <span class="text-primary">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Meldingen --}}
            @if(session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">

                {{-- Linkerkant: Afbeelding --}}
                <div class="relative group">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border border-border bg-nude">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-center object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-secondary opacity-50">
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

                {{-- Rechterkant: Info --}}
                <div class="mt-10 px-2 sm:px-0 sm:mt-16 lg:mt-0">
                    {{-- Categorie & Naam --}}
                    <h2 class="text-sm tracking-widest text-secondary uppercase mb-2">{{ $product->category->name ?? 'Algemeen' }}</h2>
                    <h1 class="text-4xl font-serif text-primary tracking-tight mb-4">{{ $product->name }}</h1>

                    {{-- Rating --}}
                    <div class="flex items-center mb-4">
                        <x-star-rating :rating="round($product->averageRating())" />
                        <span class="ml-2 text-xs text-secondary uppercase tracking-wide">
                            ({{ $product->reviews->count() }} reviews)
                        </span>
                    </div>

                    {{-- Prijs & Voorraad --}}
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

                    {{-- Beschrijving --}}
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-primary uppercase tracking-wider mb-2">Omschrijving</h3>
                        <div class="text-secondary font-light leading-relaxed text-sm">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>

                    {{-- Acties: Toevoegen aan winkelwagen --}}
                    <div class="mt-10">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center gap-4">
                                    <button type="submit" class="flex-1 bg-primary border border-transparent rounded-full py-4 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-[#2A1E17] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition duration-300 uppercase tracking-widest text-xs">
                                        In Winkelwagen
                                    </button>

                                    {{-- Wishlist (Alleen ingelogd) --}}
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

                    {{-- Admin Knoppen --}}
                    @auth
                        @if(auth()->user()->is_admin)
                            <div class="mt-6 flex gap-4 pt-6 border-t border-border">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-xs uppercase tracking-widest font-bold text-primary hover:text-secondary">Bewerken</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Zeker weten?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs uppercase tracking-widest font-bold text-red-600 hover:text-red-800">Verwijderen</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Reviews Sectie --}}
            <div class="mt-24 border-t border-border pt-16">
                <h2 class="text-2xl font-serif text-primary mb-8">Klantbeoordelingen</h2>

                <div class="lg:grid lg:grid-cols-12 lg:gap-12">
                    {{-- Review Formulier (Links) --}}
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

                    {{-- Review Lijst (Rechts) --}}
                    <div class="lg:col-span-8 space-y-6">
                        @forelse($product->reviews as $review)
                            <x-review-card :review="$review" />
                        @empty
                            <p class="text-secondary italic">Nog geen reviews voor dit product.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="mt-24">
                    <h3 class="text-2xl font-serif text-primary mb-8 text-center">Ook interessant</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($relatedProducts as $related)
                            <x-product-card :product="$related" />
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Script voor Wishlist (Alleen laden als ingelogd) --}}
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
