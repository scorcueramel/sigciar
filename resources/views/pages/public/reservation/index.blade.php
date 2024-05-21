@extends('layouts.app')
@push('title', 'Reservas')

@section('content')
@include('components.navbar')
<div class="container-fluid">
     <input type="hidden" id="loginCheck" value="{{ Auth::check() }}">
    <div class="row bg-secondary py-4">
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-12 text-center">
                    <h1 class="title_rse text-white">Reserva de Espacios</h1>
                    {{-- <h1 class="title_rse text-white">Calendario de Visitas</h1> --}}
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
                        Sleccionado
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-4 pb-3 d-flex justify-content-center">
        <div class="col-md-10 options">
            <div class="row pb-4 align-items-center">
                <div class="col-md-6">
                    <label for="sede" class="descripcion">
                        <i class="fa-regular fa-circle-right"></i>
                        Seleccione la Sede:
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-2">
                        <label class="input-group-text border-secondary shadow-sm" for="sede"><i class="fa-solid fa-buildings"></i></label>
                        <select class="form-select border-secondary shadow-sm" id="sede" onfocus="this.blur()">
                            <option value="0" selected disabled>Seleccionar sede</option>
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
                        <label class="input-group-text border-secondary shadow-sm" for="lugar"><i class="fa-solid fa-court-sport"></i></label>
                        <select class="form-select border-secondary shadow-sm" id="lugar" onfocus="this.blur()" disabled>
                            <option selected disabled>Seleccionar cancha</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-4 d-flex justify-content-center">
        <div class="col-md-10 calendar">
            <div id='reservation'></div>
        </div>
    </div>
</div>
@include('components.modal')
@include('components.modal-pago')
@endsection
@push('js')
<script>
    function cleanInpust() {
        $("#modal").modal('hide');
        $('#sede option:first').prop('selected', true).trigger("change");
        $('#lugar option:first').prop('selected', true).trigger("change");
        $('#lugar').attr('disabled','disabled');
    }

    $('#sede').change(() => {
        $('#lugar').removeAttr("disabled");
    });

    $('#btnReservar').click(() => {
        let precio = $('#percioModal').val()
        $('#modal_pago').modal('show');
        $('#modal').modal('hide');
        $('#btnPagar').val(`S/. ${precio}.00`);
    });

    $('#closeUp').click(() => {
        cleanInpust();
    });

    $('#closeUpPago').click(() => {
        $('#modal_pago').modal('hide');
    });
</script>
@endpush
