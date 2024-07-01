<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@stack('title') | {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    {{-- Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/template/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/all.min.css') }}">
    {{-- template styles --}}
    <link rel="stylesheet" href="{{ asset('assets/template/css/core.css') }}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ asset('assets/template/css/theme-default.css')}}" class="template-customizer-theme-css">
    <link rel="stylesheet" href="{{ asset('assets/template/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/css/apex-charts.css') }}">

    {{-- FullCalendar --}}
    <link rel="stylesheet" href="{{asset('assets/css/fullcalendar/main.min.css')}}">
    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/global/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/css/datatables/dataTables.bootstrap5.css')}}">

    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    @stack('css')

    <script src="{{asset('assets/template/js/helpers.js')}}"></script>
    <script src="{{asset('assets/template/js/config.js')}}"></script>
</head>

<body>
    <div id="app">
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('components.private.aside')
                <div class="layout-page">
                    @include('components.private.navbar')
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            @yield('content')
                        </div>
                    </div>
                    <!-- / Content -->
                    @include('components.private.footer')
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- @include('components.private.custom-button') -->

    {{-- Template scripts --}}
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/popper.js') }}"></script>
    <script src="{{ asset('assets/template/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/template/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/template/js/menu.js') }}"></script>
    <script src="{{ asset('assets/template/js/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/template/js/main.js') }}"></script>
    <script src="{{ asset('assets/template/js/dashboards-analytics.js') }}"></script>
    {{-- Full calendar --}}
    {{-- MomentJS (locale date) --}}
    <script src="{{asset('assets/js/fullcalendar/moment-with-locales.min.js')}}"></script>
    {{-- FullCalendar Free --}}
    <script src="{{asset('assets/js/fullcalendar/main.min.js')}}"></script>
    <script src="{{asset('assets/js/fullcalendar/locales-all.min.js')}}"></script>
    {{-- MomentJS (locale date) --}}
    <script src="{{asset('assets/js/fullcalendar/moment-with-locales.min.js')}}"></script>
    {{-- FullCalendar Free --}}
    <script src="{{asset('assets/js/fullcalendar/main.min.js')}}"></script>
    <script src="{{asset('assets/js/fullcalendar/locales-all.min.js')}}"></script>
    {{-- Sweetalert2 --}}
    <script src="{{ asset('assets/js/sweetalert/sweetalert2@11.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    {{-- Datatables --}}
    <script src="{{ asset('assets/template/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/datatables/dataTables.js') }}"></script>
    <script src="{{ asset('assets/template/js/datatables/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/template/js/datatables/dataTables.responsive.js') }}"></script>

    {{-- Personalized JS --}}
    <script>
        $(document).ready(function() {
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    @stack('js')
</body>

</html>
