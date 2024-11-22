@extends('layouts.public.public')
@push('title', 'Reservas')

@push('css')
    <style>
        .select2-selection {
            border: 1px solid gray !important;
        }

        #conluz {
            font-size: 25px;
        }

        table > tbody > tr {
            background-color: #fff !important;
        }
    </style>
@endpush
@section('content')
    @include('components.public.navbar',['profile'=>true])
    <div class="container-fluid">
        <input type="hidden" id="loginCheck" value="{{ Auth::check() }}">
        <div class="row d-flex justify-content-center bg-secondary py-4">
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-12 text-center">
                        <h1 class="title_rse text-white">Reserva tu Cancha</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-4 pb-3 d-flex justify-content-center">
            @if(Session::has('warning'))
                <div class="col-md-10">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Lo sentimos!</strong> {{Session::get('warning')}}.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div class="col-11 col-md-8">
                <div class="alert d-flex justify-content-center" role="alert">
                <span class="descripcion" style="font-size: 20px; color:#FFF000">
                    Recuerda primero seleccionar la sede y la cancha de tu preferencia para continuar con tu reserva.
                </span>
                </div>
            </div>
            <div class="col-11 col-md-8 options">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <label for="sede" class="descripcion">
                            <i class="fa-regular fa-circle-right"></i>
                            Seleccione la Sede:
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            {{-- <label class="input-group-text border-secondary shadow-sm" for="sede">
                                <i class="fa-solid fa-buildings"></i>
                            </label> --}}
                            <select class="form-select border-secondary shadow-sm" id="sede">
                                <option value="" selected disabled>Seleccinar Sede</option>
                                @foreach ($sede as $s)
                                    <option value="{{ $s->id }}">{{ $s->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="lugar" class="descripcion"><i class="fa-regular fa-circle-right"></i>
                            Seleccione la Cancha:
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            {{-- <label class="input-group-text border-secondary shadow-sm" for="lugar"><i class="fa-solid fa-court-sport"></i></label> --}}
                            <select class="form-select border-secondary shadow-sm" id="lugar">
                                <option value="" select disabled>Seleccinar Cancha</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="lugar" class="descripcion">
                            <i class="fa-regular fa-circle-right"></i> Con Luz:
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="form-check form-switch ms-4">
                                <input class="form-check-input" type="checkbox" role="switch" id="conluz" name="conluz">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-end">
                        <small style="color:#fff;font-weight: bold;">
                            <i class="fa-duotone fa-circle" style="color: yellow"></i>
                            Disponible
                        </small>
                    </div>
                    <div class="col-4 text-center">
                        <small style="color:#fff;font-weight: bold;">
                            <i class="fa-duotone fa-circle" style="color: tomato"></i>
                            Ocupado
                        </small>
                    </div>
                    <div class="col-4">
                        <small style="color:#fff;font-weight: bold;">
                            <i class="fa-duotone fa-circle" style="color: cyan"></i>
                            Seleccionado
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-4 d-flex justify-content-center">
            <div class="col-11 col-md-8 calendar">
                <div id='reservation'></div>
            </div>
        </div>
    </div>
    @include('components.public.modal-detalle')
@endsection
@push('js')
    <script type="text/javascript" src="{{config('services.niubiz.url_js')}}"></script>

    <script>
        var purchaseNumber = Math.floor(Math.random() * 1000000000) + 1;

        function cleanInpust() {
            $("#modal").modal('hide');
        }

        $('#sede').change(() => {
            $('#lugar').removeAttr("disabled");
        });

        $('#closeUp').click(() => {
            cleanInpust();
            $('#modal').modal('hide');
        });

        $('#closeUpPago').click(() => {
            $('#modal_pago').modal('hide');
        });

        $(document).ready(function () {
            $('#sede option:first').prop('selected', true).trigger("change");
            $('#lugar option:first').prop('selected', true).trigger("change");
        });

        $("#continuarReserva").on('click', function () {
            $(this).addClass('d-none');
            $("#boton-carga").removeClass('d-none')
        });

        $("#continuarReservaNiubiz").on('click', function () {
            $(this).addClass('d-none');
            $("#boton-carga").removeClass('d-none');
        });

        function openForm(tokenSession, precioModal, codigo) {
            VisanetCheckout.configure({
                sessiontoken: `${tokenSession}`,
                channel: 'web',
                merchantid: "{{config('services.niubiz.merchant_id')}}",
                purchasenumber: purchaseNumber,
                amount: parseInt(precioModal),
                expirationminutes: '20',
                timeouturl: "{{route('reservation')}}",
                merchantlogo: "{{asset('assets/images/ciar-logo-azul.png')}}",
                formbuttoncolor: '#27326F',
                action: "{{route('attempt.client.pay')}}" + '?purchaseNumber=' + purchaseNumber + "&amount=" + parseInt(precioModal) + "&codigo=" + codigo, //url de intento de pago
                complete: function (params) {
                    alert(JSON.stringify(params));
                }
            });

            VisanetCheckout.open();
        }

        // pruebas para pagos con niubiz
        $('#continuarReservaNiubiz').on('click', function () {
            let precioModal = $("#percioModal").val();
            let codigo = $('#codigo').val();
            let personaid = $('#personaid').val();
            let inicio = $('#inicio').val();
            let fin = $('#fin').val();
            let sedeModal = $('#sedeModal').val();
            let lugarModal = $('#lugarModal').val();

            let data = {precioModal, codigo, personaid, inicio, fin, sedeModal, lugarModal}

            $.ajax({
                method: 'POST',
                url: "{{route('genera.token.niubiz')}}",
                data: {data},
                success: function (resp) {
                    openForm(resp.tokenSession, data.precioModal, resp.codigo);
                    setTimeout(() => {
                        $("#continuarReservaNiubiz").removeClass('d-none');
                        $("#continuarReservaNiubiz").attr('disabled', 'disabled');
                        $("#boton-carga").addClass('d-none');
                    }, 6000);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        })
    </script>
@endpush
