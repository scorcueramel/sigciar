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
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Formulario de registro</h5>
                    <small class="text-muted float-end">Nueva Inscripción</small>
                </div>
                <div class="card-body mt-3">
                    <div class="container">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        <form enctype="multipart/form-data" class="row g-3 needs-validation"
                            novalidate>
                            <input type="hidden" value="{{$registro}}" id="idRegistro">
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
                                                <span class="text-danger d-none documentoMiembro" role="alert">
                                                    <span class="msjDocumentoMiembro"></span>
                                                </span>
                                            </div>
                                            <div class="col-sm-2 d-flex justify-content-end">
                                                <button type="button" class="btn btn-primary" id="buscarMiembro">
                                                    <i class="bx bx-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-12">
                                                <input type="hidden" id="idMiembro">
                                                <div class="input-group input-group-merge">
                                                    <span id="miembro2" class="input-group-text">
                                                        <i class="fa-regular fa-user-vneck"></i>
                                                    </span>
                                                    <input type="text" id="miembro"
                                                        class="form-control ps-3 @error('descripcion') is-invalid @enderror"
                                                        aria-describedby="miembro2" name="miembro" disabled required />
                                                </div>
                                            </div>
                                            <span class="text-danger d-none miembroEncontrado" role="alert">
                                                <span class="msjMiembroEncontrado"></span>
                                            </span>
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
                                                            @foreach($diasPorActividad as $dpa)
                                                                <option value="{{$dpa->dia}}">{{$dpa->dia}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <span class="text-danger d-none diasError" role="alert">
                                                        <span class="msjDiasError"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3 d-flex justify-content-between">
                                                <label class="col-sm-4 col-form-label"
                                                    for="horasInscripcion">Ingreso</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text">
                                                            <i class="fa-regular fa-calendar-range"></i>
                                                        </span>
                                                        <select class="form-select" id="horasInscripcion" aria-label="horasInscripcion"
                                                            name="horasInscripcion" disabled>
                                                            <option value="" selected disabled>HORARIOS</option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger d-none horasError" role="alert">
                                                        <span class="msjHorasError"></span>
                                                    </span>
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
                                        <div class="card ">
                                            <div class="card-body">
                                                <div class="table-responsive text-nowrap">
                                                    @include('components.private.table', [
                                                        'titleTable' => '',
                                                        'paginate' => 0,
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="button" name="submit" class="btn btn-primary btn-sm" id="guardarRegistro" value="Guardar"/>
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
            // control de pasos
            var current = 1;
            steps = $("fieldset").length;

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
                        $("#miembro").val("");
                    } else {
                        let nombres = `${data[0].nombres} ${data[0].apepaterno} ${data[0].apematerno}`;
                        $("#idMiembro").val(data[0].id);
                        $("#miembro").val(nombres.toString());
                        $("#diasInscripcion").removeAttr("disabled");
                        $("#ingreso").removeAttr("disabled");
                        $("#btn-add-horario").removeAttr("disabled");
                        $('.miembroEncontrado').attr('d-none');
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
            const documento = $("#documentomiembro");
            const nombreMiembro = $("#miembro");
            const idMiembro = $("#idMiembro").val();
            const diasInscripcion = $("#diasInscripcion");
            const horasInscripcion = $("#horasInscripcion");
            const ingreso = $("#ingreso");

            if(documento.val() === ''){
                messagesInfo('<strong>Lo sentimos <i class="fa-solid fa-face-scream"></i></strong>', 'warning', `<p>Debes rellenar el campo documentos de indentidad</p>`, 'Entiendo')
                $('.documentoMiembro').removeClass('d-none');
                $('.msjDocumentoMiembro').html("Porfavor selecciona un responsable");
                return;
            }
            else{
                $('.documentoMiembro').attr('d-none');
            }

            if(nombreMiembro.val() === ''){
                messagesInfo('<strong>Lo sentimos <i class="fa-solid fa-face-scream"></i></strong>', 'warning', `<p>Debes encontrar un miembro para registrarlo en la tabla</p>`, 'Entiendo')
                $('.miembroEncontrado').removeClass('d-none');
                $('.msjMiembroEncontrado').html("Porfavor selecciona un mimembro a quien asignar la actividad");
                return;
            }
            else{
                $('.miembroEncontrado').attr('d-none');
            }

            if(diasInscripcion.val() === null){
                messagesInfo('<strong>Lo sentimos <i class="fa-solid fa-face-scream"></i></strong>', 'warning', `<p>Debes seleccionar un día para poder continuar con el registro</p>`, 'Entiendo')
                $('.diasError').removeClass('d-none');
                $('.msjDiasError').html("Porfavor selecciona un día");
                return;
            }
            else{
                $('.diasError').attr('d-none');
            }

            if(horasInscripcion.val() === null){
                messagesInfo('<strong>Lo sentimos <i class="fa-solid fa-face-scream"></i></strong>', 'warning', `<p>Debes seleccionar un horario para poder continuar con el registro</p>`, 'Entiendo')
                $('.horasError').removeClass('d-none');
                $('.msjHorasError').html("Porfavor selecciona un horario");
                return;
            }
            else{
                $('.horasError').attr('d-none');
            }

            if (documento.val() === '' || nombreMiembro.val() === '' || diasInscripcion.val() === ''|| diasInscripcion.val() === '' || idMiembro === '') {

            }
            else {
                horasInscripcion.push({
                    "documento": documento.val(),
                    "nombreMiembro": nombreMiembro.val(),
                    "diasInscripcion": diasInscripcion,
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

        // quitaar el error de días y solicitar los horarios
        $("#diasInscripcion").on('change',function(){
            let idRegistro = $("#idRegistro").val();
            let diaBuscar = $(this).val();
            $(".diasError").addClass("d-none");
            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/${idRegistro}/${diaBuscar}/horas`,
                success: function(data) {
                },
                error: function(err) {
                }
            });

        });// quitaar el error de horas
        $("#horasInscripcion").on('change',function(){
            $(".horasError").addClass("d-none");
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
        // funcoin de mensaje
        function messagesInfo(title, icon, bodyMessage, textButton) {
            Swal.fire({
                title: `<strong>${title} <i class="fa-solid fa-face-scream"></i></strong>`,
                icon: `${icon}`,
                html: `<p>${bodyMessage}</p>`,
                showCloseButton: true,
                focusConfirm: true,
                confirmButtonText: `${textButton}`,
            });
        }
    </script>
@endpush
