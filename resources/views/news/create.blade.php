<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-[#FDFBF7] py-4">
            <h2 class="font-serif text-3xl text-[#3E2C22] leading-tight tracking-wide">
                Nieuw nieuwsartikel
            </h2>
            <a
                href="{{ route('news.index') }}"
                class="text-[#8C7B70] hover:text-[#3E2C22] transition duration-300 text-xs uppercase tracking-widest font-medium"
            >
                ← Annuleren
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                        action="{{ route('news.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="space-y-8"
                    >
                        @csrf

                        <div>
                            <label for="title" class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">
                                Titel <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title') }}"
                                required
                                class="block w-full border-[#EAE5DE] text-[#3E2C22] focus:border-[#3E2C22] focus:ring-[#3E2C22] rounded-lg shadow-sm placeholder-[#8C7B70] py-3"
                                placeholder="Vul een titel in"
                            >
                        </div>

                        <div>
                            <label for="content" class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">
                                Inhoud <span class="text-red-400">*</span>
                            </label>
                            <textarea
                                name="content"
                                id="content"
                                rows="12"
                                required
                                class="block w-full border-[#EAE5DE] text-[#5D4037] focus:border-[#3E2C22] focus:ring-[#3E2C22] rounded-lg shadow-sm placeholder-[#8C7B70] leading-relaxed"
                                placeholder="Schrijf hier het nieuwsartikel..."
                            >{{ old('content') }}</textarea>
                        </div>

                        <div>
                            <label for="image" class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">
                                Afbeelding <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="file"
                                name="image"
                                id="image"
                                accept="image/*"
                                required
                                class="block w-full text-xs text-[#8C7B70] uppercase tracking-widest
                                    file:mr-4 file:py-3 file:px-6
                                    file:border-0 file:rounded-full
                                    file:text-xs file:font-bold
                                    file:bg-[#F5F0EB] file:text-[#3E2C22]
                                    hover:file:bg-[#EAE5DE]
                                    cursor-pointer transition duration-300"
                            >
                            <p class="mt-2 text-xs text-[#8C7B70] italic">
                                JPG, PNG, GIF. Max 2MB.
                            </p>
                        </div>

                        <div>
                            <label for="published_at" class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">
                                Publicatiedatum
                            </label>
                            <input
                                type="datetime-local"
                                name="published_at"
                                id="published_at"
                                value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                                class="block w-full border-[#EAE5DE] text-[#3E2C22] focus:border-[#3E2C22] focus:ring-[#3E2C22] rounded-lg shadow-sm py-3"
                            >
                            <p class="mt-2 text-xs text-[#8C7B70] italic">
                                Laat leeg voor directe publicatie.
                            </p>
                        </div>

                        <div class="flex items-center justify-start space-x-6 pt-6 border-t border-[#EAE5DE]">
                            <button
                                type="submit"
                                class="bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest font-bold px-10 py-4 rounded-full transition duration-300 ease-in-out"
                            >
                                Publiceren
                            </button>
                            <a
                                href="{{ route('news.index') }}"
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
