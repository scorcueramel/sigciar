@extends('layouts.private.private', ['activePage' => 'calendario.general'])
@push('title', 'Calendario General')
@push('css')
<style>
    .fc-timegrid-slot-lane {
        height: 60px !important;
    }
</style>
@endpush
@section('content')
<div class="row">
    @can('calendario.dashboard')
    <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
            <div class="row row-bordered g-0">
                <div class="pt-4 px-3">
                    <h5 class="text-nowrap mb-2">Calendario Genelares de Actividades</h5>
                    <div class="row mt-5">
                        <div class="col-sm-12 col-md-2">
                            <label for="">Sede</label>
                            <select class="form-select" aria-label="sedes" id="sedes" name="sede">
                                <option value="" selected>SELECCIONAR SEDE</option>
                                <option value="0">TODOS</option>
                                @foreach ($sedes as $sede)
                                <option value="{{$sede->id}}">{{$sede->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="">Lugar</label>
                            <select class="form-select" aria-label="Lugares" name="lugar" id="lugares" disabled>
                                <option value="" selected>SELECCIONAR LUGAR</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="">Tipó de Servicio</label>
                            <select class="form-select" aria-label="tiposervicio" id="tiposervicios" name="tiposervicio">
                                <option value="" selected>SELECCIONAR TIPO DE SERVICIO</option>
                                <option value="0">TODOS</option>
                                @foreach ($tiposervicios as $tiposervicio)
                                <option value="{{$tiposervicio->id}}">{{$tiposervicio->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <button class="btn btn-primary mt-4" type="button" id="btnBuscar">Búscar</button>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 mb-3">
                    <div class="col-md-12 mx-2">
                        <div id='calendario'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
<!-- moda details reservation -->
@include('components.private.modal', [
'tamanio'=>'modal-md',
'withTitle' => true,
'withButtons' => true,
'cancelbutton' => true,
'mcTextCancelButton' => 'Cerrar',
])
@push('js')
<script>
    $(document).ready(function() {
        $("#sedes").on('change', function() {
            var id = $("#sedes").val();
            $.ajax({
                type: "GET",
                url: `/admin/obtener/lugar/${id}/calendario-general`,
                success: function(response) {
                    if (response.length > 0) {
                        $("#lugares").removeAttr('disabled');
                        $("#lugares").html('');
                        $("#lugares").append('<option value="" selected>SELECCIONA UN LUGAR</option>');
                        response.forEach((e) => {
                            $("#lugares").append(`
                                <option value="${e.id}">${e.descripcion}</option>
                            `);
                        });
                    } else {
                        $("#lugares").attr('disabled', 'disabled');
                        $("#lugares").html('');
                        $("#lugares").append('<option value="" selected>SELECCIONA UN LUGAR</option>');
                    }
                }
            });
        });
        moment.locale('es');
        var calendarEl = document.getElementById('calendario');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            allDaySlot: false,
            // contentHeight: 20,
            dayMaxEvents: 3,
            editable: false,
            eventOverlap: false,
            height: 900,
            locale: 'es-PE',
            timeZone: 'UTC',
            slotDuration: '01:00',
            unselectAuto: true,
            selectable: true,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today' // user can switch between the two
            },
            slotLabelFormat: { //se visualizara de esta manera 01:00 AM en la columna de horas
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
                meridiem: 'short'
            },
            eventTimeFormat: { //y este código se visualizara de la misma manera pero en el titulo del evento creado en fullcalendar
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
                meridiem: 'short'
            },
            headerToolbar: {
                left: 'today prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            events: `/admin/obtener/eventos`,
            eventClick: function(info) {
                $("#modalcomponent").modal("show");
                $("#mcLabel").html(`DETALLE DE LA CITA`);
                $("#mcbody").html(`
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>NOMBRES</td>
                                            <td>${info.event.title}</td>
                                        </tr>
                                        <tr>
                                            <td>MOVIL</td>
                                            <td>${info.event.extendedProps.movil}</td>
                                        </tr>
                                        <tr>
                                            <td>CORREO</td>
                                            <td>${info.event.extendedProps.correo}</td>
                                        </tr>
                                        <tr>
                                            <td>CATEGORÍA</td>
                                            <td>${info.event.extendedProps.categoria}</td>
                                        </tr>
                                        <tr>
                                            <td>SEDE</td>
                                            <td>${info.event.extendedProps.sede}</td>
                                        </tr>
                                        <tr>
                                            <td>LUGAR</td>
                                            <td>${info.event.extendedProps.lugar}</td>
                                        </tr>
                                        <tr>
                                            <td>FECHA</td>
                                            <td>${info.event.extendedProps.fecha}</td>
                                        </tr>
                                        <tr>
                                            <td>HORA INICIO</td>
                                            <td>${info.event.extendedProps.inicio}</td>
                                        </tr>
                                        <tr>
                                            <td>HORA FIN</td>
                                            <td>${info.event.extendedProps.fin}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            `);
            },
        });
        calendar.render();
    });


    $("#btnBuscar").on('click', function() {
        var sede = $("#sedes").val() == "" || $("#sedes").val() == null ? 0 : $("#sedes").val();
        var lugar = $("#lugares").val() == "" || $("#lugares").val() == null ? 0 : $("#lugares").val();
        var tiposervicio = $("#tiposervicios").val() == "" || $("#tiposervicios").val() == null ? 0 : $("#tiposervicios").val();

        console.log("sede: " + sede);
        console.log("lugar: " + lugar);
        console.log("tiposervicio: " + tiposervicio);

        calendarRender(tiposervicio, sede, lugar);
    });


    function calendarRender(tiposervicio, sede, lugar) {
        moment.locale('es');
        var calendarEl = document.getElementById('calendario');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            allDaySlot: false,
            // contentHeight: 20,
            dayMaxEvents: 3,
            editable: false,
            eventOverlap: false,
            height: 900,
            locale: 'es-PE',
            timeZone: 'UTC',
            slotDuration: '01:00',
            unselectAuto: true,
            selectable: true,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today' // user can switch between the two
            },
            slotLabelFormat: { //se visualizara de esta manera 01:00 AM en la columna de horas
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
                meridiem: 'short'
            },
            eventTimeFormat: { //y este código se visualizara de la misma manera pero en el titulo del evento creado en fullcalendar
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
                meridiem: 'short'
            },
            headerToolbar: {
                left: 'today prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            events: `/admin/obtener/${tiposervicio}/${sede}/${lugar}/eventos`,
            eventClick: function(info) {
                $("#modalcomponent").modal("show");
                $("#mcLabel").html(`DETALLE DE LA CITA`);
                $("#mcbody").html(`
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>NOMBRES</td>
                                            <td>${info.event.title}</td>
                                        </tr>
                                        <tr>
                                            <td>MOVIL</td>
                                            <td>${info.event.extendedProps.movil}</td>
                                        </tr>
                                        <tr>
                                            <td>CORREO</td>
                                            <td>${info.event.extendedProps.correo}</td>
                                        </tr>
                                        <tr>
                                            <td>CATEGORÍA</td>
                                            <td>${info.event.extendedProps.categoria}</td>
                                        </tr>
                                        <tr>
                                            <td>SEDE</td>
                                            <td>${info.event.extendedProps.sede}</td>
                                        </tr>
                                        <tr>
                                            <td>LUGAR</td>
                                            <td>${info.event.extendedProps.lugar}</td>
                                        </tr>
                                        <tr>
                                            <td>FECHA</td>
                                            <td>${info.event.extendedProps.fecha}</td>
                                        </tr>
                                        <tr>
                                            <td>HORA INICIO</td>
                                            <td>${info.event.extendedProps.inicio}</td>
                                        </tr>
                                        <tr>
                                            <td>HORA FIN</td>
                                            <td>${info.event.extendedProps.fin}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            `);
            },
        });
        calendar.render();
    }
</script>
@endpush
