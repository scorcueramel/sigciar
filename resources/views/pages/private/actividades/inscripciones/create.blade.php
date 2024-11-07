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
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="row mb-5">
                                    <div class="col-sm-12 table-responsive">
                                        <table class="table border" id="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>TIPO SERVICIO</th>
                                                    <th>TITULO</th>
                                                    <th>SEDE</th>
                                                    <th>TURNO</th>
                                                    <th>INICIO</th>
                                                    <th>FIN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($actividades as $actividad)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input actividad" type="radio" name="actividadid" id="servid{{$actividad->id}}" data-id="{{$actividad->id}}">
                                                        </div>
                                                    </td>
                                                    <td><label for="servid{{$actividad->id}}">{{$actividad->tipo_servicio}}</label></td>
                                                    <td><label for="servid{{$actividad->id}}">{{$actividad->titulo}}</label></td>
                                                    <td><label for="servid{{$actividad->id}}">{{$actividad->sede}}</label></td>
                                                    <td><label for="servid{{$actividad->id}}">{{$actividad->turno}}</label></td>
                                                    <td><label for="servid{{$actividad->id}}">{{date("d/m/Y", strtotime($actividad->inicio))}}</label></td>
                                                    <td><label for="servid{{$actividad->id}}">{{date("d/m/Y", strtotime($actividad->fin))}}</label></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mb-3 d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label" for="datos-inscripcion">Documento de identidad</label>
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-merge">
                                            <span id="datos-inscripcion2" class="input-group-text">
                                                <i class="fa-regular fa-address-card"></i>
                                            </span>
                                            <input type="number" id="documentomiembro" class="form-control @error('documentomiembro') is-invalid @enderror" aria-label="Nombre para los documentomiembro" aria-describedby="documentomiembro2" name="documentomiembro" />
                                        </div>
                                        <span class="text-danger d-none miembroEncontrado" role="alert">
                                            <span class="msjMiembroEncontrado"></span>
                                        </span>
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
                                            <input type="text" id="miembro" class="form-control ps-3 @error('miembro') is-invalid @enderror" aria-describedby="miembro2" name="miembro" disabled required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 d-flex justify-content-between">
                                        <input type="hidden" id="idPrograma" value="">
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
                                <div class="col-sm-12 col-md-12 col-lg-12">
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
'tamanio'=>'md',
'title' => 'Verificar los datos...',
'withButtons' => true,
'cancelbutton' => true,
'mcTextCancelButton' => 'Cerrar',
])
@push('js')
<script>
    $(".actividad").on('click', function() {
        var id = $(this).attr('data-id');
        $("#idPrograma").val(id);
        $.ajax({
            method: 'GET',
            url: `/admin/inscripciones/obtener/${id}/dias`,
            success: function(resp) {
                let data = resp;
                if (data.length > 0) {
                    $("#diasInscripcion").html("");
                    $("#diasInscripcion").append(`<option value="" selected disabled>DÍAS</option>`);
                    data.forEach((e) => {
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

    // arreglo de horarios
    var totalHorarios = new Array();
    var horasInscripcion = new Array();

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
        if (documento == null || documento == '') {
            $('.miembroEncontrado').removeClass('d-none');
            $('.msjMiembroEncontrado').append('Debes ingresar un número de documento para realizar una inscripción');
        } else {
            $.ajax({
                type: "GET",
                url: `/admin/actividades/obtener/${documento}/miembro`,
                success: function(data) {
                    let datatype = typeof(data);
                    if (datatype === "string") {
                        $("#modalcomponent").modal('show');
                        $("#mcbody").html(`
                        <div class="row">
                            <div class="col-md-12">
                                <p>${data}.</p>
                                <p>De lo contrario puedes intentar registrnado al usuario dando click al botón a continuación <button class="btn btn-sm btn-primary" onclick="javascript:registrarNuevo()">Registrar</button></p>
                            </div>
                        </div>
                        `);
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
        }
    });

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
        $("#modalcomponent").modal('hide');
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
                Swal.close();
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
                            $("#documentomiembro").val(data.documento);
                        }
                    });
            },
            error: function(error) {
                Swal.close();
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

    // quitaar el error de días y solicitar los horarios
    $("#diasInscripcion").on('change', function() {
        let idServicio = $("#idPrograma").val();
        let diaBuscar = $(this).val();
        console.log(idServicio, diaBuscar);
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
        let documento = $("#documentomiembro").val();
        if (documento == null || documento == '') {
            $("#modalcomponent").modal('show');
            $("#mcbody").html('Debes ingresar un número de documento para continuar con la inscripción al programa de tenis');
        } else {
            const idservicio = $("#idPrograma").val();
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
                url: "{{route('inscripciones.store')}}",
                data: {
                    idservicio,
                    idmiembro,
                    fechasDefinidas
                },
                success: function(resp) {
                    let data = resp;
                    if (data.success == 'ok') {
                        Swal.fire({
                            title: "Inscripción exitosa",
                            position: "center",
                            icon: "success",
                            allowOutsideClick: false,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: "Continuar",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{route('inscripciones.index')}}"
                            }
                        });
                    }
                },
                error: function(err) {
                    console.log(err)
                }
            });
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
