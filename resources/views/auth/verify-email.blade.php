<x-guest-layout>
    <div class="min-h-[60vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-stone-50">

        <div class="sm:mx-auto sm:w-full sm:max-w-md mb-8">
            <h2 class="text-center text-3xl font-serif text-neutral-900 tracking-tight">
                E-mail verifiëren
            </h2>
            <p class="mt-2 text-center text-sm text-neutral-500 font-light px-4">
                Bedankt voor het registreren! Klik op de link in de e-mail die we net hebben gestuurd om je account te activeren. Niets ontvangen? We sturen je graag een nieuwe.
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-sm border border-stone-100 rounded-2xl sm:px-10">

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-lg text-sm text-center font-light">
                        {{ __('Er is een nieuwe verificatielink gestuurd naar het e-mailadres dat je hebt opgegeven.') }}
                    </div>
                @endif

                <div class="space-y-6">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <button type="submit" class="w-full bg-neutral-900 hover:bg-neutral-700 text-white text-xs uppercase tracking-widest font-medium px-6 py-3 rounded-full transition duration-300 shadow-md">
                                {{ __('Verificatie e-mail opnieuw sturen') }}
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf

                        <button type="submit" class="text-sm text-neutral-500 hover:text-neutral-900 underline underline-offset-4 transition font-light">
                            {{ __('Uitloggen') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
