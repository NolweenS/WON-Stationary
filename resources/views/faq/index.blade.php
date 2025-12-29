<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-[#FDFBF7] py-4">
            <h2 class="font-serif text-3xl text-[#3E2C22] leading-tight tracking-wide">
                Veelgestelde Vragen (FAQ)
            </h2>
            @auth
                @if(auth()->user()->is_admin)
                    <div class="flex space-x-3">
                        <a
                            href="{{ route('faq.admin.categories.index') }}"
                            class="bg-[#F5F0EB] hover:bg-[#EAE5DE] text-[#3E2C22] text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold border border-[#EAE5DE]"
                        >
                            Categorieën beheren
                        </a>
                        <a
                            href="{{ route('faq.admin.questions.index') }}"
                            class="bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold"
                        >
                            Vragen beheren
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($categories->count() > 0)
                <div class="space-y-8">
                    @foreach($categories as $category)
                        <div class="bg-white border border-[#EAE5DE] shadow-sm rounded-lg overflow-hidden">
                            {{-- Category Header --}}
                            <div class="bg-[#F5F0EB] px-8 py-6 border-b border-[#EAE5DE]">
                                <h3 class="text-2xl font-serif text-[#3E2C22]">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-xs uppercase tracking-widest text-[#8C7B70] mt-2 font-medium">
                                    {{ $category->questions->count() }}
                                    {{ Str::plural('vraag', $category->questions->count()) }}
                                </p>
                            </div>

                            {{-- Questions Accordion --}}
                            @if($category->questions->count() > 0)
                                <div class="divide-y divide-[#EAE5DE]">
                                    @foreach($category->questions as $question)
                                        <details class="group">
                                            <summary class="px-8 py-6 cursor-pointer hover:bg-[#FDFBF7] transition duration-300 list-none">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm font-bold text-[#3E2C22] uppercase tracking-wide pr-8">
                                                        {{ $question->question }}
                                                    </h4>
                                                    <span class="text-[#8C7B70] group-open:rotate-180 transition-transform duration-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </summary>
                                            <div class="px-8 pb-8 pt-2">
                                                <div class="text-[#5D4037] leading-relaxed">
                                                    {!! nl2br(e($question->answer)) !!}
                                                </div>
                                            </div>
                                        </details>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-8 py-8 text-center text-[#8C7B70] italic font-serif">
                                    Nog geen vragen in deze categorie.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-[#F5F0EB] p-16 text-center border border-[#EAE5DE] rounded-lg">
                    <p class="text-[#3E2C22] text-xl font-serif mb-6">Er zijn nog geen FAQ's beschikbaar.</p>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a
                                href="{{ route('faq.admin.categories.create') }}"
                                class="inline-block bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest px-8 py-3 rounded-full transition duration-300"
                            >
                                Maak eerste categorie
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
