<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-[#FDFBF7] py-4">
            <h2 class="font-serif text-3xl text-[#3E2C22] leading-tight tracking-wide">
                Nieuws
            </h2>
            @auth
                @if(auth()->user()->is_admin)
                    <a
                        href="{{ route('news.create') }}"
                        class="bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-sm uppercase tracking-widest px-6 py-3 transition duration-300 ease-in-out"
                    >
                        + Nieuw artikel
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-8 bg-[#EAE5DE] border-l-2 border-[#3E2C22] text-[#3E2C22] px-6 py-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- News Grid --}}
            @if($newsItems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($newsItems as $newsItem)
                        <div class="group bg-white hover:bg-[#F5F0EB] transition duration-500 ease-in-out flex flex-col h-full border border-transparent hover:border-[#EAE5DE]">
                            {{-- Image --}}
                            @if($newsItem->image)
                                <div class="overflow-hidden aspect-w-16 aspect-h-9">
                                    <img
                                        src="{{ $newsItem->imageUrl() }}"
                                        alt="{{ $newsItem->title }}"
                                        class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-700 ease-out grayscale-[10%] group-hover:grayscale-0"
                                    >
                                </div>
                            @endif

                            {{-- Content --}}
                            <div class="p-8 flex-grow flex flex-col justify-between">
                                <div>
                                    {{-- Meta --}}
                                    <div class="flex items-center text-xs text-[#8C7B70] mb-4 uppercase tracking-widest font-medium">
                                        <span>{{ $newsItem->formattedDate() }}</span>
                                        @if($newsItem->isRecent())
                                            <span class="ml-3 bg-[#3E2C22] text-[#F5F0EB] px-2 py-0.5 text-[10px]">
                                                NIEUW
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Title --}}
                                    <h3 class="text-2xl font-serif text-[#3E2C22] mb-3 leading-snug">
                                        <a href="{{ route('news.show', $newsItem) }}" class="hover:underline decoration-1 underline-offset-4 decoration-[#8C7B70]">
                                            {{ $newsItem->title }}
                                        </a>
                                    </h3>

                                    {{-- Excerpt --}}
                                    <p class="text-[#5D4037] text-sm leading-relaxed mb-6 font-light">
                                        {{ $newsItem->excerpt(120) }}
                                    </p>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center justify-between pt-6 border-t border-[#EAE5DE]">
                                    <a
                                        href="{{ route('news.show', $newsItem) }}"
                                        class="text-[#3E2C22] text-xs uppercase tracking-widest hover:text-[#8C7B70] transition font-semibold"
                                    >
                                        Lees meer
                                    </a>

                                    @auth
                                        @if(auth()->user()->is_admin)
                                            <div class="flex space-x-4">
                                                <a
                                                    href="{{ route('news.edit', $newsItem) }}"
                                                    class="text-[#8C7B70] hover:text-[#3E2C22] text-xs font-serif italic"
                                                >
                                                    Bewerken
                                                </a>
                                                <form
                                                    action="{{ route('news.destroy', $newsItem) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Weet je zeker dat je dit nieuwsartikel wilt verwijderen?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="text-[#8C7B70] hover:text-red-900 text-xs font-serif italic"
                                                    >
                                                        Verwijderen
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12 text-[#3E2C22]">
                    {{ $newsItems->links() }}
                </div>
            @else
                <div class="bg-[#F5F0EB] p-16 text-center border border-[#EAE5DE]">
                    <p class="text-[#3E2C22] text-xl font-serif mb-6">Er zijn nog geen nieuwsartikelen.</p>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a
                                href="{{ route('news.create') }}"
                                class="inline-block bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest px-8 py-3 transition"
                            >
                                Maak het eerste artikel
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>
    </div>
</x-guest-layout>
