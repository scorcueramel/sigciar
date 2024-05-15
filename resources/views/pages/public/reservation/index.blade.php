@extends('layouts.public.app')
@push('title','Reservas')
@push('css')
<style>
    .circulo {
        height: 27px;
        width: 10px !important;
        border: 1px solid #000;
        border-radius: 50%;
    }

    .title_rse {
        font-family: "Reddit Sans";
    }

    tr {
        height: 45px !important;
    }

    .fc-event-main-frame {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
    }
</style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="row bg-secondary py-5">
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-12 text-center">
                    <h1 class="title_rse text-white">Reservas de Espacios</h1>
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
    <div class="row py-4 d-flex justify-content-center">
        <div class="col-md-10">
            @include('components.toast')
            <div id='reservation'></div>
        </div>
    </div>
</div>
@include('components.modal')
@endsection
@push('js')
<script>
    function cleanInpust() {
        $("#modal").modal('hide');
        $("#inicio").val("");
        $("#fin").val("");
        $("#estado").val("");
        $("#capacidad").val("");
        $("#sede").val('0');
        $("#lugar").val('0');
        $("#lugar").attr("disabled", "disabled");
    }

    $("#btnClose").on('click', () => {
        cleanInpust();
    });

    $("#closeUp").on('click', () => {
        cleanInpust();
    });

    $('#sede').change(() => {
        $('#lugar').removeAttr("disabled");
        $('#estado').val("Activo");
    });

    $('#lugar').change(() => {
        let valor = $('#lugar').val();
        valor == 'CANCHA 1' ? $('#capacidad').val('20 Personas') : $('#capacidad').val('10 Personas');
    });
</script>
@endpush
