@extends('layouts.private.private', ['activePage' => 'tenis.index'])
@push('title', 'Tenis')
@push('css')
<style>
    tbody>tr>td {
        font-size: 14px !important;
    }

    thead>tr>td {
        font-size: 13px !important;
        font-weight: 700;
    }
</style>
@endpush
@section('content')
@include('components.private.messages-session')
<div class="row d-flex align-items-center">
    <div class="col-md">
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Tenis Actividades /</span> Todas </h4>
    </div>
    <div class="col-md text-end">
        <a href="{{ route('tenis.create',3) }}" class="btn btn-sm btn-info"><i class="fa-solid fa-tennis-ball me-1"></i>
            Nueva</a>
    </div>
</div>

<div class="row">
    <div class="card pt-2">
        <div class="card-body">
            <div class="row pb-3">
                <div class="col-md-auto d-flex align-items-center">
                    <a role="button" href="{{route('tenis.index')}}" class="text-decoration-none text-secondary">Programa</a>
                </div>
                <div class="col-md-auto">
                    <a role="button" href="#" class="btn btn-primary">Inscritos</a>
                </div>
            </div>
            <div class="row">
                <div id='tenis'></div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('components.private.modal', [
'tamanio'=>'modal-sm',
'withTitle' => true,
'title' => '',
'withButtons' => true,
'cancelbutton' => true,
'mcTextCancelButton' => 'Cerrar',
])
@push('js')
<script>
    $(document).ready(() => {
        var diasdisponibles = new Array();

        // Obtener datos para mostrar en la vista  calendario
        // Obtener la fecha actual para bloquear los días pasados.
        moment.locale('es'); //->colocar el idioma español.

        var calendarEl = document.getElementById('tenis');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            allDaySlot: false,
            contentHeight: 20,
            dayMaxEvents: 1,
            editable: false,
            eventOverlap: true,
            eventShortHeight: 'short',
            height: 500,
            initialView: 'timeGridWeek',
            locale: 'es-PE',
            selectable: true,
            timeZone: 'UTC',
            unselectAuto: true,
            headerToolbar: {
                left: 'today prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            events: "{{route('calendario.tenis')}}",
            eventClick: function(info) {
                var modal = $("#modalcomponent");
                var modaltitle = $("#mcLabel").html(`
                    <h5>DETALLE DE INSCRITO</h5>
                `);
                var modalbody = $("#mcbody");
                modalbody.html(`
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Programa</td>
                                <td>${info.event.extendedProps.programa}</td>
                            </tr>
                            <tr>
                                <td>Cancha</td>
                                <td>${info.event.extendedProps.cancha}</td>
                            </tr>
                            <tr>
                                <td>Sede</td>
                                <td>${info.event.extendedProps.sede}</td>
                            </tr>
                            <tr>
                                <td>Turno</td>
                                <td>${info.event.extendedProps.turno}</td>
                            </tr>
                            <tr>
                                <td>Horas</td>
                                <td>${info.event.extendedProps.horas} hrs.</td>
                            </tr>
                            <tr>
                                <td>Miembro</td>
                                <td>${info.event.title}</td>
                            </tr>
                            <tr>
                                <td>Envira Nota</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" id="mostrar" onclick="javascript:mostrarCampoNotas();">Nueva Nota</button>
                                    <button class="btn btn-sm btn-danger" id="ocultar" onclick="javascript:ocutarCampoNotas();" hidden>No Enviar</button>
                                </td>
                            </tr>
                            <tr class="notas d-none">
                                <td colspan="2">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Escribe la nota a enviar" id="nota-miembro" style="height: 100px"></textarea>
                                        <label for="notas-miembro">Nota</label>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-success w-100" type="button" onclick="javascript:enviarNota();">Enviar</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                `);
                modal.modal('show');
            }
        });
        calendar.render();
    });

    function enviarNota(){
        let enviar = confirm("¿Seguro de enviar el mensaje?");

        if(enviar){
            let nota = $("#nota-miembro").val();
            alert(nota);
        }
        // else{
        //     $("#nota-miembro").val("");
        // }

    }

    function mostrarCampoNotas() {
        $(".notas").removeClass('d-none');
        $("#ocultar").removeAttr('hidden');
        $("#mostrar").addClass('d-none', 'd-none');
    }

    function ocutarCampoNotas() {
        $("#nota-miembro").val("");
        $(".notas").addClass('d-none', 'd-none');
        $("#ocultar").attr('hidden', 'hidden');
        $("#mostrar").removeClass('d-none');
    }
</script>
@endpush
