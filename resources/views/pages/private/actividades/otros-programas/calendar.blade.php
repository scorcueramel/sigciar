@extends('layouts.private.private', ['activePage' => 'otrosprogramas.index'])
@push('title', 'Otros Programas')
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
    <!-- <div class="col-md text-end">
        <a href="{{route('otrosprogramas.create',4)}}" class="btn btn-sm btn-info"><i class="fa-regular fa-salad me-1"></i>
            Nueva</a>
    </div> -->
</div>
<div class="row p-3">
    <div class="card pt-2">
        <div class="card-body">
            <div class="row pb-3">
                <div class="col-md-auto d-flex align-items-center">
                    <a role="button" href="{{route('otrosprogramas.index')}}" class="text-decoration-none text-secondary">Programas</a>
                </div>
                <div class="col-md-auto">
                    <a role="button" href="#" class="btn btn-primary">Citas</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="cargaprogramas" class="form-label">Programas de Otros Programas</label>
                    <select class="form-select" id="cargaprogramas" name="cargaprogramas" required>
                        <option selected disabled value="">Seleccina un Programa</option>
                        @foreach ($otrosProgramas as $programa)
                        <option value="{{$programa->id}}">{{$programa->categoria}} / {{$programa->sede}} / {{$programa->lugar_descripcion}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mt-4">
                    <div id='otrosprogramas'></div>
                    {{-- inputs para luego de registrar miembor, opcional --}}
                    <input type="hidden" id="fecha">
                    <input type="hidden" id="start">
                    <input type="hidden" id="end">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('components.private.notas-modal')
<!-- modal reservation -->
@include('components.private.modal', [
'tamanio'=>'modal-md',
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
            url: `/admin/otros-programas/calendar/${id}`,
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
                var calendarEl = document.getElementById('otrosprogramas');
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
                    slotMinTime: '06:00',
                    slotMaxTime: '24:00',
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
                    events: `/admin/otros-programas/inscritos/${id}`,
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
                                    <tr>
                                        <td>Envira Nota</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" id="nuevanota" onclick="notaModal('${info.event.title}',${info.event.extendedProps.servicioinscripcion})">Nueva Nota</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ver Notas</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" id="vernotas" onclick="verNotas('${info.event.title}',${info.event.extendedProps.servicioinscripcion})">Ver Notas</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        `);
                    },
                    select: function(info) {
                        var fecha = info.startStr;
                        var start = info.startStr;
                        var end = info.endStr;

                        $("#fecha").val(fecha);
                        $("#start").val(start);
                        $("#end").val(end);

                        var programa = $("#cargaprogramas").val();

                        var fechaSeleccionada = formatdatefromvalidate(start);

                        moment.locale('es');
                        var now = moment();
                        var fechaHoraActual = now.format('YYYY-MM-DD HH:mm:ss');

                        $.ajax({
                            type: "POST",
                            url: "{{ route('nutricion.validate.datetime') }}",
                            data: {
                                programa,
                                fechaSeleccionada,
                                fechaHoraActual,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.codigo == 0) {
                                    cargarFormularioInscripcion(id, fecha, start, end);
                                } else if (response.codigo == 88) {
                                    $("#modalcomponent").modal('show');
                                    $("#mcLabel").text(`
                                        Fecha no valida!
                                    `);
                                    $("#mcbody").html(`
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>La fecha no se encuentra disponible para resereva!</p>
                                            </div>
                                        </div>
                                    `);
                                    $('.cancelButton').on('click', function() {
                                        $("#mcLabel").text(``);
                                        $("#mcbody").text(``);
                                    });
                                } else if (response.codigo == 99) {
                                    $("#modalcomponent").modal('show');
                                    $("#mcLabel").text(`
                                        Fecha no valida!
                                    `);
                                    $("#mcbody").html(`
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>La fecha seleccionada no es valida!</p>
                                            </div>
                                        </div>
                                    `);
                                    $('.cancelButton').on('click', function() {
                                        $("#mcLabel").text(``);
                                        $("#mcbody").text(``);
                                    });
                                }
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }
                });
                calendar.render();
            }
        });
    });

    function cargarFormularioInscripcion(id, fecha, start, end) {
        let title = $('select[name="cargaprogramas"] option:selected').text().split('/');

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
        $("#mcLabel").html(`RESERVEAR CITA PARA <strong>${title[0]}</strong>`);
        $("#mcbody").html(`
            <form method="POST" action="{{route('nutricion.inscripcion')}}" id="inscribirmiembro">
            @csrf
                <input type="hidden" id="idservicio" name="idservicio" value="${id}"/>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3">
                            <input type="hidden" name="fecha" value="${fecha}" id="fecha">
                            <label for="fecha" class="form-label">Fecha Seleccionada</label>
                            <input type="text" class="form-control" value="${formatearFecha(fecha)}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                            <input type="text" class="form-control" id="hora_inicio" name="hora_inicio" value="${formatearHora(start)}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Hora de Termino</label>
                            <input type="text" class="form-control" name="hora_fin" id="hora_fin" value="${formatearHora(end)}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Precio Cita</label>
                            <input type="text" name="precio_cita" class="form-control" id="precio_cita" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="buscar-miembro" class="form-label">Búscar Miembro</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Búscar Miembro" aria-label="Búsacar Miembro" aria-describedby="datos-miembro" id="documento-miembro">
                            <button class="btn btn-outline-primary" type="button" onclick="javascript:buscarMiembro(document.getElementById('documento-miembro').value)">Búscar</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 errordocumento mb-3" style="margin-top:-10px"></div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
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

    function formatdatefromvalidate(fecha) {
        var fecha_date = fecha.split('T');
        var fecha_time = fecha_date[1].split(':');
        var fecha = fecha_date[0];
        var hora = fecha_date[1].substring(0, fecha_date[1].length - 1)
        var fechaSalida = fecha + ' ' + hora;

        return fechaSalida;
    }

    function notaModal(miembro, servicioinscripcion) {
        $("#notamodal").modal("show");
        $("#modalcomponent").modal("hide");
        $("#modalnotas").html(`ENVIAR NOTA A <strong class="text-primary">${miembro}</strong>`);

        $("#modalnotabody").html("");

        $("#modalnotabody").append(`
                <input type="hidden" id="servinsc_id" value="${servicioinscripcion}">
                <div class="mb-3">
                    <label for="nota-miembro" class="form-label">Nota</label>
                    <textarea class="form-control" id="nota-miembro" rows="3" placeholder="Escribir nota aquí" maxlength="300" aria-describedby="description" onkeypress="javascript:document.getElementById('error').classList.add('d-none')" style="height: 150px;" required></textarea>
                    <div id="description" class="form-text text-primary">300 caracteres como máximo permitido.</div>
                    <div class="d-none" id="error">
                        <p class="text-danger">Debes ingresar una nota para enviar</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="enlace" class="form-label">Enlace (link)</label>
                    <input type="text" class="form-control" id="enlace-miemrbo" placeholder="Dirección url del adjunto">
                </div>
            `);

        $("#modalnotafooter").html("");
        $("#modalnotafooter").append(`
                <button class="btn btn-sm btn-danger" id="cancelarenvio" data-bs-target="#modalcomponent" data-bs-toggle="modal">Cancelar</button>
                <button class="btn btn-sm btn-primary" id="enviarnota" onclick="javascript:enviarNota();">Enviar</button>
        `);
    }

    function enviarNota() {
        let miembro = $("#modalnotas").text();
        let largo = miembro.length;
        let nombre = miembro.slice(14, largo);

        let servinscid = $("#servinsc_id").val();
        let nota = $("#nota-miembro").val();
        let enlace = $("#enlace-miemrbo").val();

        if (nota == '') {
            $("#error").removeClass('d-none')
        } else {
            $("#notamodal").modal('hide');
            Swal.fire({
                title: `¿Enviar Nota?`,
                html: `
                A <strong>${nombre}</strong> <br>
                Al enviar la nota el miembro recibirá un correo eléctronico y también encontrará la nota en su bandeja personal, ¿está seguro de enviar la nota?
                `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si enviar",
                cancelButtonText: "Cancelar",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Nota enviado",
                        text: `${nombre}, recibió un correo eléctronico y se almaceno en su bandeja personal la nota enviada`,
                        icon: "success",
                        allowOutsideClick: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entendido",
                    }).then((res) => {
                        Swal.fire({
                            icon: 'info',
                            html: "Espere un momento porfavor ...",
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        if (res.isConfirmed) {
                            $("#nota-miembro").val("");
                            $("#enlace-miemrbo").val("");
                            $.ajax({
                                type: "POST",
                                url: "{{route('enviar.notas.miembros')}}",
                                data: {
                                    nota,
                                    enlace,
                                    servinscid
                                },
                                success: function(response) {
                                    if (response == 'ok') {
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    });
                } else {
                    $("#notamodal").modal('show');
                }
            });
        }
    }

    function verNotas(miembro, servicioinscripcion) {
        $("#notamodal").modal("show");
        $("#modalcomponent").modal("hide");
        $("#modalnotas").html(`NOTAS DE <strong class="text-primary">${miembro}</strong>`);
        $("#modalnotabody").html("");
        $("#modalnotabody").append(`
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-primary">Cargando...</p>
                </div>
            </div>
        `);

        $.ajax({
            type: "GET",
            url: `/admin/otros-programas/obtener/${servicioinscripcion}/notas`,
            success: function(response) {
                $("#modalnotabody").html("");
                if (response.length > 0) {
                    for (let index = 0; index < response.length; index++) {
                        const element = response[index];
                        if (!element.privado) {
                            $("#modalnotabody").append(`
                        <div class="accordion accordion-flush" id="accordion${index}">
                        <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse${index}" aria-expanded="false" aria-controls="flush-collapse${index}">
                                    <strong>Nota #${(index+1) < 10 ? '0' + (index+1) : (index+1)}</strong>
                                </button>
                                </h2>
                                <div id="flush-collapse${index}" class="accordion-collapse collapse" data-bs-parent="#accordion${index}">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-8 d-flex align-items-center">
                                                <div class="row">
                                                    <div class="col-12 mb-4">
                                                        <small>Fecha de envío: ${formatearCreatedat(element.created_at)}</small>
                                                    </div>
                                                    <div class="col-12">
                                                        ${element.detalle}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-end">
                                                        ${element.adjuntto != null ? '<a href="'+element.adjuntto+'" class="btn btn-primary btn-sm mx-1" target="_blank">Ver adjunto</a>' : ''}
                                                        <button type="button" class="btn btn-sm btn-success" onclick="javascript:editarNotaModal('${miembro}',${element.id});">Editar Nota</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        `);
                        } else {
                            $("#modalnotabody").append(`
                                <div class="jumbotron jumbotron-fluid">
                                    <div class="container">
                                        <p class="lead">Este miembro no cuenta con ninguna nota enviada.</p>
                                    </div>
                                </div>
                    `)
                        }
                    }
                } else {
                    $("#modalnotabody").append(`
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="lead">Este miembro no cuenta con ninguna nota enviada.</p>
                        </div>
                    </div>
                    `)

                }
            }
        });

        $("modalnotafooter").html("");
        $("modalnotafooter").append(`
            <button class="btn btn-sm btn-danger" id="cancelarenvio" data-bs-target="#modalcomponent" data-bs-toggle="modal">Cancelar</button>
        `);
    }

    function editarNotaModal(miembro, idinforme) {
        $.ajax({
            type: "GET",
            url: `/admin/otros-programas/edit/${idinforme}/notas`,
            success: function(response) {
                let data = response[0];
                $("#notamodal").modal("show");
                $("#modalcomponent").modal("hide");
                $("#modalnotas").html(`EDITAR NOTA DE <strong class="text-primary">${miembro}</strong>`);
                $("#modalnotabody").html("");
                $("#modalnotabody").append(`
                    <input type="hidden" id="informe_id" value="${data.id}">
                    <div class="mb-3">
                        <label for="nota-miembro" class="form-label">Nota</label>
                        <textarea class="form-control" id="nota-miembro" rows="3" placeholder="Escribir nota aquí" maxlength="300" aria-describedby="description" onkeypress="javascript:document.getElementById('error').classList.add('d-none')" style="height: 150px;" required>${data.detalle}</textarea>
                        <div id="description" class="form-text text-primary">300 caracteres como máximo permitido.</div>
                        <div class="d-none" id="error">
                            <p class="text-danger">Debes ingresar una nota para enviar</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="enlace" class="form-label">Enlace (link)</label>
                        <input type="text" class="form-control" id="enlace-miemrbo" placeholder="Dirección url del adjunto" value="${data.adjuntto == null ? '' : data.adjuntto}">
                    </div>
                `);
                $("#modalnotafooter").html("");
                $("#modalnotafooter").append(`
                        <button class="btn btn-sm btn-danger" id="cancelarenvio" data-bs-target="#modalcomponent" data-bs-toggle="modal">Cancelar</button>
                        <button class="btn btn-sm btn-primary" id="enviarnota" onclick="javascript:editarNota(${data.id});">Enviar</button>
                `);
            }
        });
    }

    function editarNota(id) {
        let miembro = $("#modalnotas").text();
        let largo = miembro.length;
        let nombre = miembro.slice(14, largo);

        let nota = $("#nota-miembro").val();
        let enlace = $("#enlace-miemrbo").val();

        if (nota == '') {
            $("#error").removeClass('d-none')
        } else {
            $("#notamodal").modal('hide');
            Swal.fire({
                title: `¿Enviar Nota?`,
                html: `
                A <strong>${nombre}</strong> <br>
                Vas a actualizar nota, esta acción enviara un nuevo correo al miembro con la actulaización realizada.
                `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si actializar",
                cancelButtonText: "Cancelar",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Nota actualiizada",
                        text: `${nombre}, recibió un correo eléctronico con la actualización realizada y se almaceno en su bandeja personal.`,
                        icon: "success",
                        allowOutsideClick: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entendido",
                    }).then((res) => {
                        Swal.fire({
                            icon: 'info',
                            html: "Espere un momento porfavor ...",
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        if (res.isConfirmed) {
                            $("#nota-miembro").val("");
                            $("#enlace-miemrbo").val("");
                            $.ajax({
                                type: "POST",
                                url: "{{route('actualizar.notas.miembros')}}",
                                data: {
                                    nota,
                                    enlace,
                                    id
                                },
                                success: function(response) {
                                    if (response == 'ok') {
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    });
                } else {
                    $("#notamodal").modal('show');
                }
            });
        }
    }

    $("#cancelarenvio").on('click', function() {
        $("#nota-miembro").val("");
        $("#enlace-miemrbo").val("");
    });

    // formatear fecha creted_at
    function formatearCreatedat(fecha) {
        var cutDate = fecha.split('-');
        var lastDay = cutDate[2].split(" ")
        var cutHour = cutDate[2].split(" ");
        var getHour = cutHour[1].split(":")

        var fecha_salida = `${lastDay[0]}/${cutDate[1]}/${cutDate[0]} ${getHour[0]}:${getHour[1]} ${getHour[0] > 12 ? 'PM' : 'AM'}`;


        return fecha_salida;
    }

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

    function buscarMiembro(documento) {
        $.ajax({
            type: "GET",
            url: `/admin/otros-programas/obtener/${documento}/miembro`,
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
                                <p>De lo contrario puedes intentar registrnado al usuario dando click al botón a continuación <button class="btn btn-sm btn-primary" onclick="javascript:registrarNuevo()">Registrar</button></p>
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

    function registrarNuevo() {
        $(".modal-footer").addClass('d-none');
        $("#mcLabel").html('');
        $("#mcLabel").html('Registrar Nuevo Miembro');
        $("#mcbody").html('');
        $("#mcbody").append(`
                <div class="row mb-3">
                    <label for="tipodocumento_id" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de documento:') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="input-group-text" for="tipodocumento_id"><i class="fa-solid fa-id-card"></i></label>
                            <select class="form-select" id="tipodocumento_id" name="tipodocumento_id" onchange="$('#documentto').removeAttr('readonly')" required>
                                <option selected disabled>Seleccionar tipo</option>
                                @foreach ($tipoDocs as $tpd)
                                    <option value="{{ $tpd->id }}">{{ $tpd->abreviatura }}</option>
                                @endforeach
                            </select>
                            <div class="d-none errortipodocumento">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="documento" class="col-md-4 col-form-label text-md-end">{{ __('Documento') }}</label>
                    <div class="col-md-6">
                        <input id="documentto" type="number" class="form-control @error('documento') is-invalid @enderror" name="documento" value="{{ old('documento') }}" maxLength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" inputmode="numeric" readonly required>
                        <div class="d-none errordocumento">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="apepaterno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Parterno') }}</label>

                    <div class="col-md-6">
                        <input id="apepaterno" type="text" class="form-control @error('apepaterno') is-invalid @enderror" name="apepaterno" value="{{ old('apepaterno') }}" maxlength="50" required>

                        <div class="d-none errorapepaterno">
                            <strong class="apepaterno"></strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="apematerno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Marterno') }}</label>

                    <div class="col-md-6">
                        <input id="apematerno" type="text" class="form-control @error('apematerno') is-invalid @enderror" name="apematerno" value="{{ old('apematerno') }}" maxlength="50" required>

                        <div class="d-none erroraapematerno">
                            <strong class="apematerno"></strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nombres" class="col-md-4 col-form-label text-md-end">{{ __('Nombres') }}</label>

                    <div class="col-md-6">
                        <input id="nombres" type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" value="{{ old('nombres') }}" maxlength="50" required>

                        <div class="d-none erroranombres">
                            <strong class="nombres"></strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="movil" class="col-md-4 col-form-label text-md-end">{{ __('movil') }}</label>

                    <div class="col-md-6">
                        <input id="movil" type="text" class="form-control @error('movil') is-invalid @enderror" name="movil" value="{{ old('movil') }}" maxLength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                        <div class="d-none erroramovil">
                            <strong class="movil"></strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo Eléctronico') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        <div class="d-none erroraemail">
                            <strong class="email"></strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        <div class="d-none errorapassword">
                            <strong class="password"></strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                        <div class="d-none errorapassword-confirm">
                            <strong class="password-confirm"></strong>
                        </div>
                    </div>
                </div>

                <div class="row mb-0 d-flex justify-content-between text-center">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-sm btn-primary" onclick="javascript:registrarMiembro();">
                            {{ __('Register') }}
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cerrar') }}
                        </button>
                    </div>
                </div>
        `);

    }

    function obtenerCamposRegistroMiembros() {
        let tipodocumento = $("#tipodocumento_id").val();
        let documento = $("#documentto").val();
        let apepaterno = $("#apepaterno").val();
        let apematerno = $("#apematerno").val();
        let nombres = $("#nombres").val();
        let movil = $("#movil").val();
        let email = $("#email").val();
        let password = $("#password").val();
        let passwordconfirm = $("#password-confirm").val();

        let data = {
            tipodocumento,
            documento,
            apepaterno,
            apematerno,
            nombres,
            movil,
            email,
            password,
            passwordconfirm,
        }

        return data
    }

    function registrarMiembro() {
        // $("#modalcomponent").modal('hide');
        let data = obtenerCamposRegistroMiembros();
        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        $.ajax({
            type: "POST",
            url: "{{route('nutricion.registro.member')}}",
            data: data,
            dataType: "JSON",
            success: function(response) {
                // Swal.close();
                Swal.fire({
                        title: 'Registro Exitoso',
                        html: '<p>Miembro <strong>registrado satisfactoriamente</strong>, ahora puedes continuar con realizar una reserve a su nombre</p>',
                        icon: 'success',
                        allowOutsideClick: false,
                        showCloseButton: false,
                        showConfirmButton: true,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: 'Entendido!',
                        showCancelButton: false,
                        focusConfirm: true,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // window.location.reload();
                            let idprograma = $("#cargaprogramas").val();
                            let fecha = $("#fecha").val()
                            let start = $("#start").val()
                            let end = $("#end").val()
                            cargarFormularioInscripcion(idprograma, fecha, start, end);
                            $("#documento-miembro").val(data.documento);
                        }
                    });
            },
            error: function(error) {
                // Swal.close();
                $("#modalcomponent").modal('show');
                let errores = error.responseJSON;
                gestionMensajes(errores.errors);
            }
        });
    }

    function gestionMensajes(erroresresp) {
        let tipodocumentoexist = 'tipodocumento' in erroresresp;
        let documentoexist = 'documento' in erroresresp;
        let apepaternoexist = 'apepaterno' in erroresresp;
        let apematernoexist = 'apematerno' in erroresresp;
        let nombresexist = 'nombres' in erroresresp;
        let movilexist = 'movil' in erroresresp;
        let emailexist = 'email' in erroresresp;
        let passwordexist = 'password' in erroresresp;
        let passwordconfirmexist = 'passwordconfirm' in erroresresp;

        if (tipodocumentoexist) {
            $('.errortipodocumento').removeClass('d-none');
            $('.errortipodocumento').html(`<small class="text-danger">${erroresresp.tipodocumento}</small>`)
        } else {
            $('.errortipodocumento').addClass('d-none');
            $('.errortipodocumento').html('');
        }

        if (documentoexist) {
            $('.errordocumento').removeClass('d-none');
            $('.errordocumento').html(`<small class="text-danger">${erroresresp.documento}</small>`)
        } else {
            $('.errordocumento').addClass('d-none');
            $('.errordocumento').html('');
        }

        if (apepaternoexist) {
            $('.errorapepaterno').removeClass('d-none');
            $('.errorapepaterno').html(`<small class="text-danger">${erroresresp.apepaterno}</small>`)
        } else {
            $('.errorapepaterno').addClass('d-none');
            $('.errorapepaterno').html('');
        }

        if (apematernoexist) {
            $('.erroraapematerno').removeClass('d-none');
            $('.erroraapematerno').html(`<small class="text-danger">${erroresresp.apematerno}</small>`)
        } else {
            $('.erroraapematerno').addClass('d-none');
            $('.erroraapematerno').html('');
        }

        if (nombresexist) {
            $('.erroranombres').removeClass('d-none');
            $('.erroranombres').html(`<small class="text-danger">${erroresresp.nombres}</small>`)
        } else {
            $('.erroranombres').addClass('d-none');
            $('.erroranombres').html('');
        }

        if (movilexist) {
            $('.erroramovil').removeClass('d-none');
            $('.erroramovil').html(`<small class="text-danger">${erroresresp.movil}</small>`)
        } else {
            $('.erroramovil').addClass('d-none');
            $('.erroramovil').html('');
        }

        if (emailexist) {
            $('.erroraemail').removeClass('d-none');
            $('.erroraemail').html(`<small class="text-danger">${erroresresp.email}</small>`)
        } else {
            $('.erroraemail').addClass('d-none');
            $('.erroraemail').html('');
        }

        if (passwordexist) {
            $('.errorapassword').removeClass('d-none');
            $('.errorapassword').html(`<small class="text-danger">${erroresresp.password}</small>`)
        } else {
            $('.errorapassword').addClass('d-none');
            $('.errorapassword').html('');
        }

        if (passwordconfirmexist) {
            $('.errorapassword-confirm').removeClass('d-none');
            $('.errorapassword-confirm').html(`<small class="text-danger">${erroresresp.passwordconfirm}</small>`)
        } else {
            $('.errorapassword-confirm').addClass('d-none');
            $('.errorapassword-confirm').html('');
        }
    }
</script>
@endpush
