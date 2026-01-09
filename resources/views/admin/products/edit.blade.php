<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl text-primary leading-tight">
            Product Bewerken: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-border">
                <div class="p-6 text-primary">

                    {{-- Foutmeldingen --}}
                    @if ($errors->any())
                        <x-alert type="error" message="Er is iets misgegaan. Controleer de invoervelden." class="mb-6" />
                    @endif

                    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Naam --}}
                        <div>
                            <x-input-label for="name" :value="__('Productnaam')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Categorie --}}
                        <div>
                            <x-input-label for="category_id" :value="__('Categorie')" />
                            <select name="category_id" id="category_id" required
                                    class="mt-1 block w-full rounded-md border-border bg-nude text-primary focus:border-primary focus:ring-primary shadow-sm sm:text-sm">
                                <option value="" disabled>Kies een categorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        {{-- Beschrijving --}}
                        <div>
                            <x-input-label for="description" :value="__('Beschrijving')" />
                            <textarea name="description" id="description" rows="4" required
                                      class="mt-1 block w-full rounded-md border-border bg-nude text-primary focus:border-primary focus:ring-primary shadow-sm sm:text-sm">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Prijs --}}
                            <div>
                                <x-input-label for="price" :value="__('Prijs (€)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" step="0.01" min="0" :value="old('price', $product->price)" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            {{-- Voorraad --}}
                            <div>
                                <x-input-label for="stock" :value="__('Voorraad')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" min="0" :value="old('stock', $product->stock)" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Huidige Afbeelding --}}
                        @if($product->image)
                            <div class="mb-4">
                                <x-input-label :value="__('Huidige afbeelding')" />
                                <div class="mt-2">
                                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded-md border border-border">
                                </div>
                            </div>
                        @endif

                        {{-- Nieuwe Afbeelding --}}
                        <div>
                            <x-input-label for="image" :value="__('Nieuwe afbeelding (Optioneel)')" />
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="mt-1 block w-full text-sm text-secondary file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-[#2A1E17] file:uppercase file:tracking-widest cursor-pointer">
                            <p class="mt-1 text-xs text-secondary">Laat leeg om huidige afbeelding te behouden.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Is Featured (Checkbox) --}}
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-border text-primary focus:ring-primary bg-nude">
                            <label for="is_featured" class="ml-2 block text-sm text-primary">
                                Dit is een uitgelicht product (Featured)
                            </label>
                        </div>

                        {{-- Knoppen --}}
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-border">
                            <a href="{{ route('admin.products.index') }}" class="text-xs uppercase tracking-widest text-secondary hover:text-primary transition font-bold">Annuleren</a>
                            <x-primary-button>
                                {{ __('Wijzigingen Opslaan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
