@extends('layouts.private.private', ['activePage' => 'calendario.general'])
@push('title', 'Calendario General')
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
                            <select class="form-select" aria-label="sedes" id="sedes">
                                <option value="" disabled selected>Selecciona una sede</option>
                                <option value="0">TODOS</option>
                                @foreach ($sedes as $sede)
                                <option value="{{$sede->id}}">{{$sede->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="">Lugar</label>
                            <select class="form-select" aria-label="Lugares" id="lugares" disabled>
                                <option value="" disabled selected>Selecciona un lugar</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="">Tipó de Servicio</label>
                            <select class="form-select" aria-label="tiposervicio">
                                <option value="" disabled selected>Selecciona un tipo de servicio</option>
                                @foreach ($tiposervicios as $tiposervicio)
                                <option value="{{$tiposervicio->id}}">{{$tiposervicio->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <button class="btn btn-primary mt-4">Búscar</button>
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
@push('js')

<script>
    $("#sedes").on('change', function() {
        var id = $("#sedes").val();
        $.ajax({
            type: "GET",
            url: `/admin/obtener/lugar/${id}/calendario-general`,
            success: function(response) {
                if (response.length > 0) {
                    $("#lugares").removeAttr('disabled');
                    $("#lugares").html('');
                    $("#lugares").append('<option value="" disabled selected>Selecciona un lugar</option>');
                    response.forEach((e) => {
                        $("#lugares").append(`
                            <option value="${e.id}">${e.descripcion}</option>
                        `);
                    });
                } else {
                    $("#lugares").attr('disabled', 'disabled');
                    $("#lugares").html('');
                    $("#lugares").append('<option value="" disabled selected>Selecciona un lugar</option>');
                }
            }
        });
    });

    var checkLogin = $('#loginCheck').val();
    // Obtener la fecha actual para bloquear los días pasados.
    moment.locale('es'); //->colocar el idioma español.

    var calendarEl = document.getElementById('calendario');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap5',
        allDaySlot: false,
        contentHeight: 20,
        dayMaxEvents: 1,
        editable: true,
        eventOverlap: true,
        eventShortHeight: 'short',
        height: 500,
        initialView: 'dayGridMonth',
        locale: 'es-PE',
        selectable: true,
        timeZone: 'UTC',
        unselectAuto: true,
        headerToolbar: {
            left: 'title',
            center: '',
            right: 'today prev,next'
        },
        events: `/admin/obtener/eventos`,
        eventClick: function() {
            //obtener la data de la actividad cliqueada
        }
    });
    calendar.render();
</script>
@endpush
