<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-primary bg-nude">
<div class="min-h-screen flex flex-col">

    {{-- Navigatie voor ingelogde gebruikers --}}
    <x-authenticated-navigation />

    @isset($header)
        <header class="bg-nude border-b border-border">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="font-serif text-2xl text-primary">
                    {{ $header }}
                </div>
            </div>
        </header>
    @endisset

    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- Footer toevoegen --}}
    <x-footer />
</div>
</body>
</html>
