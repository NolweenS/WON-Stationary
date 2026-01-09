<x-guest-layout>
    <div class="min-h-[60vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-nude">

        <div class="sm:mx-auto sm:w-full sm:max-w-md mb-8">
            <h2 class="text-center text-3xl font-serif text-primary tracking-tight">
                Welkom terug
            </h2>
            <p class="mt-2 text-center text-sm text-secondary font-light">
                Log in op je account bij WON-Stationary
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-sm border border-border rounded-2xl sm:px-10">

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Emailadres')" class="text-primary font-medium" />
                        <x-text-input id="email"
                                      class="block mt-1 w-full border-border focus:border-primary focus:ring-primary rounded-lg bg-nude"
                                      type="email"
                                      name="email"
                                      :value="old('email')"
                                      required
                                      autofocus
                                      autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Wachtwoord')" class="text-primary font-medium" />
                        <x-text-input id="password"
                                      class="block mt-1 w-full border-border focus:border-primary focus:ring-primary rounded-lg bg-nude"
                                      type="password"
                                      name="password"
                                      required
                                      autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me"
                                   type="checkbox"
                                   class="rounded border-border text-primary shadow-sm focus:ring-primary bg-nude"
                                   name="remember">
                            <span class="ms-2 text-sm text-secondary font-light">{{ __('Onthoud mij') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-secondary hover:text-primary underline underline-offset-4 transition font-light"
                               href="{{ route('password.request') }}">
                                {{ __('Wachtwoord vergeten?') }}
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-primary hover:bg-[#2A1E17] text-white text-xs uppercase tracking-widest font-medium px-6 py-3 rounded-full transition duration-300 shadow-md">
                            {{ __('Inloggen') }}
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-border text-center">
                    <p class="text-sm text-secondary font-light">
                        Nog geen account?
                        <a href="{{ route('register') }}" class="font-medium text-primary hover:underline underline-offset-4">
                            Registreer hier
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
