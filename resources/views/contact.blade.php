<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-[#FDFBF7] py-4">
            <h2 class="font-serif text-3xl text-[#3E2C22] leading-tight tracking-wide">
                Contact
            </h2>
            <a href="{{ route('faq.index') }}" class="text-[#8C7B70] hover:text-[#3E2C22] text-xs uppercase tracking-widest font-medium">
                ← Terug naar FAQ
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 bg-[#EAE5DE] border-l-2 border-[#3E2C22] text-[#3E2C22] px-6 py-4 rounded-r-lg shadow-sm">
                    <p class="font-bold font-serif text-lg mb-1">Bericht verzonden!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white border border-[#EAE5DE] shadow-sm rounded-lg overflow-hidden p-10 md:p-12">
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">Naam *</label>
                            <input type="text" name="name" value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" required class="block w-full border-[#EAE5DE] text-[#3E2C22] rounded-lg shadow-sm py-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">E-mail *</label>
                            <input type="email" name="email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" required class="block w-full border-[#EAE5DE] text-[#3E2C22] rounded-lg shadow-sm py-3">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">Onderwerp *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required class="block w-full border-[#EAE5DE] text-[#3E2C22] rounded-lg shadow-sm py-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#3E2C22] uppercase tracking-widest mb-3">Bericht *</label>
                        <textarea name="message" rows="6" required class="block w-full border-[#EAE5DE] text-[#5D4037] rounded-lg shadow-sm leading-relaxed">{{ old('message') }}</textarea>
                    </div>
                    <div class="pt-4 border-t border-[#EAE5DE] text-right">
                        <button type="submit" class="bg-[#3E2C22] hover:bg-[#5D4037] text-[#F5F0EB] text-xs uppercase tracking-widest font-bold px-12 py-4 rounded-full transition duration-300 shadow-md">Verstuur bericht</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
