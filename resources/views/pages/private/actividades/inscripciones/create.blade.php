@extends('layouts.private.private', ['activePage' => 'inscripciones.create'])
@push('title', 'Nueva Inscripción')
@push('css')
<style>
    .btn-add {
        font-size: 20px !important;
        border-radius: 50%;
        height: 35px;
    }
</style>
@endpush
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Inscripciones /</span> Crear Nueva </h4>
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
                    <form enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-7">
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="actividades">Actividades</label>
                                        <select class="form-select" aria-label="Seleccionar actividad" id="actividad" name="actividad">
                                            <option value="" selected disabled>SELECCIONAR</option>
                                            @foreach ($actividades as $actividad)
                                            <option value="{{$actividad->servicios_id}}">{{$actividad->titulo}} / {{$actividad->subtitulo}} / PEN. {{$actividad->desde}}.00</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label" for="datos-inscripcion">Documento de
                                        identidad</label>
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-merge">
                                            <span id="datos-inscripcion2" class="input-group-text">
                                                <i class="fa-regular fa-address-card"></i>
                                            </span>
                                            <input type="number" id="documentomiembro" class="form-control @error('documentomiembro') is-invalid @enderror" aria-label="Nombre para los documentomiembro" aria-describedby="documentomiembro2" name="documentomiembro" />
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
                                            <input type="text" id="miembro" class="form-control ps-3 @error('descripcion') is-invalid @enderror" aria-describedby="miembro2" name="miembro" disabled required />
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
                                                <select class="form-select" id="diasInscripcion" aria-label="diasInscripcion" name="diasInscripcion" disabled>
                                                    <option value="" selected disabled>DÍAS</option>
                                                </select>
                                            </div>
                                            <span class="text-danger d-none diasError" role="alert">
                                                <span class="msjDiasError"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 d-flex justify-content-between">
                                        <label class="col-sm-4 col-form-label" for="horasInscripcion">Ingreso</label>
                                        <div class="col-sm-8">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">
                                                    <i class="fa-regular fa-calendar-range"></i>
                                                </span>
                                                <select class="form-select" id="horasInscripcion" aria-label="horasInscripcion" name="horasInscripcion" disabled>
                                                    <option value="" selected disabled>HORAS</option>
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
                                        <button type="button" class="btn btn-sm btn-primary btn-add" id="btn-add-hour" disabled>
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
                                    <div class="table-responsive text-nowrap">
                                        @include('components.private.table', [
                                        'titleTable' => '',
                                        'searchable' => false,
                                        'paginate' => 0,
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="button" class="btn btn-primary btn-sm" id="guardarRegistro" value="Inscribir" />
                        </div>
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

    // Cargar actividades al select Actividades
    $("#actividad").on('change', function() {
        var id = $(this).val();
        $.ajax({
            method: 'GET',
            url: `/admin/inscripciones/obtener/${id}/dias`,
            success: function(resp) {
                let data = resp;
                if(data.length > 0){
                    $("#diasInscripcion").html("");
                    $("#diasInscripcion").append(`<option value="" selected disabled>DÍAS</option>`);
                    data.forEach((e)=>{
                        $("#diasInscripcion").append(`
                        <option value="${e.dia}">${e.dia}</option>
                        `);
                    });
                }
            },
            error: function(err) {
                console.log(err)
            }
        });
    });

    // Agregar cabecera a la tabla horarios
    const headerTable = $('#headertable');
    // Referencia el cuerpo de la tabla
    const bodyTable = $('#bodytable');

    headerTable.append(`
                <tr>
                    <th>DÍA</th>
                    <th>HORA</th>
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

                    $('.miembroEncontrado').attr('d-none');
                }
            },
            error: function(err) {
                $("#modalcomponent").modal('show');
                $("#mcbody").html(err.responseJSON.message);
            }
        });
    });

    // quitaar el error de días y solicitar los horarios
    $("#diasInscripcion").on('change', function() {
        let idServicio = $("#actividad").val();
        let diaBuscar = $(this).val();
        $(".diasError").addClass("d-none");
        $.ajax({
            type: "GET",
            url: `/admin/inscripciones/obtener/${idServicio}/${diaBuscar}/horas`,
            success: function(data) {
                if (data) {
                    $("#horasInscripcion").removeAttr('disabled');
                    $("#horasInscripcion").html("");
                    $("#horasInscripcion").append(
                        '<option value="" selected disabled>HORAS</option>');
                    data.forEach((e) => {
                        $("#horasInscripcion").append(`
                            <option value="${e.horarios}">${e.horarios}</option>
                        `)
                    });
                }
            },
            error: function(err) {
                console.log(err)
            }
        });

    });

    // Cargar horarios basados en días
    $("#horasInscripcion").on('change', function() {
        $(".horasError").addClass("d-none");
        $("#btn-add-hour").removeAttr('disabled');
    });

    // agregar nuevo horario a la tabla
    $("#btn-add-hour").on("click", function() {
        const dia = $("#diasInscripcion");
        const hora = $("#horasInscripcion");

        for (let i = 0; i < totalHorarios.length; i++) {
            const el = totalHorarios[i];
            if (el.dia === dia.val()) {
                messagesInfo('<strong>Lo sentimos</strong>', 'warning',
                    `<p>El día <strong>${dia.val()}</strong> ya fue registrado, te sugerimos quitarlo y modificar el horario seleccionado</p>`,
                    `Entiendo`);
                return;
            }
        }

        if (dia.val() === '' || hora.val() === null) {
            messagesInfo('<strong>Lo sentimos</strong>', 'warning',
                `<p>Es obligatorio seleccionar un Día y una Hora</p>`, `Entiendo`)
        } else {
            totalHorarios.push({
                "dia": dia.val(),
                "hora": hora.val()
            });

            bodyTable.html("");

            for (let i = 0; i < totalHorarios.length; i++) {
                const el = totalHorarios[i];

                bodyTable.append(`
                        <tr>
                            <td>${el.dia}</td>
                            <td>${el.hora}</td>
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

    //
    $("#guardarRegistro").on("click", function() {
        const idservicio = $("#actividad").val();
        const idmiembro = $("#idMiembro").val();
        let fechasDefinidas = [];

        // Rellenar tabla de turnos y horarios
        $("#tableComponent").find("tbody tr").each(function(idx, row) {
            var JsonData = {};
            JsonData.dias = $("td:eq(0)", row).text();
            JsonData.horarios = $("td:eq(1)", row).text();
            fechasDefinidas.push(JsonData);
        });

        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            method: 'POST',
            url: "/admin/actividades/inscribir/miembro",
            data: {
                idservicio,
                idmiembro,
                fechasDefinidas
            },
            success: function(resp) {
                let data = resp;
                if (data.success == 'ok') {
                    window.location.href = "{{ route('inscripciones.index') }}";
                }
            },
            error: function(err) {
                console.log(err)
            }
        });
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
                            <td>${el.hora}</td>
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
