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
            <div class="row">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Vista de lista</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Vista de calendario</button>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="text-nowrap table-responsive p-3">
                            <table class="table table-striped table-borderless table-hover nowrap" id="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ESTADO</th>
                                        <th>TIPO SERVICIO</th>
                                        <!-- <th>TÍTULO</th> -->
                                        <!-- <th>SUBTÍTULO</th> -->
                                        <th>SEDE</th>
                                        <th>DIRECCIÓN SEDE</th>
                                        <!-- <th>LUGAR DESCRIPCIÓN</th> -->
                                        <th>COSTO HORA</th>
                                        <th>INICIO</th>
                                        <th>FIN</th>
                                        <th>TURNO</th>
                                        <th>CAPACIDAD</th>
                                        <th>HORAS POR TURNO</th>
                                        <th>RESPONSABLE</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <div class="row p-3">
                            <div class="card p-2">
                                <div class="card-body">
                                    <div id='nutrition'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('components.private.modal', [
'tamanio'=>'modal-sm',
'withTitle' => true,
'withButtons' => true,
'cancelbutton' => true,
'mcTextCancelButton' => 'Cerrar',
])
@push('js')
<script>
    $(document).ready(() => {
        // Obtener datos para mostrar en la tabla (vista lista)
        $('#table').DataTable({
            paging: true,
            info: true,
            "order": [
                [0, "DESC"]
            ],
            responsive: true,
            autoWidth: false,
            processing: true,
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }],
            "pageLength": 10,
            "aLengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ],
            "ajax": "{{route('tabla.nutricion')}}",
            "columns": [{
                    data: 'id'
                },
                {
                    data: 'estado'
                },
                {
                    data: 'tipo_servicio'
                },
                {
                    data: 'sede'
                },
                {
                    data: 'direccion_sede'
                },

                {
                    data: 'lugar_costo_hora'
                },
                {
                    data: 'inicio'
                },
                {
                    data: 'fin'
                },
                {
                    data: 'turno'
                },
                {
                    data: 'capacidad'
                },
                {
                    data: 'hora'
                },
                {
                    data: 'responsable'
                },
                {
                    data: 'acciones'
                }
            ],
            "language": {
                "lengthMenu": "Mostrar " +
                    `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value='10'>10</option>
                            <option value='15'>15</option>
                            <option value='20'>20</option>
                            <option value='-1'>Todos</option>
                        </select>` +
                    " Registros Por Página",
                "zeroRecords": "Sin Resultados",
                "info": "Mostrando Página _PAGE_ de _PAGES_",
                "infoEmpty": "Sin Resultados",
                "infoFiltered": "(Filtro de _MAX_ Registros Totales)",
                "search": "Búscar ",
                "paginate": {
                    "next": "›",
                    "previous": "‹"
                }
            },
        });


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
            eventClick: function() {

            }
        });
        calendar.render();
    });

    function changeState(id) {
        var id = id;
        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        $.ajax({
            type: "POST",
            url: `/admin/actividades/change/state`,
            data: {
                id: id
            },
            success: function(response) {
                location.reload();
            }
        });
    }

    function showDetail(id) {
        $.ajax({
            method: 'GET',
            url: `/admin/nutricion/detalle/${id}/actividad`,
            success: function(resp) {
                let data = resp[0];
                $("#mcLabel").html(`
                        ${data.tipo_servicio} <br>
                    `)
                $("#mcbody").html(`
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        Responsable
                                    </td>
                                    <td>
                                        ${data.responsable}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Inicio
                                    </td>
                                    <td>
                                        ${new Date(data.inicio).toLocaleDateString("es-PE")}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Fin
                                    </td>
                                    <td>
                                        ${new Date(data.fin).toLocaleDateString("es-PE")}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Horas x Actividad
                                    </td>
                                    <td>
                                        ${data.hora} hrs.
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Cupos
                                    </td>
                                    <td>
                                        ${data.capacidad}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Costo
                                    </td>
                                    <td>
                                        S/. ${data.lugar_costo_hora}.00
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Lugar
                                    </td>
                                    <td>
                                        ${data.lugar_descripcion}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Dirección
                                    </td>
                                    <td>
                                        ${data.direccion_sede ?? 'SIN DIRECCION'}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sede
                                    </td>
                                    <td>
                                        ${data.sede ?? 'SIN SEDE'}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Estado
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill text-bg-secondary ${data.estado == 'A' ? 'bg-success' : 'bg-danger'}">${data.estado == 'A' ? 'PUBLICADO' : 'BORRADOR'}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    `);
            },
            error: function(err) {
                console.log(err)
            }
        });
    }

    function deleteNutricion(id) {
        var id = id;
        Swal.fire({
            title: "Eliminar Programa de Nutrición?",
            text: "Seguro de eliminar este programa",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si eliminar",
            cancelButtonText: "No eliminar",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'info',
                    html: "Espere un momento porfavor ...",
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    type: "POST",
                    url: `{{ route('nutricion.eliminar') }}`,
                    data: {
                        id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    }

    $(".cancelButton").on('click', function() {
        $("#mcbody").html('');
        $("#mcLabel").html('');
    });
</script>
@endpush
