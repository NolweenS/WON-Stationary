<x-guest-layout>
    <div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-stone-50">

        <div class="sm:mx-auto sm:w-full sm:max-w-md mb-8">
            <h2 class="text-center text-3xl font-serif text-neutral-900 tracking-tight">
                Account aanmaken
            </h2>
            <p class="mt-2 text-center text-sm text-neutral-500 font-light">
                Word lid van de WON-Stationary community
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-sm border border-stone-100 rounded-2xl sm:px-10">

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Naam')" class="text-neutral-700 font-medium" />
                        <x-text-input id="name"
                                      class="block mt-1 w-full border-stone-200 focus:border-neutral-900 focus:ring-neutral-900 rounded-lg bg-stone-50/50"
                                      type="text"
                                      name="name"
                                      :value="old('name')"
                                      required
                                      autofocus
                                      autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Emailadres')" class="text-neutral-700 font-medium" />
                        <x-text-input id="email"
                                      class="block mt-1 w-full border-stone-200 focus:border-neutral-900 focus:ring-neutral-900 rounded-lg bg-stone-50/50"
                                      type="email"
                                      name="email"
                                      :value="old('email')"
                                      required
                                      autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Wachtwoord')" class="text-neutral-700 font-medium" />
                        <x-text-input id="password"
                                      class="block mt-1 w-full border-stone-200 focus:border-neutral-900 focus:ring-neutral-900 rounded-lg bg-stone-50/50"
                                      type="password"
                                      name="password"
                                      required
                                      autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Wachtwoord bevestigen')" class="text-neutral-700 font-medium" />
                        <x-text-input id="password_confirmation"
                                      class="block mt-1 w-full border-stone-200 focus:border-neutral-900 focus:ring-neutral-900 rounded-lg bg-stone-50/50"
                                      type="password"
                                      name="password_confirmation"
                                      required
                                      autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-neutral-900 hover:bg-neutral-700 text-white text-xs uppercase tracking-widest font-medium px-6 py-3 rounded-full transition duration-300 shadow-md">
                            {{ __('Registreren') }}
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-stone-100 text-center">
                    <p class="text-sm text-neutral-500 font-light">
                        Heb je al een account?
                        <a href="{{ route('login') }}" class="font-medium text-neutral-900 hover:underline underline-offset-4">
                            Log hier in
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
