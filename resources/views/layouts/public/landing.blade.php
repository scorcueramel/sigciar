<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@stack('title') | {{ config('app.name', 'Laravel') }}</title>

    {{-- <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/png" sizes="192x192"> --}}
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/png" sizes="192x192">

    <meta property="og:locale" content="es_ES" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="CIAR" />
    <meta property="og:description" content="Centro Internacional de Alto Rendimiento" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="CIAR" />

    <meta property="og:image" content="-1200x630.png" />
    <meta property="og:image:secure_url" content="-1200x630.png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="CIAR" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Centro Internacional de Alto Rendimiento" />
    <meta name="twitter:title" content="CIAR" />
    <meta name="twitter:image" content="-1200x630.png" />

    <meta property="og:image" content="-300x300.png" />
    <meta property="og:image:secure_url" content="-300x300.png" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />

    <link rel="stylesheet" href="{{asset('assets/landing/css/carlos.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/styles.css')}}">

    @stack('css')

</head>

<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
        {{-- <!-- JQuery --> --}}
        <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
        <script src="{{asset('assets/landing/libs/swiper/swiper-bundle.min.js')}}"></script>
        <script src="{{asset('assets/landing/libs/aos/aos.js')}}"></script>
        <script src="{{asset('assets/landing/js/main.js?v=205')}}"></script>
        @stack('js')
    </div>
</body>

</html>
