@extends('layouts.private.private', ['activePage' => 'tenis.create'])
@push('title', 'Nueva Sede')
@push('css')
    <style>
        #regiration_form fieldset:not(:first-of-type) {
            display: none;
        }

        .btn-add {
            font-size: 20px !important;
            border-radius: 50%;
            height: 35px;
        }
    </style>
@endpush
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tenis /</span> Crear Nueva </h4>
    <!-- Basic Layout & Basic with Icons -->

    <div class="row mb-3">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            {{-- Alerta validacion --}}
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show mb-2" role="alert">
                    <strong>¡Algo no anda bien! </strong> por favor, revisa que todos los campos esten correctamente
                    llenados y vuelve a intentar
                    @foreach ($errors->all() as $error)
                        <span class="badge badge-danger">{{ $error }}</span>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Formulario de registro</h5>
                    <small class="text-muted float-end">Nueva Actividad</small>
                </div>
                <div class="card-body mt-3">
                    <div class="container">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        <form enctype="multipart/form-data" class="row g-3 needs-validation" id="guardarActividad"
                            novalidate>
                            <fieldset >
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h3> Paso 3: Inscripciones</h3>
                                    </div>
                                    <div class="col-sm">
                                        <small class="text-danger" style="font-size: 15px">(Este paso es
                                            opcional)</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-sm col-md-6 col-lg-6">
                                                <button type="button" class="btn btn-sm btn-warning">6 Cupos Disponibles
                                                    <i class="fa-solid fa-rotate-reverse"></i></button>
                                            </div>
                                            <div class="col-sm col-md-6 col-lg-6 d-flex justify-content-end">
                                                <button type="button" class="btn btn-sm btn-success" disabled>Agregar
                                                    Inscripciones
                                                    <i class="fa-solid fa-circle-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12 my-4 table-responsive">
                                        <table class="table table-bordered table-striped" id="tabladisponibilidad">
                                            <thead>
                                                <tr>
                                                    <th>DNI</th>
                                                    <th>APILLODOS Y NOMBRES</th>
                                                    <th>HORARIO</th>
                                                    <th>PAGO</th>
                                                    <th>ESTADO</th>
                                                    <th>ESTADO PÁGO</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <div class="row mb-3 d-flex align-items-center">
                                            <label class="col-sm-4 col-form-label" for="datos-inscripcion">Documento de
                                                identidad</label>
                                            <div class="col-sm-6">
                                                <div class="input-group input-group-merge">
                                                    <span id="datos-inscripcion2" class="input-group-text">
                                                        <i class="fa-regular fa-address-card"></i>
                                                    </span>
                                                    <input type="number" id="documentomiembro"
                                                        class="form-control @error('documentomiembro') is-invalid @enderror"
                                                        aria-label="Nombre para los documentomiembro"
                                                        aria-describedby="documentomiembro2" name="documentomiembro" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2 d-flex justify-content-end">
                                                <button type="button" class="btn btn-primary" id="buscarMiembro">
                                                    <i class="bx bx-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-12">
                                                <div class="input-group input-group-merge">
                                                    <span id="miembro2" class="input-group-text">
                                                        <i class="fa-regular fa-user-vneck"></i>
                                                    </span>
                                                    <input type="hidden" name="idmiembro" id="idmiembro">
                                                    <input type="text" id="miembro"
                                                        class="form-control ps-3 @error('descripcion') is-invalid @enderror"
                                                        aria-describedby="miembro2" name="miembro" disabled required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 d-flex justify-content-between">
                                                <label class="col-sm-2 col-form-label" for="diasInscripcion">Días</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text">
                                                            <i class="fa-regular fa-calendar-range"></i>
                                                        </span>
                                                        <select class="form-select" id="diasInscripcion"
                                                            aria-label="diasInscripcion" name="diasInscripcion" disabled>
                                                            <option value="" selected disabled>DÍAS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3 d-flex justify-content-between">
                                                <label class="col-sm-4 col-form-label"
                                                    for="diasInscripcion">Ingreso</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text">
                                                            <i class="fa-regular fa-calendar-range"></i>
                                                        </span>
                                                        <select class="form-select" id="ingreso" aria-label="ingreso"
                                                            name="ingreso" disabled>
                                                            <option value="" selected disabled>HORARIOS</option>
                                                            <option value="16:00">16:00</option>
                                                            <option value="17:00">17:00</option>
                                                            <option value="18:00">18:00</option>
                                                            <option value="19:00">19:00</option>
                                                            <option value="20:00">20:00</option>
                                                        </select>
                                                        @error('descripcion')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 d-flex justify-content-end align-items-center">
                                                <button type="button" class="btn btn-sm btn-primary btn-add"
                                                    id="btn-add-horario" disabled>
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                <span class="ms-2">
                                                    Agregar horario
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-5">
                                        <div class="card pt-2">
                                            <div class="card-body">
                                                <div
                                                    class="text-nowrap table-responsive-sm table-responsive-md table-responsive-lg">
                                                    <table class="table table-striped table-borderless">
                                                        <thead>
                                                            <tr>
                                                                <th>DIA</th>
                                                                <th>HORARIO</th>
                                                                <th>QUITAR</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-border-bottom-0" id="tablainscripciones">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="submit" class="next submit btn btn-primary btn-sm" value="Guardar"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('components.private.modal', [
    'withTitle' => true,
    'title' => 'Verificar los datos...',
    'withButtons' => true,
    'cancelbutton' => true,
    'mcTextCancelButton' => 'Cerrar',
])
@push('js')
    <script>
        // arreglo de horarios
        var totalHorarios = new Array();
        var horasInscripcion = new Array();
        $(document).ready(function() {
            // Días del select para la sección horarios
            const dias = [
                'LUNES',
                'MARTES',
                'MIÉRCOLES',
                'JUEVES',
                'VIERNES',
                'SÁBADO',
                'DOMINGO'
            ];

            let valores = Object.values(dias);
            // Días del select para las sección de horarios
            for (let i = 0; i < valores.length; i++) {
                $("#dias").append(`
                    <option value="${valores[i]}">${valores[i]}</option>
                `);
            }
            // Días del select para la sección inscripciones
            for (let i = 0; i < valores.length; i++) {
                $("#diasInscripcion").append(`
                    <option value="${valores[i]}">${valores[i]}</option>
                `);
            }

            // control de pasos
            var current = 1,
                current_step, next_step, steps;
            steps = $("fieldset").length;

            // Accionadores de botones siguiente y anterior
            $(".next").click(function() {
                current_step = $(this).parent();
                next_step = $(this).parent().next();
                next_step.show();
                current_step.hide();
                setProgressBar(++current);
                next_step.removeClass("d-none");
            });
            $(".previous").click(function() {
                current_step = $(this).parent();
                next_step = $(this).parent().prev();
                next_step.show();
                current_step.hide();
                setProgressBar(--current);
            });
            setProgressBar(current);

            // Acción de cambio de la barra de progreso para el formulario
            function setProgressBar(curStep) {
                var percent = parseFloat(100 / steps) * curStep;
                percent = percent.toFixed();
                $(".progress-bar")
                    .css("width", percent + "%")
                    .html(percent + "%");
            }
        });

        // Obtener categorias basads en actividad
        $("#actividad").on('change', function() {
            let actividadId = $(this).val();
            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/${actividadId}/subcategorias`,
                success: function(data) {
                    let datatype = typeof(data);
                    let defaultOptionCategory = $("#categoria");
                    if (datatype === "string") {
                        $("#modalcomponent").modal('show');
                        $("#mcbody").html(data);
                        $("#categoria").html("");
                        defaultOptionCategory.append(
                            "<option selected disabled>SELECCIONA UNA CATEGORÍA</option>");
                        $("#categoria").attr("disabled", "disabled");
                    } else {
                        $("#categoria").removeAttr("disabled");
                        $("#categoria").html("");
                        defaultOptionCategory.append(
                            "<option selected disabled>SELECCIONA UNA CATEGORÍA</option>");
                        data.forEach((e) => {
                            $("#categoria").append(`
                                    <option value="${e.id}">${e.titulo}-${e.subtitulo}</option>
                                `);
                        });
                    }
                },
                error: function(err) {
                    $("#modalcomponent").modal('show');
                    $("#mcbody").html(err.responseJSON.message);
                }
            });
        });

        // Obtener sede basada en lugares
        $("#sede").on('change', function() {
            let sedeId = $(this).val();
            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/${sedeId}/lugares`,
                success: function(data) {
                    let datatype = typeof(data);
                    let defaultOptionCategory = $("#lugar");
                    if (datatype === "string") {
                        $("#modalcomponent").modal('show');
                        $("#mcbody").html(data);
                        $("#lugar").html("");
                        defaultOptionCategory.append(
                            "<option selected disabled>SELECCIONA UN LUGAR</option>");
                        $("#lugar").attr("disabled", "disabled");
                    } else {
                        $("#lugar").removeAttr("disabled");
                        $("#lugar").html("");
                        defaultOptionCategory.append(
                            "<option selected disabled>SELECCIONA UN LUGAR</option>");
                        data.forEach((e) => {
                            $("#lugar").append(`
                                    <option value="${e.id}">${e.descripcion}</option>
                                `);
                        });
                    }
                },
                error: function(err) {
                    $("#modalcomponent").modal('show');
                    $("#mcbody").html(err.responseJSON.message);
                }
            });
        });

        // Agregar cabecera a la tabla horarios
        const headerTable = $('#headertable');
        const bodyTable = $('#bodytable');
        const bodyTableScriptions = $("#tablainscripciones");

        headerTable.append(`
                <tr>
                    <th>DÍAS</th>
                    <th>HORARIOS</th>
                    <th>QUITAR</th>
                </tr>
            `);

        // Click en boton quitar
        $("#btn-add-hour").on("click", function() {
            const dia = $("#dias");
            const duracion = $("#horas");
            const horaInicio = $("#horaInicio");
            const horaFin = $("#horaFin");

            if (duracion.val() === '' || dia.val() === null || horaInicio.val() === '' || horaFin.val() === '') {
                Swal.fire({
                    title: '<strong>Lo sentimos <i class="fa-solid fa-face-scream"></i></strong>',
                    icon: "warning",
                    html: `<p>Debes rellenar todos los campos para agregarlo a la tabla</p>`,
                    showCloseButton: true,
                    focusConfirm: true,
                    confirmButtonText: `Entiendo`,
                }).then((resp) => {
                    duracion.focus();
                });
            } else {
                totalHorarios.push({
                    "dia": dia.val(),
                    "horainicio": horaInicio.val(),
                    "horafin": horaFin.val()
                });
                bodyTable.html("");

                for (let i = 0; i < totalHorarios.length; i++) {
                    const el = totalHorarios[i];
                    bodyTable.append(`
                        <tr>
                            <td>${el.dia}</td>
                            <td>${el.horainicio} - ${el.horafin}</td>
                            <td>
                                <button type='button' class='btn btn-sm btn-danger' onclick='removerElemento("${i}");'>
                                    <i class='fa-solid fa-ban'></i>
                                </button>
                            </td>
                        </tr>
                    `);
                }
            }
        });

        // funcion remover de tabla horarios
        function removerElemento(indice) {
            if (totalHorarios.length > 0) {
                for (let i = 0; i < totalHorarios.length; i++) {
                    const el = totalHorarios[i];
                    if (i == indice) {
                        totalHorarios.splice(indice, 1);
                    }
                }
                bodyTable.html("");
                for (let i = 0; i < totalHorarios.length; i++) {
                    const el = totalHorarios[i];
                    bodyTable.append(`
                        <tr>
                            <td>${el.dia}</td>
                            <td>${el.horainicio} - ${el.horafin}</td>
                            <td>
                                <button type='button' class='btn btn-sm btn-danger' onclick='removerElemento("${i}");'>
                                    <i class='fa-solid fa-ban'></i>
                                </button>
                            </td>
                        </tr>
                    `);
                }
            }

        }

        // buscar al miembro o usuario registrado en sistema
        $("#buscarMiembro").on('click', function() {
            let documento = $("#documentomiembro").val();
            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/${documento}/miembro`,
                success: function(data) {
                    let datatype = typeof(data);
                    if (datatype === "string") {
                        $("#modalcomponent").modal('show');
                        $("#mcbody").html(data);
                    } else {
                        let nombres = `${data[0].nombres} ${data[0].apepaterno} ${data[0].apematerno}`;
                        $("#idmiembro").val(data[0].id);
                        $("#miembro").val(nombres.toString());
                        $("#diasInscripcion").removeAttr("disabled");
                        $("#ingreso").removeAttr("disabled");
                        $("#btn-add-horario").removeAttr("disabled");
                    }
                },
                error: function(err) {
                    $("#modalcomponent").modal('show');
                    $("#mcbody").html(err.responseJSON.message);
                }
            });
        });

        // agregar horario del miembro inscrito
        $("#btn-add-horario").on('click', function() {
            const diasInscripcion = $("#diasInscripcion");
            const miembro = $("#miembro");
            const idMiembro = $("#idmiembro").val();
            const ingreso = $("#ingreso");

            if (miembro.val() === null || diasInscripcion.val() === null || ingreso.val() === null || idMiembro ===
                null) {
                Swal.fire({
                    title: '<strong>Lo sentimos <i class="fa-solid fa-face-scream"></i></strong>',
                    icon: "warning",
                    html: `<p>Debes rellenar todos los campos para agregarlo a la tabla</p>`,
                    showCloseButton: true,
                    focusConfirm: true,
                    confirmButtonText: `Entiendo`,
                });
            } else {
                horasInscripcion.push({
                    "diasInscripcion": diasInscripcion.val(),
                    "miembro": miembro.val(),
                    "idMiembro": idMiembro,
                    "ingreso": ingreso.val(),
                });

                bodyTableScriptions.html("");

                for (let i = 0; i < horasInscripcion.length; i++) {
                    const el = horasInscripcion[i];
                    bodyTableScriptions.append(`
                        <tr>
                            <td>${el.diasInscripcion}</td>
                            <td>${el.ingreso}</td>
                            <td>
                                <button type='button' class='btn btn-sm btn-danger' onclick='removerElementoInscrito("${i}");'>
                                    <i class='fa-solid fa-ban'></i>
                                </button>
                            </td>
                        </tr>
                    `);
                }
            }
        });

        // funcion remover de tabla inscripciones
        function removerElementoInscrito(indice) {
            if (horasInscripcion.length > 0) {
                for (let i = 0; i < horasInscripcion.length; i++) {
                    if (i == indice) {
                        horasInscripcion.splice(indice, 1);
                    }
                }
                bodyTableScriptions.html("");

                for (let i = 0; i < horasInscripcion.length; i++) {
                    const el = horasInscripcion[i];
                    bodyTableScriptions.append(`
                        <tr>
                            <td>${el.diasInscripcion}</td>
                            <td>${el.ingreso}</td>
                            <td>
                                <button type='button' class='btn btn-sm btn-danger' onclick='removerElementoInscrito("${i}");'>
                                    <i class='fa-solid fa-ban'></i>
                                </button>
                            </td>
                        </tr>
                    `);
                }
            }

        }

        // Obtener costo por lugar
        $("#lugar").on('change', function() {
            let idActividad = $('#actividad').val();
            let idLugar = $(this).val();
            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/consto/${idActividad}/${idLugar}/lugar`,
                success: function(response) {
                    if (response != null) {
                        $("#contenedor-turnos").html("");
                        response.forEach(function(e) {
                            console.log(e)
                            $(".contenedor-turnos").append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="${e.id}" id="${e.descripcion}" name="turnos[]"/>
                                    <label class="form-check-label" for="${e.descripcion}"> ${e.descripcion}</label>
                                </div>
                            `)
                        });
                        $('.turnos').removeClass('d-none');
                    }
                }
            });
        });

        // Registrar la nueva actividad
        $("#guardarActividad").on('submit', function(e) {
            e.preventDefault();
            let respadmin = $("#respadmin").val();
            let respnoadmin = $("#respnoadmin").val();
            let actividad = $("#actividad").val();
            let categoria = $("#categoria").val();
            let diurno = $('#DIURNO').val();
            let nocturno = $('#NOCTURNO').val();
            let sede = $("#sede").val();
            let lugar = $("#lugar").val();
            let fechaInicio = $("#fechaInicio").val();
            let termino = $("#termino").val();
            let cupos = $("#cupos").val();
            let publicado = $("#publicado").val();
            let horasActividad = $("#horas").val();
            let fechasDefinidas = [];
            let data = {};

            $("#tableComponent").find("tbody tr").each(function(idx, row) {
                var JsonData = {};
                JsonData.dias = $("td:eq(0)", row).text();
                JsonData.horarios = $("td:eq(1)", row).text();
                fechasDefinidas.push(JsonData);
            });

            $.ajax({
                type: "POST",
                url: "{{ route('nueva.actividad') }}",
                data: {
                    respadmin,
                    respnoadmin,
                    actividad,
                    categoria,
                    diurno,
                    nocturno,
                    sede,
                    lugar,
                    fechaInicio,
                    termino,
                    cupos,
                    publicado,
                    horasActividad,
                    fechasDefinidas,
                },
                success: function(response) {
                    console.log(response)
                }
            });
        });
    </script>
@endpush
