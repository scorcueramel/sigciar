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
    {{-- FullCalendar --}}
    <link rel="stylesheet" href="{{asset('assets/css/fullcalendar/main.min.css')}}" >
    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2-bootstrap-5-theme.min.css') }}">
    {{-- Personalized --}}
    <link rel="stylesheet" href="{{ asset('assets/css/personalized/style.css') }}">

    @stack('css')

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
        {{-- <!-- JQuery --> --}}
        <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
        <!-- <script src="{{ asset('assets/js/jquery/jquery.slim.min.js') }}"></script> -->
        {{-- Fontawesome Pro --}}
        <script src="{{ asset('assets/js/fontawesome/all.min.js') }}"></script>
        {{-- MomentJS (locale date) --}}
        <script src="{{asset('assets/js/fullcalendar/moment-with-locales.min.js')}}"></script>
        {{-- FullCalendar Free --}}
        <script src="{{asset('assets/js/fullcalendar/main.min.js')}}"></script>
        <script src="{{asset('assets/js/fullcalendar/locales-all.min.js')}}"></script>
        {{-- Sweetalert2 --}}
        <script src="{{ asset('assets/js/sweetalert/sweetalert2@11.js') }}"></script>
        {{-- Select2 --}}
        <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>

        {{-- Personalized JS --}}
        <script src="{{ asset('assets/js/personalized/reservation.js') }}" type="module"></script>
        @stack('js')
    </div>
</body>

</html>
