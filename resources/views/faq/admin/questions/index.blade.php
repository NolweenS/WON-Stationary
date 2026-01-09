<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-[#FDFBF7] py-4">
            <h2 class="font-serif text-3xl text-[#3E2C22] leading-tight tracking-wide">
                FAQ Vragen Beheren
            </h2>
            <div class="flex space-x-3">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="bg-[#F5F0EB] hover:bg-[#EAE5DE] text-[#3E2C22] text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold border border-[#EAE5DE]"
                >
                    Dashboard
                </a>
                <a
                    href="{{ route('faq.index') }}"
                    class="bg-[#F5F0EB] hover:bg-[#EAE5DE] text-[#3E2C22] text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold border border-[#EAE5DE]"
                >
                    ← Terug naar FAQ
                </a>
                <a
                    href="{{ route('faq.admin.questions.create') }}"
                    class="bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest px-6 py-3 rounded-full transition duration-300 ease-in-out font-bold"
                >
                    + Nieuwe vraag
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <x-alert type="success" :message="session('success')" class="mb-8" />
            @endif

            <div class="bg-white border border-[#EAE5DE] shadow-sm rounded-lg overflow-hidden">
                @if($questions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#EAE5DE]">
                            <thead class="bg-[#F5F0EB]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#3E2C22] uppercase tracking-widest">
                                    Categorie
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#3E2C22] uppercase tracking-widest">
                                    Vraag
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
                            @foreach($questions as $question)
                                <tr class="hover:bg-[#FDFBF7] transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#5D4037]">
                                        {{ $question->category->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-[#3E2C22] font-medium">
                                        {{ $question->shortQuestion(60) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8C7B70]">
                                        {{ $question->order }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-3">
                                            <a href="{{ route('faq.admin.questions.edit', $question) }}" class="text-[#8C7B70] hover:text-[#3E2C22] transition" title="Bewerken">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                            <form
                                                action="{{ route('faq.admin.questions.destroy', $question) }}"
                                                method="POST"
                                                class="inline-flex"
                                                onsubmit="return confirm('Weet je zeker dat je deze vraag wilt verwijderen?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[#8C7B70] hover:text-red-700 transition" title="Verwijderen">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 bg-[#FDFBF7] border-t border-[#EAE5DE]">
                        {{ $questions->links() }}
                    </div>
                @else
                    <div class="p-16 text-center">
                        <p class="text-[#3E2C22] text-xl font-serif mb-6">Er zijn nog geen vragen aangemaakt.</p>
                        <a
                            href="{{ route('faq.admin.questions.create') }}"
                            class="inline-block bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest px-8 py-3 rounded-full transition duration-300"
                        >
                            Maak de eerste vraag
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
