@extends('layouts.private.private', ['activePage' => 'tenis.index'])
@push('title', 'Editar Programa de Tenis')
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

        #imagenSeleccionada {
            border-radius: 20px;
        }
    </style>
@endpush
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tenis /</span> Editar Programa </h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row mb-3">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Formulario de registro</h5>
                    <small class="text-muted float-end">Editar Programa</small>
                </div>
                <div class="card-body mt-3">
                    <div class="container">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <form enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" value="{{$getProgram[0]->id}}" id="idPrograma">
                            <fieldset>
                                <h3> Paso 1: Datos del Programa</h3>
                                <div class="row">
                                    <div class="col-md">
                                        @role('ADMINISTRADOR')
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="respadmin">Responsable</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                                    <select class="selectpicker form-select" id="respadmin"
                                                            aria-label="respadmin" name="respadmin">
                                                        <option value="" selected disabled>SELECCIONA UN RESPONSABLE
                                                        </option>
                                                        @foreach ($responsables as $resp)
                                                            <option value="{{ $resp->id }}"
                                                                {{ $resp->id == auth()->user()->id ? 'selected' : '' }}>
                                                                {{ $resp->nombres }}
                                                                {{ $resp->apepaterno }} {{ $resp->apematerno }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger d-none responsableError" role="alert">
                                                <span class="msjResponsableError"></span>
                                            </span>
                                            </div>
                                        </div>
                                        @endrole
                                        @if ($responsable->tipocategoria_id == 3)
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label"
                                                       for="respnoadmin">Responsable</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group input-group-merge">
                                                <span id="respnoadmin2" class="input-group-text">
                                                    <i class="bx bx-buildings"></i>
                                                </span>
                                                        <input type="hidden" value="{{ $responsable->id }}"
                                                               id="respadmin">
                                                        <input type="text"
                                                               class="form-control ps-3 @error('respadmin') is-invalid @enderror"
                                                               aria-label="Nombre para el/la responsableNoAdmin"
                                                               aria-describedby="respnoadmin2" name="respnoadmin"
                                                               value="{{ $responsable->nombres }} {{ $responsable->apepaterno }} {{ $responsable->apematerno }}"
                                                               readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="categoria">Categoría</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                <span id="categoria2" class="input-group-text"><i
                                                        class="fa-light fa-list"></i></span>
                                                    <select class="form-select" id="categoria" aria-label="categoria"
                                                            name="categoria">
                                                        <option value="" selected disabled>SELECCIONA UNA CATEGORÍA
                                                        </option>
                                                        @foreach($subtiposervicio as $sts)
                                                            <option
                                                                value="{{$sts->id}}" {{ $sts->id == $getProgram[0]->categoria_id ? 'selected' : ''}}>
                                                                {{$sts->titulo}} - {{$sts->subtitulo}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger d-none categoriaError" role="alert">
                                                <span class="msjCategoriaError"></span>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="sede">Sede</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                <span id="sede2" class="input-group-text"><i
                                                        class="fa-regular fa-hotel"></i></span>
                                                    <select class="form-select" id="sede" aria-label="sede"
                                                            name="sede">
                                                        <option value="" selected disabled>SELECCIONA UNA SEDE
                                                        </option>
                                                        @foreach ($sedes as $sede)
                                                            <option
                                                                value="{{ $sede->id }}" {{ $sede->id == $getProgram[0]->sede_id ? 'selected':''}}>{{ $sede->descripcion }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger d-none sedeError" role="alert">
                                                <span class="msjSedeError"></span>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="lugar">Lugar</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                <span id="lugar2" class="input-group-text"><i
                                                        class="fa-regular fa-court-sport"></i></span>
                                                    <select class="form-select" id="lugar" aria-label="lugar"
                                                            name="lugar">
                                                        <option value="" selected disabled>SELECCIONA UN LUGAR
                                                        </option>
                                                        @foreach ($lugares as $lugar)
                                                            @if($lugar->sede_id == $getProgram[0]->sede_id)
                                                                @if (str_contains($lugar->descripcion,"CAMPO"))
                                                                    <option
                                                                        value="{{$lugar->id}}" {{ $lugar->id == $getProgram[0]->lugar_id ? 'selected' : '' }}>{{$lugar->descripcion}}</option>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger d-none lugarError" role="alert">
                                                <span class="msjLugarError"></span>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 d-none turnos">
                                            <label class="col-sm-3 col-form-label" for="turno">Turno</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge shadow-none">
                                                    <div
                                                        class="col-sm-12 d-flex justify-content-between contenedor-turnos">
                                                    </div>
                                                </div>
                                                <span class="text-danger d-none turnosError" role="alert">
                                                <span class="msjTurnosError"></span>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="fechaInicio">Inicio</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                    <input type="date" value="{{substr($getProgram[0]->inicio,0,10)}}"
                                                           id="fechaInicio"
                                                           class="form-control @error('fechaInicio') is-invalid @enderror"
                                                           aria-label="Fecha de inicio" name="fechaInicio"/>
                                                </div>
                                                <span class="text-danger d-none fechaInicioError" role="alert">
                                                <span class="msjFechaInicioError"></span>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="termino">Término</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                    <input type="date" value="{{substr($getProgram[0]->fin,0,10)}}"
                                                           id="termino"
                                                           class="form-control @error('termino') is-invalid @enderror"
                                                           name="termino"/>
                                                </div>
                                                <span class="text-danger d-none fechaFinError" role="alert">
                                                <span class="msjFechaFinError"></span>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="cupos">Cupos</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                <span id="cupos2" class="input-group-text"><i
                                                        class="fa-regular fa-input-numeric"></i></span>
                                                    <input type="number" value="{{$getProgram[0]->cupos}}" id="cupos"
                                                           class="form-control @error('cupos') is-invalid @enderror"
                                                           aria-label="Nombre para la cupos" aria-describedby="cupos2"
                                                           name="cupos"
                                                           oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                           maxlength="3"/>
                                                </div>
                                                <span class="text-danger d-none cuposError" role="alert">
                                                <span class="msjCuposError"></span>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 d-flex">
                                            <label class="col-sm-6 col-form-label" for="horas">
                                                Duración por actividad (en horas)
                                            </label>
                                            <div class="col-sm-6">
                                                <div class="input-group input-group-merge">
                                                <span id="horas2" class="input-group-text"><i
                                                        class="fa-regular fa-input-numeric"></i></span>
                                                    <input type="number" value="{{$getProgram[0]->duracion}}" id="horas"
                                                           class="form-control @error('descripcion') is-invalid @enderror"
                                                           oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                           name="horas" maxlength="3"/>
                                                </div>
                                                <span class="text-danger d-none definirHorarioError" role="alert">
                                                <span class="msjDefinirHorarioError"></span>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 form-label" for="publicado">Publicado</label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="publicado"
                                                           value="A"
                                                           id="SI" {{ $getProgram[0]->estado == 'A' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="si">
                                                        SI
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="publicado"
                                                           value="I"
                                                           id="NO" {{ $getProgram[0]->estado == 'I' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="no">
                                                        NO
                                                    </label>
                                                </div>
                                                <div class="form-text">Inidica el estado inicial para la nueva
                                                    actividad
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <!-- Basic Layout -->
                                        <div class="d-flex justify-content-center">
                                            <img class="img-fluid"
                                                 src="{{ asset('storage/subtipos/'.$getProgram[0]->imagen) }}"
                                                 id="imagenSeleccionada" style="max-height: 510px; height: 510px;">
                                        </div>
                                    </div>

                                </div>
                                <input type="button" class="next btn btn-primary btn-sm" value="Siguiente"/>
                            </fieldset>
                            <fieldset class="d-none">
                                <h3> Paso 2: Definición de Horarios</h3>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <div class="row mb-3">
                                            <div class="col-md-4 mb-3 d-flex justify-content-between">
                                                <label class="col-sm-3 col-form-label" for="dias">Día</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group input-group-merge">
                                                    <span class="input-group-text">
                                                        <i class="fa-regular fa-calendar-range"></i>
                                                    </span>
                                                        <select class="form-select" id="dias" aria-label="dias"
                                                                name="dias">
                                                            <option value="" selected disabled>DÍA</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 d-flex justify-content-between">
                                                <label class="col-sm-2 col-form-label" for="horaInicio">De</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                    <span id="horaInicio2" class="input-group-text">
                                                        <i class="fa-regular fa-clock-two"></i>
                                                    </span>
                                                        <input class="form-control horas" type="time"
                                                               aria-describedby="horaInicio2" name="horaInicio"
                                                               id="horaInicio"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 d-flex justify-content-between">
                                                <label class="col-sm-2 col-form-label" for="horaFin">A</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                    <span id="horaFin2" class="input-group-text">
                                                        <i class="fa-regular fa-clock-eight-thirty"></i>
                                                    </span>
                                                        <input class="form-control horas" type="time"
                                                               aria-describedby="horaFin" name="horaFin" id="horaFin"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 d-flex justify-content-end align-items-center">
                                                <button type="button" class="btn btn-sm btn-primary btn-add"
                                                        id="btn-add-hour">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                <span class="ms-2">
                                                Agregar día
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-5">
                                        <div class="card">
                                            <div class="table-responsive text-nowrap">
                                                @include('components.private.table', [
                                                'titleTable' => '',
                                                'searchable' => false,
                                                'paginate' => 0,
                                                ])
                                            </div>
                                        </div>
                                        <span class="text-danger d-none listaHorariosError" role="alert">
                                        <span class="msjListaHorariosError text-center"></span>
                                    </span>
                                    </div>
                                </div>
                                <input type="button" name="previous" class="previous btn btn-secondary btn-sm"
                                       value="Atrás"/>
                                <input type="button" class=" btn btn-primary btn-sm" value="Guardar y Continuar"
                                       id="guardarycontinuar"/>
                            </fieldset>
                            <!-- <fieldset class="d-none">
                                <div class="row"></div>
                            </fieldset> -->
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

        // Agregar cabecera a la tabla horarios
        const headerTable = $('#headertable');
        const bodyTable = $('#bodytable');
        const bodyTableScriptions = $("#tablainscripciones");

        $(document).ready(function () {
            obtenerHorario();
            obteneDiasHoras();

            // Días del select para la sección horarios
            const dias = ['LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO','DOMINGO'];

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
            var current = 1, current_step, next_step, steps;
            steps = $("fieldset").length;

            // Accionadores de botones siguiente y anterior
            $(".next").click(function () {
                current_step = $(this).parent();
                next_step = $(this).parent().next();
                next_step.show();
                current_step.hide();
                setProgressBar(++current);
                next_step.removeClass("d-none");
            });
            $(".previous").click(function () {
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

        function obtenerHorario() {
            let turno = "{{ $getProgram[0]->turno }}"
            let idActividad = 3;
            let idLugar = "{{$getProgram[0]->lugar_id}}";

            $.ajax({
                type: "GET",
                url: `/admin/nutricion/obtener/costo/${idActividad}/${idLugar}/lugar`,
                success: function (response) {
                    if (response != null) {
                        $(".contenedor-turnos").html("");
                        response.forEach(function (e) {
                            $(".contenedor-turnos").append(`
                                <div class="form-check">
                                    <input class="form-check-input turno-radio" type="radio" name="turno" value="${e.descripcion}" id="${e.descripcion}">
                                    <label class="form-check-label" for="${e.descripcion}">
                                        ${e.descripcion}
                                    </label>
                                </div>
                            `)
                            e.descripcion == turno ? $(".turno-radio").prop('checked', true) : '';
                        });
                        $('.turnos').removeClass('d-none');
                    }
                }
            });
        }

        function obteneDiasHoras() {
            let diashoras = @json($getDaysToProgram);

            bodyTable.html("");

            for (let i = 0; i < diashoras.length; i++) {
                const el = diashoras[i];

                totalHorarios.push({
                    "dia": el.dia,
                    "horainicio": el.horainicio,
                    "horafin": el.horafin
                });

                bodyTable.append(`
                        <tr>
                            <td>${el.dia}</td>
                            <td>${el.horainicio.slice(0, 5)} - ${el.horafin.slice(0, 5)}</td>
                            <td>
                                <button type='button' class='btn btn-sm btn-danger' onclick='removerElemento("${i}");'>
                                    <i class='fa-solid fa-ban'></i>
                                </button>
                            </td>
                        </tr>
                    `);
            }
        }

        // Obtener sede basada en lugares
        $("#sede").on('change', function () {
            let sedeId = $(this).val();
            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/${sedeId}/lugares`,
                success: function (data) {
                    let datatype = typeof (data);
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
                            if (e.descripcion.includes("CAMPO")) {
                                $("#lugar").append(`
                                    <option value="${e.id}">${e.descripcion}</option>
                                `);
                            }
                        });
                    }
                },
                error: function (err) {
                    $("#modalcomponent").modal('show');
                    $("#mcbody").html(err.responseJSON.message);
                }
            });
        });

        headerTable.append(`<tr><th>DÍAS</th><th>HORARIOS</th><th>QUITAR</th></tr>`);

        $("#btn-add-hour").on("click", function () {
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
                let idPrograma = $("#idPrograma").val();

                totalHorarios.push({
                    "dia": dia.val(),
                    "horainicio": horaInicio.val(),
                    "horafin": horaFin.val()
                });

                bodyTable.html("");

                $.ajax({
                    type: "GET",
                    url: `/admin/actividades/obtener/${idPrograma}/dias`,
                    success: function (response) {
                        for (let i = 0; i < response.length; i++) {
                            const el = response[i];

                            if (totalHorarios[i].dia != el.dia) {
                                totalHorarios.push({
                                    "dia": el.dia,
                                    "horainicio": el.horainicio,
                                    "horafin": el.horafin
                                });
                            }
                        }
                        for (let i = 0; i < totalHorarios.length; i++) {
                            const el = totalHorarios[i];

                            bodyTable.append(`
                                    <tr>
                                        <td>${el.dia}</td>
                                        <td>${el.horainicio.slice(0, 5)} - ${el.horafin.slice(0, 5)}</td>
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
            }
        });

        // funcion remover de tabla horarios
        function removerElemento(indice) {
            let data = {
                programaid : $("#idPrograma").val(),
                dia : totalHorarios[indice].dia,
                horainicio : `${totalHorarios[indice].horainicio.slice(0, 5)}:00`,
                horafin : `${totalHorarios[indice].horafin.slice(0, 5)}:00`
            }

            $.ajax({
                type: "POST",
                url: "{{route('tenis.remover.dia.programa')}}",
                data: data,
                success: function (response) {
                    if (totalHorarios.length > 0) {
                        for (let i = 0; i < totalHorarios.length; i++) {
                            const el = response[i];
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
                                    <td>${el.horainicio.slice(0, 5)} - ${el.horafin.slice(0, 5)}</td>
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
            });
        }

        // Obtener costo por lugar
        $("#lugar").on('change', function () {
            //let idActividad = $('#actividad').val();
            let idActividad = 3;
            let idLugar = $(this).val();

            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/costo/${idActividad}/${idLugar}/lugar`,
                success: function (response) {
                    if (response != null) {
                        $(".contenedor-turnos").html("");
                        response.forEach(function (e) {
                            $(".contenedor-turnos").append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="turno" value="${e.descripcion}" id="${e.descripcion}">
                                    <label class="form-check-label" for="${e.descripcion}">
                                        ${e.descripcion}
                                    </label>
                                </div>
                            `)
                        });
                        $('.turnos').removeClass('d-none');
                    }
                }
            });
        });

        // Obtener imagen de categoría
        $("#categoria").on('change', function () {
            let id = $(this).val();
            Swal.fire({
                icon: 'info',
                html: "Espere un momento porfavor ...",
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/imagen/${id}/categoria`,
                success: function (response) {

                    Swal.close();
                    if (response) {
                        let imagen = response.imagen;
                        $('#imagenSeleccionada').attr('src', "/storage/subtipos/" + imagen);
                    }
                }
            });
        });

        // Registrar la nueva actividad
        $("#guardarycontinuar").on('click', function (e) {
            // e.preventDefault();
            let responsable = $("#respadmin").val();
            let idPrograma = $("#idPrograma").val();
            let actividad = 3;
            let categoria = $("#categoria").val();
            let turnoIsChecked = $("input[name=turno]:checked ");
            let turno = turnoIsChecked.val();
            let sede = $("#sede").val();
            let lugar = $("#lugar").val();
            let fechaInicio = $("#fechaInicio").val();
            let termino = $("#termino").val();
            let cupos = $("#cupos").val();
            let publicadoIsChecked = $("input[name=publicado]:checked ");
            let publicado = publicadoIsChecked.val();
            let horasActividad = $("#horas").val();
            let fechasDefinidas = [];
            let data = {};

            // Rellenar tabla de turnos y horarios
            $("#tableComponent").find("tbody tr").each(function (idx, row) {
                var JsonData = {};
                JsonData.dias = $("td:eq(0)", row).text();
                JsonData.horarios = $("td:eq(1)", row).text();
                fechasDefinidas.push(JsonData);
            });

            console.log(fechasDefinidas);

            if (responsable == null) {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no seleccionaste ningún <br/><strong>Responsable</strong>,<br/> selecciona uno y luego continua',
                    'Verificar');
                $('.responsableError').removeClass('d-none');
                $('.msjResponsableError').html("Porfavor selecciona un responsable");
                return;
            } else {
                $('.responsableError').addClass('d-none');
            }

            if (actividad == null) {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no seleccionaste ninguna <br/><strong>Actividad</strong>,<br/> selecciona una y luego continua',
                    'Verificar');
                $('.actividadError').removeClass('d-none');
                $('.msjActividadError').html("Porfavor selecciona una actividad");
                return;
            } else {
                $('.actividadError').addClass('d-none');
            }

            if (categoria == null) {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no seleccionaste ninguna <br/><strong>Categoría</strong>,<br/> selecciona una y luego continua',
                    'Verificar');
                $('.categoriaError').removeClass('d-none');
                $('.msjCategoriaError').html('Porfavor selecciona una categoría');
                return;
            } else {
                $('.categoriaError').addClass('d-none');
            }

            if (sede == null) {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no seleccionaste ninguna <br/><strong>Sede</strong>,<br/> selecciona una y luego continua',
                    'Verificar');
                $('.sedeError').removeClass('d-none');
                $('.msjSedeError').html('Porfavor selecciona una sede');
                return;
            } else {
                $('.sedeError').addClass('d-none');
            }

            if (lugar == null) {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no seleccionaste ningún <br/><strong>Lugar</strong>,<br/> selecciona uno y luego continua',
                    'Verificar');
                $('.lugarError').removeClass('d-none');
                $('.msjLugarError').html('Porfavor selecciona un lugar');
                return;
            } else {
                $('.lugarError').addClass('d-none');
            }

            if (turnoIsChecked == false) {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no seleccionaste ningún <br/><strong>Turno</strong>,<br/> selecciona uno y luego continua',
                    'Verificar');
                $('.turnosError').removeClass('d-none');
                $('.msjTurnosError').html('Porfavor selecciona un turno');
                return;
            } else {
                $('.turnosError').addClass('d-none');
            }

            if (fechaInicio == "") {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no seleccionaste ninguna <br/><strong>Fecha de Inicio</strong>,<br/> selecciona una y luego continua',
                    'Verificar');
                $('.fechaInicioError').removeClass('d-none');
                $('.msjFechaInicioError').html('Porfavor selecciona una fecha de Inicio');
                return;
            } else {
                $('.fechaInicioError').addClass('d-none');
            }

            if (termino == "") {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no seleccionaste ninguna <br/><strong>Fecha de Termino</strong>,<br/> selecciona una y luego continua',
                    'Verificar');
                $('.fechaFinError').removeClass('d-none');
                $('.msjFechaFinError').html('Porfavor selecciona una fecha de termino');

                return;
            } else {
                $('.fechaFinError').addClass('d-none');
            }

            if (cupos == "") {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no ingresaste ninguna cantidad de <br/><strong>Cupos</strong>,<br/> indica la cantidad de cupos y luego continua',
                    'Verificar');
                $('.cuposError').removeClass('d-none');
                $('.msjCuposError').html('Porfavor Ingresa una cantidad de cupos');
                return;
            } else {
                $('.cuposError').addClass('d-none');
            }

            if (horasActividad == "") {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no indicaste la cantidad de <br/><strong>Horas</strong>,<br/> indica la cantidad de horas y luego continua',
                    'Verificar');
                $('.definirHorarioError').removeClass('d-none');
                $('.msjDefinirHorarioError').html('Porfavor Ingresa una cantidad de horas');
                return;
            } else {
                $('.definirHorarioError').addClass('d-none');
            }

            if (fechasDefinidas.length <= 0) {
                messagesInfo('Lo sentimos', 'warning',
                    'Parece que no indicaste <br/><strong>Fechas y Horas</strong>,<br/> para esta actividad, indicalas y luego continua',
                    'Verificar');
                $('.listaHorariosError').removeClass('d-none');
                $('.msjListaHorariosError').html('Porfavor define fechas y horas');
                return;
            } else {
                $('.listaHorariosError').addClass('d-none');
            }

            $.ajax({
                type: "POST",
                url: "{{ route('tenis.actualizar.actividad') }}",
                data: {
                    idPrograma,
                    responsable,
                    actividad,
                    categoria,
                    turno,
                    sede,
                    lugar,
                    fechaInicio,
                    termino,
                    cupos,
                    publicado,
                    horasActividad,
                    fechasDefinidas,
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'info',
                        html: "Espere un momento porfavor ...",
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    if (response.respRegistro === "exito") {
                        window.location.href = "/admin/actividades/lista";
                    } else {
                        messagesInfo('Lo sentimos', 'warning',
                            'Parece que algo sucedio, comunicate con el administrador',
                            'Entiendo');
                        // Swal.close();
                    }
                }
            });
        });

        function messagesInfo(title, icon, bodyMessage, confirmButton, textButton) {
            Swal.fire({
                title: `<strong>${title} <i class="fa-solid fa-face-scream"></i></strong>`,
                icon: `${icon}`,
                html: `<p>${bodyMessage}</p>`,
                showCloseButton: true,
                showCancelButton: `${confirmButton ?? false}`,
                focusConfirm: true,
                confirmButtonText: `${textButton}`,
            });
        }
    </script>
@endpush
