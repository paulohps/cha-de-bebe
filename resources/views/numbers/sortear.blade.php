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
        <section class="w-11/12 max-w-[1500px] mx-auto h-full">
            @if($winner)
                <header class="mb-4 text-center">
                    <img class="max-w-full w-96 mx-auto" src="{{ asset('images/brand.png') }}" alt="Chá de fraldas">
                    <div class="flex items-center mb-3">
                        <hr class="flex-1">
                        <h1 class="font-bold text-2xl uppercase mx-2">O vencedor é</h1>
                        <hr class="flex-1">
                    </div>
                </header>
                <div class="flex flex-col justify-center items-center">
                    <p class="text-6xl font-bold">{{ $winner->value }} - {{ $winner->name }}</p>

                    <div class="text-center mt-20">
                        <a class="px-12 py-4 font-bolder mt-4 text-center uppercase bg-yellow-400 w-full rounded hover:bg-yellow-500 transition" href="{{ route('numbers.sortear') }}">Sortear outro</a>
                    </div>
                </div>
            @else
                <header class="mb-4 text-center">
                    <img class="max-w-full w-96 mx-auto" src="{{ asset('images/brand.png') }}" alt="Chá de fraldas">
                    <div class="flex items-center mb-3">
                        <hr class="flex-1">
                        <h1 class="font-bold text-2xl uppercase mx-2">Participantes confirmados</h1>
                        <hr class="flex-1">
                    </div>
                </header>

                <div class="flex flex-wrap items-center">
                    @foreach($numbers as $number)
                        <div class="w-1/12 text-center my-2">
                            <p class="font-bold text-5xl">{{ $number->value }}</p>
                            {{ Str::of($number->name)->before(' ') }}
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a class="px-12 py-4 font-bolder mt-4 text-center uppercase bg-yellow-400 w-full rounded hover:bg-yellow-500 transition" href="{{ route('numbers.sortear', ['sortear' => true]) }}">Sortear</a>
                </div>
            @endif
        </section>
    </main>

    <footer class="absolute bottom-0 w-full py-3">
        <p class="text-center text-sm">Desenvolvido com <span class="text-red-500">♥</span> por <a target="_blank" class="font-bold" href="//wa.me/5567998301453">Paulo Scheuermann</a>.</p>
    </footer>
    @livewire('notifications')
</body>
</html>
