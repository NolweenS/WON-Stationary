@props(['product'])

<div class="bg-white rounded-lg border border-border overflow-hidden hover:shadow-lg hover:border-softpink transition duration-300 group h-full flex flex-col">
    <div class="relative h-64 overflow-hidden bg-beige">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-out">
        @else
            <div class="w-full h-full flex items-center justify-center text-secondary opacity-50">
                <span class="text-xs uppercase">Geen afbeelding</span>
            </div>
        @endif

        @if($product->stock <= 0)
            <span class="absolute top-2 right-2 bg-beige text-secondary text-xs font-bold px-2 py-1 rounded border border-border">Uitverkocht</span>
        @endif
    </div>

    <div class="p-5 flex-1 flex flex-col">
        <p class="text-xs text-secondary mb-1 uppercase tracking-wide">{{ $product->category->name ?? 'Algemeen' }}</p>
        <h3 class="font-serif text-lg text-primary mb-2">
            <a href="{{ route('products.show', $product) }}">
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{ $product->name }}
            </a>
        </h3>
        <div class="mt-auto flex items-center justify-between border-t border-beige pt-3">
            <span class="text-primary font-semibold">€ {{ number_format($product->price, 2, ',', '.') }}</span>
            <span class="text-xs text-secondary group-hover:text-primary transition">Bekijk &rarr;</span>
        </div>
    </div>
</div>
