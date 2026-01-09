<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profiel bewerken
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Foutmeldingen --}}
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Let op!</strong>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="space-y-6"
                    >
                        @csrf
                        @method('PUT')

                        {{-- Huidige Foto --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Huidige profielfoto
                            </label>
                            <div class="flex items-center space-x-4">
                                @if($user->profile && $user->profile->profile_photo)
                                    <img
                                        src="{{ $user->profile->photoUrl() }}"
                                        alt="Current Photo"
                                        class="w-20 h-20 rounded-full object-cover border-2 border-gray-300"
                                    >
                                    <button type="submit" form="delete-photo-form" class="text-red-600 hover:text-red-800 text-sm font-semibold underline">
                                        Verwijder foto
                                    </button>
                                @else
                                    <img
                                        src="{{ $user->profile?->photoUrl() ?? 'https://ui-avatars.com/api/?background=f5ebe0&color=d5bdaf&name=' . urlencode($user->name) }}"
                                        alt="Default Avatar"
                                        class="w-20 h-20 rounded-full object-cover border-2 border-gray-300"
                                    >
                                    <span class="text-gray-500 text-sm italic">Standaard avatar</span>
                                @endif
                            </div>
                        </div>

                        {{-- Upload Nieuwe Foto --}}
                        <div>
                            <label for="profile_photo" class="block text-sm font-bold text-gray-700 mb-2">
                                Upload nieuwe profielfoto
                            </label>
                            <input
                                type="file"
                                name="profile_photo"
                                id="profile_photo"
                                accept="image/*"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2"
                            >
                        </div>

                        {{-- Gebruikersnaam --}}
                        <div>
                            <label for="username" class="block text-sm font-bold text-gray-700 mb-2">
                                Gebruikersnaam
                            </label>
                            <input
                                type="text"
                                name="username"
                                id="username"
                                value="{{ old('username', $user->profile->username ?? '') }}"
                                class="w-full rounded-md border border-gray-300 text-gray-900 bg-white p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                placeholder="Jouw gebruikersnaam"
                            >
                        </div>

                        {{-- Verjaardag --}}
                        <div>
                            <label for="birthday" class="block text-sm font-bold text-gray-700 mb-2">
                                Verjaardag
                            </label>
                            <input
                                type="date"
                                name="birthday"
                                id="birthday"
                                value="{{ old('birthday', $user->profile && $user->profile->birthday ? $user->profile->birthday->format('Y-m-d') : '') }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full rounded-md border border-gray-300 text-gray-900 bg-white p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            >
                        </div>

                        {{-- Over mij --}}
                        <div>
                            <label for="about_me" class="block text-sm font-bold text-gray-700 mb-2">
                                Over mij
                            </label>
                            <textarea
                                name="about_me"
                                id="about_me"
                                rows="4"
                                class="w-full rounded-md border border-gray-300 text-gray-900 bg-white p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                placeholder="Vertel iets over jezelf..."
                            >{{ old('about_me', $user->profile->about_me ?? '') }}</textarea>
                        </div>

                        {{-- Knoppen --}}
                        <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                style="background-color: #333; color: white; padding: 10px 20px; border-radius: 5px;"
                            >
                                Opslaan
                            </button>

                            <a
                                href="{{ route('profile.show', $user) }}"
                                class="text-gray-600 hover:text-gray-900 font-medium underline"
                            >
                                Annuleren
                            </a>
                        </div>
                    </form>

                    {{-- Apart formulier voor verwijderen foto om nesting te voorkomen --}}
                    <form id="delete-photo-form" action="{{ route('profile.photo.delete') }}" method="POST" onsubmit="return confirm('Weet je zeker dat je je profielfoto wilt verwijderen?')">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
