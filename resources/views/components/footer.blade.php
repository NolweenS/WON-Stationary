<footer class="bg-white border-t border-border mt-auto">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:justify-between">
            <div class="mb-8 md:mb-0">
                <span class="font-serif text-2xl tracking-wider text-primary font-bold">{{ config('app.name') }}</span>
                <p class="mt-2 text-sm text-secondary font-sans">Natuurlijke elegantie & tijdloze stijl.</p>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-4 text-xs font-bold text-primary uppercase tracking-widest">Shop</h2>
                    <ul class="text-secondary text-sm space-y-2">
                        <li><a href="{{ route('products.index') }}" class="hover:text-primary transition">Alle producten</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-primary transition">Winkelwagen</a></li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-4 text-xs font-bold text-primary uppercase tracking-widest">Service</h2>
                    <ul class="text-secondary text-sm space-y-2">
                        <li><a href="{{ route('contact.show') }}" class="hover:text-primary transition">Contact</a></li>
                        <li><a href="{{ route('faq.index') }}" class="hover:text-primary transition">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t border-border pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-xs text-secondary">&copy; {{ date('Y') }} {{ config('app.name') }}. Alle rechten voorbehouden.</p>
        </div>
    </div>
</footer>
