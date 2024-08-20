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

    .fc-timegrid-slot-lane {
        height: 60px !important;
    }
</style>
@endpush
@section('content')
@include('components.private.messages-session')
<div class="row d-flex align-items-center">
    <div class="col-md">
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Generar Nueva /</span> Cita </h4>
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
                    <a role="button" href="{{route('nutricion.index')}}" class="text-decoration-none text-secondary">Programas</a>
                </div>
                <div class="col-md-auto">
                    <a role="button" href="#" class="btn btn-primary">Citas</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="cargaprogramas" class="form-label">Programas de Nutrición</label>
                    <select class="form-select" id="cargaprogramas" required>
                        <option selected disabled value="">Seleccina un Programa</option>
                        @foreach ($progrmasNutricion as $programa)
                        <option value="{{$programa->id}}">{{$programa->categoria}} / {{$programa->sede}} / {{$programa->lugar_descripcion}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mt-4">
                    <div id='nutrition'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- moda details reservation -->
@include('components.private.modal-deta-celndar', [
'tamanio'=>'modal-sm',
'withTitle' => true,
'withButtons' => true,
'cancelbutton' => true,
'mcTextCancelButton' => 'Cerrar',
])
<!-- modal reservation -->
@include('components.private.modal', [
'withTitle' => true,
'withButtons' => true,
'cancelbutton' => true,
'mcTextCancelButton' => 'Cerrar',
])
@push('js')
<script>
    $("#cargaprogramas").on('change', function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: `/admin/nutricion/calendar/${id}`,
            success: function(response) {
                var dp = response;
                var dispo = new Array();

                dp.forEach(e => {
                    dispo.push({
                        'startTime': e.starttime.split(" ")[1],
                        'endTime': e.endtime.split(" ")[1],
                        'daysOfWeek': [e.daysofweek]
                    })
                });

                moment.locale('es');
                var calendarEl = document.getElementById('nutrition');
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
                    eventBackgroundColor: '#ff6347',
                    eventBorderColor: '#ff6347',
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
                    businessHours: dispo,
                    selectConstraint: "businessHours",
                    events: `/admin/nutricion/inscritos/${id}`,
                    eventClick: function(info) {
                        $("#modaldetacalendar").modal("show");
                        $("#mdetalabel").html(`DETALLE DE LA CITA`);
                        $("#modaldetabody").html(`
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
                    select: function(info) {
                        var fecha = info.startStr;
                        var start = info.startStr;
                        var end = info.endStr;
                        var valHora = validaHoraActual(start);

                        if (valHora) {
                            $("#modalcomponent").modal('show');
                            $("#mcLabel").text(`
                                Fecha u Hora pasada!
                            `);
                            $("#mcbody").html(`
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>No puedes seleccionar una fecha u hora pasada, porfavor verifica tu selección!</p>
                                    </div>
                                </div>
                            `);
                            $('.cancelButton').on('click', function() {
                                $("#mcLabel").text(``);
                                $("#mcbody").text(``);
                            });
                        } else {
                            $.ajax({
                                type: "GET",
                                url: "{{route('nutricion.obtenerprecio')}}",
                                success: function(response) {
                                    $("#precio_cita").val(`S/.${response[0].lugar_costo_hora}.00`);
                                    if (response[0].tipo == 'V') {
                                        $("#precio_cita").removeAttr('readonly');
                                    }
                                }
                            });
                            $("#modalcomponent").modal('show');
                            $("#mcLabel").text(`
                                Registro de Cita
                            `);
                            $("#mcbody").html(`
                                <form method="POST" action="{{route('nutricion.inscripcion')}}" id="inscribirmiembro">
                                @csrf
                                    <input type="hidden" id="idservicio" name="idservicio" value="${id}"/>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="mb-3">
                                                <input type="hidden" name="fecha" value="${fecha}" id="fecha">
                                                <label for="fecha" class="form-label">Fecha Seleccionada</label>
                                                <input type="text" class="form-control" value="${formatearFecha(fecha)}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="mb-3">
                                                <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                                                <input type="text" class="form-control" id="hora_inicio" name="hora_inicio" value="${formatearHora(start)}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="mb-3">
                                                <label for="hora_fin" class="form-label">Hora de Termino</label>
                                                <input type="text" class="form-control" name="hora_fin" id="hora_fin" value="${formatearHora(end)}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="mb-3">
                                                <label for="hora_fin" class="form-label">Precio Cita</label>
                                                <input type="text" name="precio_cita" class="form-control" id="precio_cita" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-4">
                                            <label for="buscar-miembro" class="form-label">Búscar Miembro</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Búscar Miembro" aria-label="Búsacar Miembro" aria-describedby="datos-miembro" id="documento-miembro">
                                                <button class="btn btn-outline-primary" type="button" onclick="javascript:buscarMiembro(document.getElementById('documento-miembro').value)">Búscar</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-8">
                                            <label for="datos-miembro" class="form-label">Nombre de Miembro</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="mimebro-encontrado">Datos</span>
                                                <input type="hidden" id="id_miembro" name="id_miembro">
                                                <input type="text" class="form-control" id="miembro-encontrado" placeholder="Datos del Miembro" aria-label="mimebro-encontrado" aria-describedby="mimebro-encontrado" readonly>
                                                <button class="btn btn-outline-primary" type="submit" id="inscribirMiembro" disabled>Reservar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            `);
                            $('.cancelButton').on('click', function() {
                                $("#mcLabel").text(``);
                                $("#mcbody").text(``);
                            });
                        }
                    }
                });
                calendar.render();
            }
        });
    });

    // Formtear Fecha Para Mostrar
    function formatearFecha(fecha) {
        var fecha = fecha;
        var fecha_date = fecha.split('T');
        fecha_date = fecha_date[0];
        var fecha_format = fecha_date.split('-');
        var fecha_salida = fecha_format[2] + '/' + fecha_format[1] + '/' + fecha_format[0]
        return fecha_salida;
    }
    // Formtear Hora Para Mostrar
    function formatearHora(hora) {
        var fecha = hora;
        var fecha_date = fecha.split('T');
        var fecha_time = fecha_date[1].split(':');
        fecha_date = fecha_date[0];
        var horaSalida = fecha_time[0] + ':' + fecha_time[1];
        return horaSalida;
    }

    // Formtear Fecha y Hora Inicial Para Almacenar
    function formatearFechaInicial(fechaHoraInicial) {
        var fecha = fechaHoraInicial;
        var fecha_date = fecha.split('T');
        var fecha_time = fecha_date[1].split(':');
        fecha_date = fecha_date[0];
        var fecha_format = fecha_date.split('-');
        var fecha_salida = fecha_format[2] + '/' + fecha_format[1] + '/' + fecha_format[0]
        var fechaHoraInicialFormat = fecha_salida + ' ' + fecha_time[0] + ':' + fecha_time[1];
        return fechaHoraInicialFormat;
    }

    // Validar hora actual
    function validaHoraActual(hora) {
        let start = hora;
        let fechaHoraActual = new Date();
        let horaActual = fechaHoraActual.getHours();
        let horaSelecc = formatearFechaInicial(start);
        let horaSplit = horaSelecc.split(" ");
        let horaSeleccionada = horaSplit[1].slice(0, 2);
        let fechaActual = fechaHoraActual.getDate();
        let fechaSeleccionada = horaSplit[0].slice(0, 2);

        let hoy = fechaHoraActual.getDate()+'/'+((fechaHoraActual.getMonth() + 1) < 10  ? "0"+(fechaHoraActual.getMonth() + 1) : (fechaHoraActual.getMonth() + 1) );
        let seleccionada = horaSelecc.split(" ")[0].slice(0,5);

        // console.log("21/08" == seleccionada);
        console.log("Hoy :" + hoy);
        console.log("seleccionado :" + seleccionada);

        if (seleccionada == hoy) {
            if (horaSeleccionada > horaActual) {
                return false;
            } else {
                return true;
            }
        }

        if (seleccionada > hoy) {
            return false;
        }

        if (seleccionada < hoy) {
            return true;
        }
    }

    function buscarMiembro(documento) {
        $.ajax({
            type: "GET",
            url: `/admin/nutricion/obtener/${documento}/miembro`,
            success: function(response) {
                if (typeof(response) == 'string') {
                    $("#modalcomponent").modal('show');
                    $("#mcLabel").text(`
                        Miembro no encontrado!
                    `);
                    $("#mcbody").html(`
                        <div class="row">
                            <div class="col-md-12">
                                <p>${response}.</p>
                                <p>De lo contrario puedes intentar registrnado al usuario dando click en el enlace a continuación <a href="{{route('registro.member')}}" target="_blank">Registrar</a></p>
                            </div>
                        </div>
                    `);
                    $('.cancelButton').on('click', function() {
                        $("#mcLabel").text(``);
                        $("#mcbody").text(``);
                    });
                } else {
                    $("#id_miembro").val(`${response[0].id}`)
                    $("#miembro-encontrado").val(`${response[0].nombres} ${response[0].apepaterno} ${response[0].apematerno}`)
                    $("#inscribirMiembro").removeAttr("disabled");
                }
            }
        });
    }
</script>
@endpush
