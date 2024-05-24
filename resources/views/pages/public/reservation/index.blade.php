@extends('layouts.public.layout_public')
@push('title', 'Reservas')
@push('css')
<style>
    .select2-selection {
        border: 1px solid gray !important;
    }
</style>
@endpush
@section('content')
@include('components.public.navbar')
<div class="container-fluid">
    <input type="hidden" id="loginCheck" value="{{ Auth::check() }}">
    <div class="row bg-secondary py-4">
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-12 text-center">
                    <h1 class="title_rse text-white">Reserva de Espacios</h1>
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
        @if(Session::has('warning'))
        <div class="col-md-10">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Upsss!</strong> {{Session::get('warning')}}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
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
                            <option value="" select disabled>Seleccinar Lugar</option>
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
@include('components.public.modal')
@include('components.public.modal-pago')
@endsection
@push('js')
<script>
    function cleanInpust() {
        $("#modal").modal('hide');
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
        $('#modal').modal('hide');
    });

    $('#closeUpPago').click(() => {
        $('#modal_pago').modal('hide');
    });

    $(document).ready(function() {
        $('#sede option:first').prop('selected', true).trigger("change");
        $('#lugar option:first').prop('selected', true).trigger("change");
    });
</script>
@endpush
