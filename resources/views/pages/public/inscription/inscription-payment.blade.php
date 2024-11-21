<div class="kr-embedded" kr-popin kr-form-token="''">
</div>
@extends('layouts.public.landing')
@push('title', 'Inscripcion a programa')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        #btn-add-hour:hover, #guardarRegistro:hover {
            background: #27326F !important;
            color: #FFF000 !important;
        }
    </style>
@endpush
@push('paidhead')
    <script type="text/javascript"
            src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
            kr-public-key="{{config('services.izipay.public_key')}}" kr-post-url-success="{{route('paid.izipay')}}">
    </script>

    <link rel="stylesheet"
          href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script
            src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js">
    </script>
@endpush
@section('content')
    @include('components.public.header',['sedes'=>"/ciar/#sedes"])
    <section class="banner esInterna position-relative">
        <div class="container padding position-relative">
            <div class="row justify-content-center justify-content-md-start position-relative">
                <div class="col-11 col-md-12 col-xl-12 text-center">
                    <div class="padding2"></div>
                    <h2 class="titulo altas fw-bold mb-3 mb-lg-4">Inscribete al programa</h2>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="idPrograma" value="">
    <input type="hidden" id="namePrograma" value="">
    <input type="hidden" id="idMiembro" value="">
    <input type="hidden" id="inscripcionPublica" value="1">
    <section class="programas-tipo padding interna">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-md-10 text-start ps-5">
                    <h3 class="mainColor fw-bold altas">Detalle de tu inscripción:</h3>

                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-sm-12 col-md-12 col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="kr-embedded" kr-form-token="{{$formToken}}">
                        <div class="kr-pan"></div>
                        <div class="kr-expiry"></div>
                        <div class="kr-security-code"></div>
                        <button class="kr-payment-button"></button>
                        <div class="kr-form-error"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.public.footer')
    @include('components.public.fixed')
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //Se ejecuta apartir de la respuesta del servidor
        /*$("#guardarRegistro").on("click", function () {
            const inscripcionPublica = $("#inscripcionPublica").val();
            const idservicio = $("#idPrograma").val();
            const idmiembro = $("#idMiembro").val();
            let fechasDefinidas = [];

            // Rellenar tabla de turnos y horarios
            $("#tableComponent").find("tbody tr").each(function (idx, row) {
                var JsonData = {};
                JsonData.dias = $("td:eq(0)", row).text();
                JsonData.horarios = $("td:eq(1)", row).text();
                fechasDefinidas.push(JsonData);
            });

            Swal.fire({
                icon: 'info',
                html: "Espere un momento porfavor ...",
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                method: 'POST',
                url: "{{route('inscripciones.store')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    idservicio,
                    idmiembro,
                    fechasDefinidas,
                    inscripcionPublica
                },
                success: function (resp) {
                    let data = resp;
                    if (data.success == 'ok') {
                        Swal.fire({
                            title: "Inscripción exitosa",
                            position: "center",
                            icon: "success",
                            allowOutsideClick: false,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: `<span style="color:#27326F">Entendido</span>`,
                            confirmButtonColor: "#FFF000",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload()
                            }
                        });
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            });

        });*/



    </script>
@endpush
