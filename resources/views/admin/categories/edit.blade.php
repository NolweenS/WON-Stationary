<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categorie Bewerken: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Naam --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Categorienaam</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Beschrijving --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving (Optioneel)</label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $category->description) }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Huidige Afbeelding --}}
                        @if($category->image)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Huidige afbeelding</label>
                                <div class="mt-2">
                                    <img src="{{ $category->imageUrl() }}" alt="{{ $category->name }}" class="h-32 w-32 object-cover rounded-md border border-gray-300">
                                </div>
                            </div>
                        @endif

                        {{-- Nieuwe Afbeelding --}}
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Nieuwe afbeelding (Optioneel)</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-500 mt-1">Laat leeg om huidige afbeelding te behouden.</p>
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Knoppen --}}
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Annuleren</a>
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Wijzigingen Opslaan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
