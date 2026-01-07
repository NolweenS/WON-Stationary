<x-guest-layout>
    <div class="min-h-[60vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-stone-50">

        <div class="sm:mx-auto sm:w-full sm:max-w-md mb-8">
            <h2 class="text-center text-3xl font-serif text-neutral-900 tracking-tight">
                Wachtwoord vergeten?
            </h2>
            <p class="mt-2 text-center text-sm text-neutral-500 font-light px-4">
                Geen probleem. Vul je emailadres in en we sturen je een link om een nieuw wachtwoord te kiezen.
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-sm border border-stone-100 rounded-2xl sm:px-10">

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Emailadres')" class="text-neutral-700 font-medium" />
                        <x-text-input id="email"
                                      class="block mt-1 w-full border-stone-200 focus:border-neutral-900 focus:ring-neutral-900 rounded-lg bg-stone-50/50"
                                      type="email"
                                      name="email"
                                      :value="old('email')"
                                      required
                                      autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-neutral-900 hover:bg-neutral-700 text-white text-xs uppercase tracking-widest font-medium px-6 py-3 rounded-full transition duration-300 shadow-md">
                            {{ __('Stuur herstellink') }}
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-stone-100 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-neutral-500 hover:text-neutral-900 underline underline-offset-4 transition font-light">
                        Terug naar inloggen
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
