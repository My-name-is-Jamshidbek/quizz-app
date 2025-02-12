<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <x-banner />

    <div class="min-h-screen bg-gray-100">
        <header class="flex items-center justify-end py-3 px-6 border-b border-gray-100">
            @include('layouts.partials.header-right-guest') 
        </header>

        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </div>

        @livewireScripts

        
    </body>

    @include('layouts.partials.footer')

</html>
