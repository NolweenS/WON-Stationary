<x-app-layout>
    <x-slot name="header">
        <h2 class="font-light text-xl text-neutral-800 leading-tight tracking-wide">
            {{ __('Mijn Profiel') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-stone-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Melding (Minimalistisch) --}}
            @if(session('success'))
                <div class="mb-6 bg-white border border-green-200 text-green-700 px-6 py-4 rounded-lg shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Hoofdkaart --}}
            <div class="bg-white shadow-sm rounded-2xl border border-stone-100 overflow-hidden">
                <div class="p-8 md:p-12">

                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">

                        {{-- Profielfoto --}}
                        <div class="flex-shrink-0">
                            @if($user->profile && $user->profile->profile_photo)
                                <img
                                    src="{{ asset('storage/' . $user->profile->profile_photo) }}"
                                    alt="Profile Photo"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-stone-50 shadow-sm"
                                >
                            @else
                                {{-- Minimalistische Fallback Avatar (Zachtgrijs) --}}
                                <div class="w-32 h-32 rounded-full bg-stone-100 flex items-center justify-center border-4 border-white">
                                    <span class="text-stone-400 text-4xl font-light">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Profiel Info --}}
                        <div class="flex-1 text-center md:text-left w-full">
                            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                                <div>
                                    <h1 class="text-3xl font-medium text-neutral-900 tracking-tight">
                                        {{ $user->profile->username ?? $user->name }}
                                    </h1>

                                    @if($user->profile && $user->profile->birthday)
                                        <div class="flex items-center justify-center md:justify-start text-neutral-400 text-sm mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L6 19.5m12-11.25V8.25m0 0v-1.5m0 1.5c0 1.135-.845 2.098-1.976 2.192a48.11 48.11 0 01-3.996.162 48.11 48.11 0 01-3.996-.162C7.845 10.348 7 9.385 7 8.25v1.5m11 0v2.513c0 1.135-.845 2.098-1.976 2.192a48.11 48.11 0 01-3.996.162 48.11 48.11 0 01-3.996-.162C6.845 14.773 6 13.81 6 12.675V10.61" />
                                            </svg>
                                            {{ $user->profile->birthday->format('d F Y') }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Edit Knop (Neutraal Zwart/Grijs) --}}
                                @auth
                                    @if(auth()->id() === $user->id)
                                        <a
                                            href="{{ route('profile.edit') }}"
                                            class="mt-4 md:mt-0 inline-flex items-center bg-neutral-900 hover:bg-neutral-700 text-white text-xs uppercase tracking-widest font-medium px-6 py-2 rounded-full transition duration-300"
                                        >
                                            Bewerken
                                        </a>
                                    @endif
                                @endauth
                            </div>

                            {{-- Over Mij --}}
                            <div class="bg-stone-50 rounded-xl p-6 border border-stone-100 mt-6">
                                <h3 class="text-xs uppercase tracking-widest text-neutral-400 mb-2 font-semibold">Over mij</h3>
                                @if($user->profile && $user->profile->about_me)
                                    <p class="text-neutral-700 leading-relaxed font-light">
                                        {{ $user->profile->about_me }}
                                    </p>
                                @else
                                    <p class="text-neutral-400 italic font-light text-sm">Nog geen informatie ingevuld.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Wishlist Sectie --}}
                    @if($user->wishlist && $user->wishlist->count() > 0)
                        <div class="mt-12">
                            <h3 class="text-lg font-light text-neutral-800 mb-6 flex items-center border-b border-stone-100 pb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3 text-neutral-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                Verlanglijstje
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($user->wishlist as $product)
                                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="block group">
                                        <div class="bg-white rounded-lg p-4 border border-stone-100 hover:border-stone-300 transition duration-300">
                                            <h4 class="font-medium text-neutral-800 text-sm group-hover:text-black">{{ $product->name }}</h4>
                                            <p class="text-neutral-400 text-xs mt-1 font-mono">{{ $product->formattedPrice() }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Favorieten Sectie --}}
                    @if($user->favorites && $user->favorites->count() > 0)
                        <div class="mt-10">
                            <h3 class="text-sm font-medium text-neutral-500 mb-4 uppercase tracking-widest">Favorieten</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->favorites as $product)
                                    <a
                                        href="{{ route('products.show', $product->slug ?? $product->id) }}"
                                        class="bg-stone-50 border border-stone-200 text-neutral-600 px-4 py-2 rounded-lg text-xs hover:bg-neutral-800 hover:text-white hover:border-neutral-800 transition duration-300"
                                    >
                                        {{ $product->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Reviews Sectie --}}
                    @if($user->reviews && $user->reviews->count() > 0)
                        <div class="mt-12 border-t border-stone-100 pt-8">
                            <h3 class="text-lg font-light text-neutral-800 mb-6">Recente Reviews</h3>
                            <div class="space-y-6">
                                @foreach($user->reviews as $review)
                                    <div class="flex items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <a
                                                    href="{{ route('products.show', $review->product->slug ?? $review->product->id) }}"
                                                    class="font-medium text-neutral-900 text-sm hover:underline"
                                                >
                                                    {{ $review->product->name }}
                                                </a>
                                                <span class="text-neutral-300 text-xs">{{ $review->timeAgo() }}</span>
                                            </div>

                                            {{-- Sterren (Neutraal) --}}
                                            <div class="flex space-x-0.5 mb-2">
                                                @foreach(range(1, 5) as $i)
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3 {{ $i <= $review->rating ? 'text-neutral-800' : 'text-stone-200' }}">
                                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                    </svg>
                                                @endforeach
                                            </div>

                                            @if($review->comment)
                                                <p class="text-neutral-500 text-sm font-light leading-relaxed">"{{ $review->comment }}"</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
