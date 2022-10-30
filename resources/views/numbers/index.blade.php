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
<body class="antialiased bg-gradient-to-r to-blue-200 from-blue-300 min-h-scree w-full">
    <section class="flex flex-col justify-center items-center py-24 space-y-8">
        <header>
            <h1></h1>
            <img class="max-w-full w-96" src="{{ asset('images/brand.png') }}" alt="Chá de fraldas">
        </header>

        <div class="w-10/12 grid grid-cols-3 md:grid-cols-6 lg:grid-cols-8 place-items-center gap-6">
            @foreach(\App\Models\Number::all() as $number)
                <livewire:numbers.select-item :number="$number"/>
            @endforeach
        </div>
    </section>

    @livewire('notifications')
</body>
</html>
