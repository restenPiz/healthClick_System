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
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
         <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle icon="x-mark" />
            <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc." class="px-2 dark:hidden" />
            <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc." class="px-2 hidden dark:flex" />
            {{-- <flux:input as="button" variant="filled" placeholder="Search..." icon="magnifying-glass" /> --}}
            <flux:navlist variant="outline">
                <flux:navlist.item icon="home" href="#" current>Inicio</flux:navlist.item>
                <flux:navlist.item icon="puzzle-piece" href="#">Productos</flux:navlist.item>
                <flux:navlist.item icon="document-text" href="#">Vendas</flux:navlist.item>
                <flux:navlist.item icon="currency-dollar" href="#">Pagamentos</flux:navlist.item>
                <flux:navlist.group expandable heading="Favorites" class="hidden lg:grid">
                    <flux:navlist.item href="#">Marketing site</flux:navlist.item>
                    <flux:navlist.item href="#">Android app</flux:navlist.item>
                    <flux:navlist.item href="#">Brand guidelines</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>
            <flux:spacer />
            <flux:navlist variant="outline">
                <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
            </flux:navlist>
            <flux:dropdown position="top" align="start" class="max-lg:hidden">
                <flux:profile avatar="assets/dif.jpg" name="{{Auth::user()->name}}" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.radio checked>{{Auth::user()->name}}</flux:menu.radio>
                        {{-- <flux:menu.radio>Truly Delta</flux:menu.radio> --}}
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" alignt="start">
                <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.radio checked>{{Auth::user()->name}}</flux:menu.radio>
                        {{-- <flux:menu.radio>Truly Delta</flux:menu.radio> --}}
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:main>
            <flux:heading size="xl" level="1">Wecome, {{Auth::user()->name}}</flux:heading>
            <flux:text class="mb-6 mt-2 text-base">Here's what's new today</flux:text>
            <flux:separator variant="subtle" />
            {{$slot}}
        </flux:main>
        <!--Flux ui-->@livewireScripts
@fluxScripts
    </body>
</html>
