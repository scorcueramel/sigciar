<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@stack('title') | {{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('assets/css/global/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('assets/auth/fonts/iconmoon/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/auth/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/auth/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/auth/css/style.css')}}">
</head>

<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
    <script src="{{asset('assets/auth/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/auth/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/auth/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/auth/js/main.js')}}"></script>
</body>

</html>
