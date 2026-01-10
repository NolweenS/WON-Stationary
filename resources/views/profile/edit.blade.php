<x-app-layout>
    <x-slot name="header">
        <h2 class="font-light text-xl text-neutral-800 leading-tight tracking-wide">
            {{ __('Profiel bewerken') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-stone-50">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-stone-100">
                <div class="p-8">

                    {{-- Foutmeldingen --}}
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                            <strong class="font-medium">Let op!</strong>
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
                            <label class="block text-sm font-medium text-neutral-700 mb-3">
                                Huidige profielfoto
                            </label>
                            <div class="flex items-center space-x-6">
                                @if($user->profile && $user->profile->profile_photo)
                                    <img
                                        src="{{ $user->profile->photoUrl() }}"
                                        alt="Current Photo"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-stone-50 shadow-sm"
                                    >
                                    <button type="submit" form="delete-photo-form" class="text-red-500 hover:text-red-700 text-xs font-medium uppercase tracking-widest underline underline-offset-4">
                                        Verwijder foto
                                    </button>
                                @else
                                    <img
                                        src="{{ $user->profile?->photoUrl() ?? 'https://ui-avatars.com/api/?background=f5ebe0&color=d5bdaf&name=' . urlencode($user->name) }}"
                                        alt="Default Avatar"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-stone-50 shadow-sm"
                                    >
                                    <span class="text-neutral-400 text-sm italic">Standaard avatar</span>
                                @endif
                            </div>
                        </div>

                        {{-- Upload Nieuwe Foto --}}
                        <div>
                            <label for="profile_photo" class="block text-sm font-medium text-neutral-700 mb-2">
                                Upload nieuwe profielfoto
                            </label>
                            <input
                                type="file"
                                name="profile_photo"
                                id="profile_photo"
                                accept="image/*"
                                class="block w-full text-sm text-neutral-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-xs file:font-medium file:uppercase file:tracking-widest
                                file:bg-stone-100 file:text-neutral-700
                                hover:file:bg-stone-200
                                cursor-pointer"
                            >
                        </div>

                        {{-- Gebruikersnaam --}}
                        <div>
                            <label for="username" class="block text-sm font-medium text-neutral-700 mb-2">
                                Gebruikersnaam
                            </label>
                            <input
                                type="text"
                                name="username"
                                id="username"
                                value="{{ old('username', $user->profile->username ?? '') }}"
                                class="w-full rounded-lg border-stone-200 bg-stone-50 focus:border-neutral-900 focus:ring-neutral-900 text-sm"
                                placeholder="Jouw gebruikersnaam"
                            >
                        </div>

                        {{-- Verjaardag --}}
                        <div>
                            <label for="birthday" class="block text-sm font-medium text-neutral-700 mb-2">
                                Verjaardag
                            </label>
                            <input
                                type="date"
                                name="birthday"
                                id="birthday"
                                value="{{ old('birthday', $user->profile && $user->profile->birthday ? $user->profile->birthday->format('Y-m-d') : '') }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full rounded-lg border-stone-200 bg-stone-50 focus:border-neutral-900 focus:ring-neutral-900 text-sm"
                            >
                        </div>

                        {{-- Over mij --}}
                        <div>
                            <label for="about_me" class="block text-sm font-medium text-neutral-700 mb-2">
                                Over mij
                            </label>
                            <textarea
                                name="about_me"
                                id="about_me"
                                rows="4"
                                class="w-full rounded-lg border-stone-200 bg-stone-50 focus:border-neutral-900 focus:ring-neutral-900 text-sm"
                                placeholder="Vertel iets over jezelf..."
                            >{{ old('about_me', $user->profile->about_me ?? '') }}</textarea>
                        </div>

                        {{-- Knoppen --}}
                        <div class="flex items-center space-x-4 pt-6 border-t border-stone-100">
                            <button
                                type="submit"
                                class="bg-neutral-900 hover:bg-neutral-700 text-white text-xs uppercase tracking-widest font-medium px-6 py-3 rounded-full transition duration-300 shadow-md"
                            >
                                Opslaan
                            </button>

                            <a
                                href="{{ route('profile.show', $user) }}"
                                class="text-neutral-500 hover:text-neutral-900 text-sm font-medium underline underline-offset-4"
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
