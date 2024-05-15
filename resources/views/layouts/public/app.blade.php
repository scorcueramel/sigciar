<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@stack('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('assets/css/global/fonts.css')}}">

    {{-- Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/all.min.css') }}">

    {{-- Personalized styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/global/style.css') }}">

    @stack('css')

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main>
            @yield('content')
        </main>

        <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/fontawesome/all.min.js') }}"></script>

        {{-- Personalized JS --}}
        @stack('js')
    </div>
</body>

</html>
