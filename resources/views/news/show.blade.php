<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-[#FDFBF7] py-4">
            <h2 class="font-serif text-3xl text-[#3E2C22] leading-tight tracking-wide">
                {{ $news->title }}
            </h2>
            <a
                href="{{ route('news.index') }}"
                class="text-[#8C7B70] hover:text-[#3E2C22] transition duration-300 text-xs uppercase tracking-widest font-medium"
            >
                ← Terug naar overzicht
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#EAE5DE] shadow-sm overflow-hidden rounded-lg">

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="m-6 bg-[#EAE5DE] border-l-2 border-[#3E2C22] text-[#3E2C22] px-6 py-4 rounded-r-lg">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Featured Image --}}
                @if($news->image)
                    <div class="aspect-w-16 aspect-h-9 w-full">
                        <img
                            src="{{ $news->imageUrl() }}"
                            alt="{{ $news->title }}"
                            class="w-full h-96 object-cover"
                        >
                    </div>
                @endif

                {{-- Content --}}
                <div class="p-8 md:p-12">

                    {{-- Meta --}}
                    <div class="flex flex-wrap items-center text-[#8C7B70] text-xs uppercase tracking-widest font-medium mb-8 pb-8 border-b border-[#EAE5DE] gap-y-4">
                        <div class="flex items-center mr-6">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $news->formattedDate() }}</span>
                        </div>

                        @if($news->author)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Door {{ $news->author->name }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Article Content --}}
                    <div class="prose prose-lg max-w-none prose-headings:font-serif prose-headings:text-[#3E2C22] prose-p:text-[#5D4037] prose-p:leading-relaxed prose-a:text-[#8C7B70] hover:prose-a:text-[#3E2C22] prose-strong:text-[#3E2C22] prose-li:text-[#5D4037]">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    {{-- Admin Actions --}}
                    @auth
                        @if(auth()->user()->is_admin)
                            <div class="mt-12 pt-8 border-t border-[#EAE5DE] flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                                <a
                                    href="{{ route('news.edit', $news) }}"
                                    class="inline-block w-full sm:w-auto border border-[#3E2C22] text-[#3E2C22] hover:bg-[#3E2C22] hover:text-[#F5F0EB] text-xs uppercase tracking-widest px-8 py-3 rounded-full text-center transition duration-300"
                                >
                                    Bewerken
                                </a>
                                <form
                                    action="{{ route('news.destroy', $news) }}"
                                    method="POST"
                                    onsubmit="return confirm('Weet je zeker dat je dit nieuwsartikel wilt verwijderen?')"
                                    class="inline-block w-full sm:w-auto"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="w-full sm:w-auto border border-[#3E2C22] text-[#3E2C22] hover:bg-[#3E2C22] hover:text-[#F5F0EB] text-xs uppercase tracking-widest px-8 py-3 rounded-full transition duration-300"
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
    </div>
</x-app-layout>
