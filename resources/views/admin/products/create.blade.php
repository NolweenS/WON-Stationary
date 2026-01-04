<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nieuw Product Toevoegen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Foutmeldingen weergave (optioneel, voor debugging) --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Er is iets misgegaan!</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Naam --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Productnaam</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Categorie --}}
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Categorie</label>
                            <select name="category_id" id="category_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="" disabled selected>Kies een categorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Beschrijving --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving</label>
                            <textarea name="description" id="description" rows="4" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Prijs --}}
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Prijs (€)</label>
                                <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            {{-- Voorraad --}}
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Voorraad</label>
                                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Afbeelding --}}
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Afbeelding</label>
                            <input type="file" name="image" id="image" accept="image/*" required
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF tot 2MB.</p>
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Is Featured (Checkbox) --}}
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                Dit is een uitgelicht product (Featured)
                            </label>
                        </div>

                        {{-- Knoppen --}}
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Annuleren</a>
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Product Opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
