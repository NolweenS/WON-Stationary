<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-[#FDFBF7] py-4">
            <h2 class="font-serif text-3xl text-[#3E2C22] leading-tight tracking-wide">
                Categorie Bewerken
            </h2>
            <a
                href="{{ route('faq.admin.categories.index') }}"
                class="text-[#8C7B70] hover:text-[#3E2C22] transition duration-300 text-xs uppercase tracking-widest font-medium"
            >
                ← Annuleren
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#EAE5DE] shadow-sm rounded-lg overflow-hidden">
                <div class="p-10 md:p-12">

                    @if($errors->any())
                        <div class="mb-8 bg-[#FDFBF7] border border-red-300 text-red-800 px-6 py-4 text-sm rounded-lg">
                            <p class="font-serif italic mb-2">Er zijn fouten gevonden:</p>
                            <ul class="list-disc list-inside text-xs uppercase tracking-wide">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('faq.admin.categories.update', $category) }}"
                        method="POST"
                        class="space-y-8"
                    >
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">
                                Naam <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $category->name) }}"
                                required
                                class="block w-full border-[#EAE5DE] text-[#3E2C22] focus:border-[#3E2C22] focus:ring-[#3E2C22] rounded-lg shadow-sm placeholder-[#8C7B70] py-3"
                            >
                        </div>

                        {{-- Order --}}
                        <div>
                            <label for="order" class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">
                                Volgorde
                            </label>
                            <input
                                type="number"
                                name="order"
                                id="order"
                                value="{{ old('order', $category->order) }}"
                                min="0"
                                class="block w-full border-[#EAE5DE] text-[#3E2C22] focus:border-[#3E2C22] focus:ring-[#3E2C22] rounded-lg shadow-sm placeholder-[#8C7B70] py-3"
                            >
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center justify-start space-x-6 pt-6 border-t border-[#EAE5DE]">
                            <button
                                type="submit"
                                class="bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest font-bold px-10 py-4 rounded-full transition duration-300 ease-in-out"
                            >
                                Opslaan
                            </button>
                            <a
                                href="{{ route('faq.admin.categories.index') }}"
                                class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-widest transition duration-300"
                            >
                                Annuleren
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
