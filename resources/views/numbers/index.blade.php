<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>{{ config('app.name') }}</title>

    @vite('resources/assets/css/app.css')
</head>
<body class="bg-gradient-to-r to-blue-200 from-blue-300 min-h-scree w-full">
    <section class="flex flex-col justify-center items-center py-24 space-y-8">
        <header>
            <h1></h1>
            <img class="max-w-full w-96" src="{{ asset('images/brand.png') }}" alt="Chá de fraldas">
        </header>

        <div class="w-10/12 grid grid-cols-3 md:grid-cols-6 lg:grid-cols-8 place-items-center gap-6">
            @foreach(\App\Models\Number::all() as $number)
                <div class="relative {{ $number->itHasAnOwner() ? 'opacity-50' : '' }}">
                    <p class="absolute w-full h-full text-2xl flex justify-center items-center">
                        {{ $number->value }}
                    </p>
                    @if($number->itHasAnOwner())
                        <div class="absolute w-full h-full flex justify-center items-center text-red-500 text-6xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-full h-full" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
                        </div>
                    @endif
                    <img src="{{ asset('images/cloud.png') }}" alt="Chá de fraldas">
                </div>
            @endforeach
        </div>
    </section>
</body>
</html>
