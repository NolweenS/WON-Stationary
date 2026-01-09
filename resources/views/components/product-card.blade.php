@props(['product'])

<div class="bg-white rounded-lg border border-border overflow-hidden hover:shadow-lg hover:border-softpink transition duration-300 group h-full flex flex-col relative">
    <div class="relative h-64 overflow-hidden bg-beige">
        @if($product->image)
            <img src="{{ $product->imageUrl() }}"
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
            {{ $product->name }}
        </h3>
        <div class="mt-auto flex items-center justify-between border-t border-beige pt-3">
            <span class="text-primary font-semibold">€ {{ number_format($product->price, 2, ',', '.') }}</span>
            <a href="{{ route('products.show', $product) }}" class="text-xs text-secondary hover:text-primary transition">
                Bekijk &rarr;
            </a>
        </div>
    </div>

    @auth
        @if(auth()->user()->is_admin)
            <div class="absolute top-2 left-2 flex space-x-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="bg-white/80 hover:bg-white text-primary p-1.5 rounded-full shadow-sm transition" title="Bewerken">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-white/80 hover:bg-white text-red-600 p-1.5 rounded-full shadow-sm transition" title="Verwijderen">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </form>
            </div>
        @endif
    @endauth
</div>
