<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('assets/template/css/core.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/css/theme-default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/css/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/css/')}}">
</head>
<body class="antialiased">

    @yield('content')

    <script src="{{asset('assets/js/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/template/js/popper.js')}}"></script>
    <script src="{{asset('assets/template/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/template/js/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/template/js/menu.js')}}"></script>
</body>
</html>
