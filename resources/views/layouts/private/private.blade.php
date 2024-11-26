<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed" dir="ltr"
      data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@stack('title') | {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"/>
    {{-- Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/template/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/all.min.css') }}">
    {{-- template styles --}}
    <link rel="stylesheet" href="{{ asset('assets/template/css/core.css') }}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ asset('assets/template/css/theme-default.css')}}"
          class="template-customizer-theme-css">
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

    <link rel="stylesheet" href="{{asset('assets/template/css/datatables/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

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

@include('components.private.modal',['withTitle'=>true,'title'=>'DETALLE DE LA NOTIFICACIÓN','tamanio'=>'modal-sm'])

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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script src="{{asset('assets/js/chart-utils/chart.js')}}"></script>
<script src="{{asset('assets/js/chart-utils/chart-utils.min.js')}}"></script>
{{-- Personalized JS --}}
<script>
    $(document).ready(function () {
        $(function () {
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

    function mostatDetalleNotificacion(id) {
        $.ajax({
            method: 'GET',
            url: `/admin/detalle/${id}/notificacion`,
            success:function (response){
                let data = response[0];
                console.log(data)
                $("#modalcomponent").modal('show');
                $('#mcbody').html('');
                $('#mcbody').append(`
                <table class="table table-sm table-borderless table-hover">
                  <thead></thead>
                  <tbody>
                    <tr>
                      <td><strong>PROGRAMA</strong></td>
                      <td>${data.titulo}</td>
                    </tr>
                    <tr>
                      <td><strong>MIEMBRO</strong></td>
                      <td>${data.nombre_miembro}</td>
                    </tr>
                    <tr>
                      <td><strong>SEDE</strong></td>
                      <td>${data.sede}</td>
                    </tr>
                    <tr>
                      <td><strong>CANCHA</strong></td>
                      <td>${data.lugar}</td>
                    </tr>
                    <tr>
                      <td><strong>FECHA DE INICIO</strong></td>
                      <td>${formatDate(data.inicio.split(' ')[0])}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-danger" onclick="javascript:removerNotificacion('${data.notif_id}')"><i class="fa-solid fa-ban"></i></button>
                    </div>
                </div>
                `);

            },
            error:function (error){
                console.log(error)
            }
        });
    }

    function formatDate(date){
        let splitDate = date.split('-');
        return splitDate[2] + '/' + splitDate[1] + '/' +splitDate[0];
    }

    function removerNotificacion(id) {
        $("#modalcomponent").modal('hide');

        Swal.fire({
            title: "¿Quitar Notificación?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'GET',
                    url: `/admin/remover/${id}/notificacion`,
                    success:function (response){
                        Swal.fire({
                            title: "Notificación removida",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: 'Cerrar',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error:function (error){
                        console.log(error)
                    }
                });
            }
        });

    }

    function removerTodasLasNotificaciones() {
        alert("click on me");
        Swal.fire({
            title: "¿Quitar Notificaciones?",
            text: "Con esta opción vas a  quitar todas las notificaciones de tu bandeja",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'GET',
                    url: "/admin/remover/notificaciones",
                    success:function (response){
                        Swal.fire({
                            title: "Notificaciones removidas",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: 'Cerrar',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error:function (error){
                        console.log(error)
                    }
                });
            }
        });

    }

</script>


@stack('js')
</body>

</html>
