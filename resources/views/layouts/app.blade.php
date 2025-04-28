<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HealthClick - System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-o9N1jbd3L9x5H7bbP/H0tpUV1o6RzA2GDXbVmgePfXw=" crossorigin="" />

        {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-DMeha9a_.css') }}"> --}}

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body  
      class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
        
        @assets
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-o9N1jbd3L9x5H7bbP/H0tpUV1o6RzA2GDXbVmgePfXw=" crossorigin=""></script>

        <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU6gQ1_MjMZOE35nYQ6-ovXw4er01wiuQ&callback=initMap"></script>
    
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        
        @endassets
    
        <script>
            if (
                localStorage.theme === 'dark' ||
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        {{-- <script src="{{ asset('build/assets/app-BmE-7FdL.js') }}" defer></script>  --}}
    </body>
</html>
