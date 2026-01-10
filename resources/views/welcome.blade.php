<x-guest-layout>
    {{-- Hero Section --}}
    <div class="relative bg-beige overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-beige sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">

                {{-- Schuine witte achtergrondshape voor groot scherm --}}
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-beige transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-primary sm:text-5xl md:text-6xl font-serif">
                            <span class="block xl:inline">Tijdloze elegantie</span>
                            <span class="block text-secondary text-3xl sm:text-4xl mt-2 font-sans font-light">voor jouw dagelijks leven</span>
                        </h1>
                        <p class="mt-3 text-base text-secondary sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 font-light">
                            Ontdek onze zorgvuldig samengestelde collectie van stationery en lifestyle producten. Natuurlijke tinten, hoogwaardige materialen en een vleugje luxe voor op je bureau.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start gap-4">
                            <div class="rounded-md shadow">
                                <a href="{{ route('products.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-primary hover:bg-[#2A1E17] md:py-4 md:text-lg md:px-10 transition duration-300">
                                    Bekijk Collectie
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0">
                                <a href="{{ route('news.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-primary text-base font-medium rounded-full text-primary bg-transparent hover:bg-white md:py-4 md:text-lg md:px-10 transition duration-300">
                                    Lees ons verhaal
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        {{-- Hero Afbeelding (Rechts) --}}
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="{{asset('images/welcome.jpg')}}" alt="Stationery sfeerbeeld">
        </div>
    </div>

    {{-- Highlight Sectie: Onze Favorieten --}}
    <div class="bg-nude py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif text-primary font-bold">Onze Favorieten</h2>
                <p class="mt-2 text-secondary font-light">Speciaal voor jou geselecteerd.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Categorie 1: Notitieboeken --}}
                @php
                    $notebookCategory = \App\Models\Category::where('name', 'Notitieboeken')->first();
                @endphp
                <div class="bg-white p-8 rounded-lg border border-border text-center hover:shadow-lg transition duration-300 group cursor-pointer"
                     onclick="window.location='{{ $notebookCategory ? route('products.index', ['category' => $notebookCategory->id]) : route('products.index') }}'">
                    <div class="h-40 bg-beige mb-6 rounded-full w-40 mx-auto flex items-center justify-center text-secondary group-hover:scale-105 transition duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 opacity-60"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    </div>
                    <h3 class="font-serif text-xl text-primary font-semibold">Notitieboeken</h3>
                    <p class="text-secondary text-sm mt-2 font-light">Leg je gedachten vast in stijl.</p>
                    <span class="text-xs text-primary uppercase tracking-widest mt-4 inline-block border-b border-softpink pb-1 group-hover:border-primary transition">Bekijk alles</span>
                </div>

                {{-- Categorie 2: Pennen & Potloden --}}
                @php
                    $penCategory = \App\Models\Category::where('name', 'Pennen & Potloden')->first();
                @endphp
                <div class="bg-white p-8 rounded-lg border border-border text-center hover:shadow-lg transition duration-300 group cursor-pointer"
                     onclick="window.location='{{ $penCategory ? route('products.index', ['category' => $penCategory->id]) : route('products.index') }}'">
                    <div class="h-40 bg-beige mb-6 rounded-full w-40 mx-auto flex items-center justify-center text-secondary group-hover:scale-105 transition duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 opacity-60"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                    </div>
                    <h3 class="font-serif text-xl text-primary font-semibold">Pennen & Potloden</h3>
                    <p class="text-secondary text-sm mt-2 font-light">Schrijfcomfort ontmoet design.</p>
                    <span class="text-xs text-primary uppercase tracking-widest mt-4 inline-block border-b border-softpink pb-1 group-hover:border-primary transition">Bekijk alles</span>
                </div>

                {{-- Categorie 3: Accessoires --}}
                @php
                    $accessoiresCategory = \App\Models\Category::where('name', 'Accessoires')->first();
                @endphp
                <div class="bg-white p-8 rounded-lg border border-border text-center hover:shadow-lg transition duration-300 group cursor-pointer"
                     onclick="window.location='{{ $accessoiresCategory ? route('products.index', ['category' => $accessoiresCategory->id]) : route('products.index') }}'">
                    <div class="h-40 bg-beige mb-6 rounded-full w-40 mx-auto flex items-center justify-center text-secondary group-hover:scale-105 transition duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 opacity-60"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12" /></svg>
                    </div>
                    <h3 class="font-serif text-xl text-primary font-semibold">Accessoires</h3>
                    <p class="text-secondary text-sm mt-2 font-light">De finishing touch voor je bureau.</p>
                    <span class="text-xs text-primary uppercase tracking-widest mt-4 inline-block border-b border-softpink pb-1 group-hover:border-primary transition">Bekijk alles</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Nieuwsbrief --}}
    <div class="bg-white border-t border-border py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-serif text-primary mb-4">Blijf op de hoogte</h2>
            <p class="text-secondary font-light mb-8 max-w-2xl mx-auto">Schrijf je in voor onze nieuwsbrief en ontvang inspiratie, exclusieve aanbiedingen en updates over nieuwe collecties.</p>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg shadow-sm text-sm max-w-md mx-auto">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row justify-center gap-4 max-w-md mx-auto">
                @csrf
                <div class="w-full">
                    <input type="email" name="email" placeholder="Jouw e-mailadres" required class="w-full px-4 py-3 rounded-full border border-border bg-nude text-primary focus:ring-secondary focus:border-secondary transition">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 text-left ml-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-primary text-white rounded-full hover:bg-[#2A1E17] transition duration-300 font-medium whitespace-nowrap h-fit">Inschrijven</button>
            </form>
        </div>
    </div>
</x-guest-layout>
