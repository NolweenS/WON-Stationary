<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-[#FDFBF7] py-4">
            <h2 class="font-serif text-3xl text-[#3E2C22] leading-tight tracking-wide">
                Categorieën Beheren
            </h2>
            <div class="flex space-x-3">
                <a
                    href="{{ route('faq.index') }}"
                    class="bg-[#F5F0EB] hover:bg-[#EAE5DE] text-[#3E2C22] text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold border border-[#EAE5DE]"
                >
                    ← Terug naar FAQ
                </a>
                <a
                    href="{{ route('faq.admin.categories.create') }}"
                    class="bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold"
                >
                    + Nieuwe Categorie
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-8 bg-[#EAE5DE] border-l-2 border-[#3E2C22] text-[#3E2C22] px-6 py-4 rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="mb-8 bg-red-50 border-l-2 border-red-800 text-red-800 px-6 py-4 rounded-r-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white border border-[#EAE5DE] shadow-sm rounded-lg overflow-hidden">
                @if($categories->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#EAE5DE]">
                            <thead class="bg-[#F5F0EB]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#3E2C22] uppercase tracking-widest">
                                    Naam
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#3E2C22] uppercase tracking-widest">
                                    Slug
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#3E2C22] uppercase tracking-widest">
                                    Aantal vragen
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#3E2C22] uppercase tracking-widest">
                                    Volgorde
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-[#3E2C22] uppercase tracking-widest">
                                    Acties
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-[#EAE5DE]">
                            @foreach($categories as $category)
                                <tr class="hover:bg-[#FDFBF7] transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-[#3E2C22]">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8C7B70]">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#5D4037]">
                                        {{ $category->questions_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8C7B70]">
                                        {{ $category->order }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-4">
                                            <a
                                                href="{{ route('faq.admin.categories.edit', $category) }}"
                                                class="text-[#8C7B70] hover:text-[#3E2C22] font-serif italic transition duration-300"
                                            >
                                                Bewerken
                                            </a>
                                            <form
                                                action="{{ route('faq.admin.categories.destroy', $category) }}"
                                                method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Weet je zeker dat je deze categorie wilt verwijderen?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="text-[#8C7B70] hover:text-red-900 font-serif italic transition duration-300"
                                                >
                                                    Verwijderen
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-16 text-center">
                        <p class="text-[#3E2C22] text-xl font-serif mb-6">Er zijn nog geen categorieën aangemaakt.</p>
                        <a
                            href="{{ route('faq.admin.categories.create') }}"
                            class="inline-block bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest px-8 py-3 rounded-full transition duration-300"
                        >
                            Maak de eerste categorie
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
