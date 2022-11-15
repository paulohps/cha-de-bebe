<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>{{ config('app.name') }}</title>

    <style>[x-cloak] {
        display: none !important;
    }</style>
    @vite(['resources/assets/css/app.css', 'resources/assets/js/app.js'])
    @livewireStyles
    @livewireScripts
</head>
<body class="relative antialiased bg-gradient-to-r to-blue-200 from-blue-300 min-h-scree w-full">
    <main class="pt-8 md:pt-12 pb-20">
        <section class="w-11/12 max-w-[1024px] mx-auto h-full">
            <header class="mb-4">
                <img class="max-w-full w-96 mx-auto" src="{{ asset('images/brand.png') }}" alt="Chá de fraldas">
            </header>

            <div class="flex flex-col justify-center items-center space-y-6">
                @foreach($numberGroups as $diaperName => $numbers)
                    <div>
                        <div class="flex items-center mb-3">
                            <hr class="flex-1">
                            <p class="text-xl md:text-2xl mx-4 text-left">{{ $diaperName }}</p>
                            <hr class="flex-1">
                        </div>

                        <div class="grid grid-cols-5 md:grid-cols-10 place-items-center gap-2 gap-y-3 md:gap-6">
                            @foreach($numbers as $number)
                                <livewire:numbers.select-item :number="$number"/>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="absolute bottom-0 w-full py-3">
        <p class="text-center text-sm">Desenvolvido com <span class="text-red-500">♥</span> por <a target="_blank" class="font-bold" href="//wa.me/5567998301453">Paulo Scheuermann</a>.</p>
    </footer>
    @livewire('notifications')
</body>
</html>
