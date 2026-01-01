<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#3E2723] leading-tight">
            Nieuwe Gebruiker Aanmaken
        </h2>
    </x-slot>

    {{-- Achtergrond 'Linnen' kleur voor consistentie --}}
    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-sm border border-[#EFEBE9]">

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                {{-- Naam --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Naam</label>
                    <input type="text" name="name"
                           class="w-full border-[#D7CCC8] rounded-md shadow-sm focus:border-[#8D6E63] focus:ring focus:ring-[#D7CCC8] focus:ring-opacity-50 text-[#3E2723]"
                           required>
                </div>

                {{-- Email --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Email</label>
                    <input type="email" name="email"
                           class="w-full border-[#D7CCC8] rounded-md shadow-sm focus:border-[#8D6E63] focus:ring focus:ring-[#D7CCC8] focus:ring-opacity-50 text-[#3E2723]"
                           required>
                </div>

                {{-- Wachtwoord --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Wachtwoord</label>
                    <input type="password" name="password"
                           class="w-full border-[#D7CCC8] rounded-md shadow-sm focus:border-[#8D6E63] focus:ring focus:ring-[#D7CCC8] focus:ring-opacity-50 text-[#3E2723]"
                           required>
                </div>

                {{-- Bevestig Wachtwoord --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-[#5D4037] mb-2">Bevestig Wachtwoord</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border-[#D7CCC8] rounded-md shadow-sm focus:border-[#8D6E63] focus:ring focus:ring-[#D7CCC8] focus:ring-opacity-50 text-[#3E2723]"
                           required>
                </div>

                {{-- Checkbox --}}
                <div class="mb-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        {{-- Checkbox kleur aangepast naar bruin --}}
                        <input type="checkbox" name="is_admin"
                               class="rounded border-[#D7CCC8] text-[#5D4037] shadow-sm focus:border-[#8D6E63] focus:ring focus:ring-[#D7CCC8] focus:ring-opacity-50">
                        <span class="text-sm text-[#5D4037]">Meteen Admin rechten geven?</span>
                    </label>
                </div>

                {{-- Actie Knoppen --}}
                <div class="flex justify-between items-center pt-2">
                    <a href="{{ route('admin.users.index') }}" class="text-[#8D6E63] hover:text-[#5D4037] text-sm hover:underline transition-colors">
                        Annuleren
                    </a>
                    <button type="submit" class="bg-[#5D4037] text-white font-semibold py-2 px-6 rounded-md hover:bg-[#3E2723] transition duration-150 shadow-sm">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
