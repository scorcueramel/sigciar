<!doctype html>
<html
lang="{{ str_replace('_', '-', app()->getLocale()) }}"
class="light-style layout-menu-fixed"
dir="ltr"
data-theme="theme-default"
data-assets-path="../assets/"
data-template="vertical-menu-template-free"
>

<head>
    <meta charset="utf-8">
    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@stack('title') | {{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    {{-- Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/template/fonts/boxicons.css') }}">
    {{-- template styles --}}
    <link rel="stylesheet" href="{{ asset('assets/template/css/core.css') }}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ asset('assets/template/css/theme-default.css')}}" class="template-customizer-theme-css" >
    <link rel="stylesheet" href="{{ asset('assets/template/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/css/apex-charts.css') }}">

    {{-- FullCalendar --}}
    <link rel="stylesheet" href="{{asset('assets/css/fullcalendar/main.min.css')}}" >
    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2-bootstrap-5-theme.min.css') }}">

    @stack('css')

    <script src="{{asset('assets/template/js/helpers.js')}}"></script>
    <script src="{{asset('assets/template/js/config.js')}}"></script>
</head>

<body>
    <div id="app">
        <main>
            @yield('content')
        </main>

        {{-- Template scripts --}}
        <script src="{{ asset('assets/template/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/template/js/popper.js') }}"></script>
        <script src="{{ asset('assets/template/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/template/js/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets/template/js/menu.js') }}"></script>
        <script src="{{ asset('assets/template/js/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/template/js/main.js') }}"></script>
        <script src="{{ asset('assets/template/js/dashboards-analytics.js') }}"></script>

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
        @stack('js')

    </div>
</body>

</html>
