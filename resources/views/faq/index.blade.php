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
                        <div class="bg-white border border-border shadow-sm rounded-lg overflow-hidden">
                            {{-- Category Header --}}
                            <div class="bg-beige px-8 py-6 border-b border-border">
                                <h3 class="text-2xl font-serif text-primary">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-xs uppercase tracking-widest text-secondary mt-2 font-medium">
                                    {{ $category->questions->count() }}
                                    {{ Str::plural('vraag', $category->questions->count()) }}
                                </p>
                            </div>

                            {{-- Questions Accordion --}}
                            @if($category->questions->count() > 0)
                                <div class="divide-y divide-border">
                                    @foreach($category->questions as $question)
                                        <details class="group">
                                            <summary class="px-8 py-6 cursor-pointer hover:bg-beige transition duration-300 list-none">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm font-bold text-primary uppercase tracking-wide pr-8">
                                                        {{ $question->question }}
                                                    </h4>
                                                    <span class="text-secondary group-open:rotate-180 transition-transform duration-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </summary>
                                            <div class="px-8 pb-8 pt-2 bg-white">
                                                <div class="text-secondary leading-relaxed font-light">
                                                    {!! nl2br(e($question->answer)) !!}
                                                </div>
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
