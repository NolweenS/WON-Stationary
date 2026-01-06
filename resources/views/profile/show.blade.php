<x-app-layout>
    <x-slot name="header">
        <h2 class="font-light text-xl text-neutral-800 leading-tight tracking-wide">
            {{ __('Mijn Profiel') }}
        </h2>
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

            <div class="bg-white shadow-sm rounded-2xl border border-stone-100 overflow-hidden mb-8">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        <div class="flex-shrink-0">
                            @if($user->profile && $user->profile->profile_photo)
                                <img
                                    src="{{ asset('storage/' . $user->profile->profile_photo) }}"
                                    alt="Profile Photo"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-stone-50 shadow-sm"
                                >
                            @else
                                <div class="w-32 h-32 rounded-full bg-stone-100 flex items-center justify-center border-4 border-white">
                                    <span class="text-stone-400 text-4xl font-light">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 text-center md:text-left w-full">
                            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                                <div>
                                    <h1 class="text-3xl font-medium text-neutral-900 tracking-tight">
                                        {{ $user->profile->username ?? $user->name }}
                                    </h1>
                                </div>

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
                </div>
            </div>

            @if($user->profile && $user->profile->birthday)
                <div class="bg-white shadow-sm rounded-2xl border border-stone-100 p-8 mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-light text-neutral-800 mb-1">
                                Verjaardag
                            </h3>
                            <p class="text-xl font-medium text-neutral-900">
                                {{ $user->profile->nextBirthday() }}
                            </p>
                            @if($user->profile->age())
                                <p class="text-neutral-500 text-sm mt-1">
                                    {{ $user->profile->age() }} jaar
                                </p>
                            @endif
                        </div>
                        @if($user->profile->isBirthday())
                            <div class="text-sm bg-neutral-900 text-white px-4 py-2 rounded-full uppercase tracking-widest">
                                Fijne verjaardag
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($user->wishlist && $user->wishlist->count() > 0)
                <div class="mt-12">
                    <div class="flex items-center justify-between mb-6 border-b border-stone-100 pb-4">
                        <h3 class="text-lg font-light text-neutral-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3 text-neutral-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            Verlanglijstje van {{ $user->profile->username ?? $user->name }}
                        </h3>
                        @auth
                            @if(auth()->id() === $user->id)
                                <a href="{{ route('wishlist.index') }}" class="text-neutral-500 hover:text-neutral-800 text-xs uppercase tracking-widest font-medium">
                                    Beheren
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($user->wishlist as $product)
                            <div class="bg-white rounded-lg border border-stone-100 overflow-hidden hover:shadow-md transition duration-300 group">
                                @if($product->image)
                                    <img
                                        src="{{ $product->imageUrl() }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover bg-stone-50"
                                    >
                                @endif
                                <div class="p-4">
                                    <p class="text-xs text-neutral-400 mb-1 uppercase tracking-wide">{{ $product->category->name }}</p>
                                    <h4 class="font-medium text-neutral-900 text-sm mb-2 group-hover:text-neutral-600 transition">{{ $product->name }}</h4>
                                    <p class="text-neutral-800 font-semibold text-sm">{{ $product->formattedPrice() }}</p>

                                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-stone-50">
                                        <a href="{{ route('products.show', $product) }}" class="text-xs text-neutral-500 hover:text-neutral-900 font-medium uppercase tracking-wider">
                                            Bekijk
                                        </a>
                                        @auth
                                            @if(auth()->id() === $user->id)
                                                <form action="{{ route('wishlist.destroy', $product) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-400 hover:text-red-600 font-medium uppercase tracking-wider">
                                                        Verwijder
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 p-6 bg-white border border-stone-100 rounded-xl">
                        <div class="flex items-center justify-between">
                            <span class="text-neutral-500 text-sm font-medium uppercase tracking-wide">Totaalprijs</span>
                            <span class="text-xl font-medium text-neutral-900">
                                €{{ number_format($user->wishlist->sum('price'), 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                @auth
                    @if(auth()->id() === $user->id)
                        <div class="mt-12 p-8 bg-white border border-stone-100 rounded-xl text-center">
                            <p class="text-neutral-400 text-sm mb-4">Je verlanglijstje is nog leeg.</p>
                            <a href="{{ route('products.index') }}" class="inline-block bg-neutral-900 text-white text-xs uppercase tracking-widest font-medium px-6 py-2 rounded-full hover:bg-neutral-700 transition">
                                Bekijk producten
                            </a>
                        </div>
                    @endif
                @endauth
            @endif

            @if($user->favorites && $user->favorites->count() > 0)
                <div class="mt-12">
                    <h3 class="text-sm font-medium text-neutral-500 mb-4 uppercase tracking-widest">Favorieten</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->favorites as $product)
                            <a
                                href="{{ route('products.show', $product->slug ?? $product->id) }}"
                                class="bg-white border border-stone-200 text-neutral-600 px-4 py-2 rounded-lg text-xs hover:bg-neutral-800 hover:text-white hover:border-neutral-800 transition duration-300"
                            >
                                {{ $product->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($user->reviews && $user->reviews->count() > 0)
                <div class="mt-12 border-t border-stone-100 pt-8">
                    <h3 class="text-lg font-light text-neutral-800 mb-6">Recente Reviews</h3>
                    <div class="space-y-6">
                        @foreach($user->reviews as $review)
                            <div class="flex items-start bg-white p-6 rounded-xl border border-stone-50 shadow-sm">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <a
                                            href="{{ route('products.show', $review->product->slug ?? $review->product->id) }}"
                                            class="font-medium text-neutral-900 text-sm hover:underline"
                                        >
                                            {{ $review->product->name }}
                                        </a>
                                        <span class="text-neutral-300 text-xs">{{ $review->timeAgo() }}</span>
                                    </div>

                                    <div class="flex space-x-0.5 mb-3">
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

            <div class="mt-16 border-t border-stone-200 pt-10">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-light text-neutral-900">Gastenboek</h3>
                    <span class="text-xs bg-white text-neutral-500 px-3 py-1 rounded-full border border-stone-200 shadow-sm">
                        {{ $user->receivedMessages->count() }} berichten
                    </span>
                </div>

                @auth
                    <form action="{{ route('profile.message.store', $user) }}" method="POST" class="bg-white p-6 rounded-xl border border-stone-100 shadow-sm mb-10">
                        @csrf
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-neutral-700 mb-2">
                                Laat een bericht achter voor {{ $user->profile->username ?? $user->name }}
                            </label>
                            <textarea
                                name="message"
                                id="message"
                                rows="3"
                                class="w-full rounded-lg border-stone-200 bg-stone-50 shadow-sm focus:border-neutral-900 focus:ring-neutral-900 text-sm placeholder-stone-400"
                                placeholder="Schrijf hier je bericht..."
                                required
                            ></textarea>
                            @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-neutral-900 hover:bg-neutral-700 text-white text-xs uppercase tracking-widest font-medium px-6 py-2 rounded-full transition duration-300">
                                Plaats bericht
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mb-10 bg-stone-100 border border-stone-200 rounded-xl p-6 text-center">
                        <p class="text-stone-600 text-sm">
                            <a href="{{ route('login') }}" class="font-bold underline text-neutral-900">Log in</a> om een bericht achter te laten.
                        </p>
                    </div>
                @endauth

                @if($user->profileMessages->count() > 0)
                    <div class="space-y-6">
                        @foreach($user->profileMessages as $message)
                            <div class="bg-white p-6 rounded-xl border border-stone-100 shadow-sm transition hover:border-stone-200">

                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4 w-full">
                                        <div class="flex-shrink-0">
                                            @if($message->sender->profile && $message->sender->profile->profile_photo)
                                                <img src="{{ asset('storage/' . $message->sender->profile->profile_photo) }}" class="w-10 h-10 rounded-full object-cover border border-stone-100">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-stone-100 flex items-center justify-center text-stone-400 font-bold text-xs border border-stone-200">
                                                    {{ substr($message->sender->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="w-full">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <span class="font-medium text-neutral-900 text-sm">
                                                        {{ $message->sender->profile->username ?? $message->sender->name }}
                                                    </span>
                                                    <span class="text-xs text-stone-400">&bull;</span>
                                                    <span class="text-xs text-stone-400">{{ $message->created_at->diffForHumans() }}</span>
                                                </div>

                                                @auth
                                                    @if(auth()->id() === $message->from_user_id || auth()->user()->is_admin)
                                                        <form action="{{ route('profile.message.destroy', $message) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-stone-300 hover:text-red-500 transition duration-200">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                            <p class="text-neutral-600 text-sm mt-1 leading-relaxed whitespace-pre-line">{{ $message->message }}</p>

                                            @if($message->replies->count() > 0)
                                                <div class="mt-4 pt-4 border-t border-stone-50 space-y-4">
                                                    @foreach($message->replies as $reply)
                                                        <div class="flex items-start space-x-3 bg-stone-50 p-3 rounded-lg">
                                                            <div class="flex-shrink-0">
                                                                @if($reply->sender->profile && $reply->sender->profile->profile_photo)
                                                                    <img src="{{ asset('storage/' . $reply->sender->profile->profile_photo) }}" class="w-8 h-8 rounded-full object-cover">
                                                                @else
                                                                    <div class="w-8 h-8 rounded-full bg-white border border-stone-200 flex items-center justify-center text-xs text-stone-500 font-bold">
                                                                        {{ substr($reply->sender->name, 0, 1) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="w-full">
                                                                <div class="flex justify-between items-center">
                                                                    <div class="flex items-center gap-2">
                                                                        <span class="font-medium text-xs text-neutral-800">{{ $reply->sender->profile->username ?? $reply->sender->name }}</span>
                                                                        <span class="text-[10px] text-stone-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                                    </div>
                                                                    @auth
                                                                        @if(auth()->id() === $reply->from_user_id || auth()->user()->is_admin)
                                                                            <form action="{{ route('profile.message.destroy', $reply) }}" method="POST">
                                                                                @csrf @method('DELETE')
                                                                                <button type="submit" class="text-stone-300 hover:text-red-500 p-0.5">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                                                    </svg>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    @endauth
                                                                </div>
                                                                <p class="text-neutral-600 text-xs mt-1">{{ $reply->message }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @auth
                                                <details class="mt-3 group">
                                                    <summary class="list-none cursor-pointer flex items-center gap-1 text-xs font-medium text-neutral-500 hover:text-neutral-900 transition w-fit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                        </svg>
                                                        <span>Reageer</span>
                                                    </summary>

                                                    <form action="{{ route('profile.message.store', $user) }}" method="POST" class="mt-3 flex gap-2">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $message->id }}">

                                                        <input
                                                            type="text"
                                                            name="message"
                                                            class="w-full text-xs rounded-full border-stone-200 focus:border-neutral-900 focus:ring-neutral-900 bg-stone-50"
                                                            placeholder="Schrijf een reactie..."
                                                            required
                                                        >
                                                        <button type="submit" class="bg-neutral-800 text-white text-xs px-4 py-2 rounded-full hover:bg-neutral-600 transition">
                                                            Verzend
                                                        </button>
                                                    </form>
                                                </details>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-xl border border-dashed border-stone-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto text-stone-300 mb-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.37" />
                        </svg>
                        <p class="text-stone-500 text-sm">Nog geen berichten in het gastenboek.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
