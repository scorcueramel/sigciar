@extends('layouts.private.private', ['activePage' => 'nutricion.index'])
@push('title', 'Nutrición')
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
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Nutricion /</span> Todas </h4>
    </div>
    <div class="col-md text-end">
        <a href="{{route('nutricion.create')}}" class="btn btn-sm btn-info"><i class="fa-regular fa-salad me-1"></i>
            Nueva</a>
    </div>
</div>
<div class="row p-3">
    <div class="card pt-2">
        <div class="card-body">
            <div class="row pb-3">
                <div class="col-md-auto d-flex align-items-center">
                    <a role="button" href="{{route('nutricion.index')}}" class="text-decoration-none text-secondary">Modo lista</a>
                </div>
                <div class="col-md-auto">
                    <a role="button" href="#" class="btn btn-primary">Modo calendario</a>
                </div>
            </div>
            <div class="row">
                <div id='nutrition'></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(() => {
        var atencion = new Array();

        $.ajax({
            type: "GET",
            url: "{{route('calendario.disponibilidad.nutricion')}}",
            success: function(response) {
                response.forEach(e => {
                    console.log(e);
                    atencion.push(e);
                });
            }
        })

        // Obtener datos para mostrar en la vista  calendario
        // Obtener la fecha actual para bloquear los días pasados.
        moment.locale('es'); //->colocar el idioma español.

        var calendarEl = document.getElementById('nutrition');

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
                left: 'today prevYear,prev,next,nextYear',
                center: 'title',
                right: 'dayGridMonth',
            },
            events: "{{route('calendario.nutricion')}}",
            businessHours: [ //Horas de inactividad de las canchas
                // atencion.forEach(e => {
                //     {
                //         startTime = e.starttime,
                //         endTime = e.endtime,
                //         daysOfWeek = [e.daysofweek]
                //     }
                // })
            ],
            eventClick: function() {

            }
        });
        calendar.render();
    });
</script>
@endpush
