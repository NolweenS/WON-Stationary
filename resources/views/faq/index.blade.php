<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-nude py-4">
            <h2 class="font-serif text-3xl text-primary leading-tight tracking-wide">
                Veelgestelde Vragen (FAQ)
            </h2>
            @auth
                @if(auth()->user()->is_admin)
                    <div class="flex space-x-3">
                        <a
                            href="{{ route('faq.admin.categories.index') }}"
                            class="bg-beige hover:bg-border text-primary text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold border border-border"
                        >
                            Categorieën beheren
                        </a>
                        <a
                            href="{{ route('faq.admin.questions.index') }}"
                            class="bg-primary hover:bg-[#2A1E17] text-white text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold"
                        >
                            Vragen beheren
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12 bg-nude min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($categories->count() > 0)
                <div class="space-y-8">
                    @foreach($categories as $category)
                        <div class="bg-white border border-border shadow-sm rounded-lg overflow-hidden relative group/cat">
                            {{-- Category Header --}}
                            <div class="bg-beige px-8 py-6 border-b border-border flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl font-serif text-primary">
                                        {{ $category->name }}
                                    </h3>
                                    <p class="text-xs uppercase tracking-widest text-secondary mt-2 font-medium">
                                        {{ $category->questions->count() }}
                                        {{ Str::plural('vraag', $category->questions->count()) }}
                                    </p>
                                </div>
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <div class="flex space-x-2 opacity-0 group-hover/cat:opacity-100 transition-opacity duration-200">
                                            <a href="{{ route('faq.admin.categories.edit', $category) }}" class="text-secondary hover:text-primary" title="Categorie bewerken">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                            </div>

                            {{-- Questions Accordion --}}
                            @if($category->questions->count() > 0)
                                <div class="divide-y divide-border">
                                    @foreach($category->questions as $question)
                                        <details class="group">
                                            <summary class="px-8 py-6 cursor-pointer hover:bg-beige transition duration-300 list-none relative pr-12">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm font-bold text-primary uppercase tracking-wide">
                                                        {{ $question->question }}
                                                    </h4>
                                                    <span class="text-secondary group-open:rotate-180 transition-transform duration-300 absolute right-8 top-6">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </summary>
                                            <div class="px-8 pb-8 pt-2 bg-white relative">
                                                <div class="text-secondary leading-relaxed font-light">
                                                    {!! nl2br(e($question->answer)) !!}
                                                </div>
                                                @auth
                                                    @if(auth()->user()->is_admin)
                                                        <div class="mt-4 pt-4 border-t border-dashed border-border flex justify-end space-x-4">
                                                            <a href="{{ route('faq.admin.questions.edit', $question) }}" class="text-xs text-secondary hover:text-primary uppercase tracking-widest font-bold flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                </svg>
                                                                Bewerken
                                                            </a>
                                                            <form action="{{ route('faq.admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze vraag wilt verwijderen?');" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-xs text-secondary hover:text-red-600 uppercase tracking-widest font-bold flex items-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                    </svg>
                                                                    Verwijderen
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                        </details>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-8 py-8 text-center text-secondary italic font-serif">
                                    Nog geen vragen in deze categorie.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-beige p-16 text-center border border-border rounded-lg">
                    <p class="text-primary text-xl font-serif mb-6">Er zijn nog geen FAQ's beschikbaar.</p>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a
                                href="{{ route('faq.admin.categories.create') }}"
                                class="inline-block bg-primary hover:bg-[#2A1E17] text-white text-xs uppercase tracking-widest px-8 py-3 rounded-full transition duration-300"
                            >
                                Maak eerste categorie
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>
    </div>
</x-guest-layout>
