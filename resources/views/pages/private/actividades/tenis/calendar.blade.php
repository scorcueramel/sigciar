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
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Inscritos /</span> Todas </h4>
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
@include('components.private.notas-modal')
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
            initialView: 'dayGridMonth',
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
                                    <button class="btn btn-sm btn-primary" id="nuevanota" onclick="notaModal('${info.event.title}',${info.event.extendedProps.servicioinscripcion_id})">Nueva Nota</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ver Notas</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" id="vernotas" onclick="verNotas('${info.event.title}',${info.event.extendedProps.servicioinscripcion_id})">Ver Notas</button>
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
            url: `/admin/actividades/obtener/${servicioinscripcion}/notas`,
            success: function(response) {
                $("#modalnotabody").html("");
                if (response.length > 0) {
                    for (let index = 0; index < response.length; index++) {
                        const element = response[index];
                        $("#modalnotabody").append(`
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse${index}" aria-expanded="false" aria-controls="flush-collapse${index}">
                                    Nota #${index+1}
                                </button>
                                </h2>
                                <div id="flush-collapse${index}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        ${element.detalle}
                                        </div>
                                    </div>
                                </div>
                        </div>
                        `);
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

    $("#cancelarenvio").on('click', function() {
        $("#nota-miembro").val("");
        $("#enlace-miemrbo").val("");
    });
</script>
@endpush
