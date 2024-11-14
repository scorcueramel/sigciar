@extends('layouts.public.landing')
@push('title', 'Inscripcion a programa')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        #btn-add-hour:hover {
            background: #27326F !important;
            color: #FFF000 !important;
        }
    </style>
@endpush
@section('content')
    @include('components.public.header',['sedes'=>"/ciar/#sedes"])
    <section class="banner esInterna position-relative">
        <div class="container padding position-relative">
            <div class="row justify-content-center justify-content-md-start position-relative">
                <div class="col-11 col-md-12 col-xl-12 text-center">
                    <div class="padding2"></div>
                    <h2 class="titulo altas fw-bold mb-3 mb-lg-4">Inscribete al programa</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="programas-tipo padding interna bgLightblue">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-11 col-md-5 text-start ps-5">
                    <h2 class="titulo mainColor fw-bold mb-1">{{$programaResponse[0]->titulo}}</h2>
                    <p class="edades mainColor">{{$programaResponse[0]->subtitulo}}</p>

                    <p>Optimiza tu bienestar con los informes de optimización epigenética, diseñados para ofrecer
                        información precisa sobre tus necesidades nutricionales, factores externos, y estado de tus
                        sistemas metabólicos.</p>
                    <ul class="beneficios">
                        <li>Agrupamos de acuerdo al nivel</li>
                        <li>Clases de una (1) hora</li>
                        <li>8 cupos disponibles</li>
                    </ul>
                    {{--                    <h3 class="mainColor fw-bold altas">Horario</h3>
                                        @foreach($programaResponse as $pr)
                                            <h6 style="font-weight: bold">{{Str::of($pr->horario)->explode('|')[1]}}</h6>
                                        @endforeach--}}
                </div>
                <div class="col-11 col-md-5 px-5">
                    <img src="{{asset('storage/subtipos/'.$programaResponse[0]->imagen)}}" class="w-100"/>
                </div>

            </div>
        </div>
    </section>
    @guest
        <section class="programas-tipo padding interna">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-11 col-md-10 text-start ps-5">
                        <h5 class="mainColor fw-bold altas">Primero debes iniciar sesión para inscribirte en un
                            programa, si no cuentas con un usuario registrate en unos sencillos pasos.</h5>

                        <button class="btn-cta altas mt-3" id="iniciasesion">
                            <img src="{{asset('assets/images/arrow-bt.svg')}}" class="icon me-2 me-lg-1"/> Inicia Sesión
                            Aquí
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @else
        @php
        $idMiembro = App\Models\Persona::where('usuario_id',Auth::id())->select('personas.id')->get()[0];
        @endphp
        <input type="hidden" id="idPrograma" value="{{$programaResponse[0]->servicios_id}}">
        <input type="hidden" id="idMiembro" value="{{$idMiembro->id}}">
        <input type="hidden" id="inscripcionPublica" value="1">

        <section class="programas-tipo padding interna">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-11 col-md-10 text-start ps-5">
                        <h3 class="mainColor fw-bold altas">Seleccione el campo a inscribirse:</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cancha</th>
                                    <th>Horario</th>
                                    <th>Costo por hora</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($programaResponse as $pr)
                                    <tr>
                                        <td><input class="actividad" type="radio" name="actividadid"
                                                   id="servid{{$pr->servicios_id}}" data-id="{{$pr->servicios_id}}"
                                                   data-precio="{{$pr->costohora}}">
                                        </td>
                                        <td><label for="servid{{$pr->servicios_id}}">{{$pr->descripcion}}</label></td>
                                        <td><label
                                                for="servid{{$pr->servicios_id}}">{{Str::of($pr->horario)->explode('|')[1]}}</label>
                                        </td>
                                        <td><label for="servid{{$pr->servicios_id}}">S/. {{$pr->costohora}}.00</label>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mb-3 d-flex justify-content-between">
                            <div class="col-md-5 mb-3 d-flex justify-content-between">
                                <input type="hidden" id="idPrograma" value="">
                                <label class="col-sm-2 col-form-label" for="diasInscripcion">Días</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <select class="form-control" id="diasInscripcion" aria-label="diasInscripcion"
                                                name="diasInscripcion" disabled>
                                            <option value="" selected disabled>DÍAS</option>
                                        </select>
                                    </div>
                                    <span class="text-danger d-none diasError" role="alert">
                                        <span class="msjDiasError"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3 d-flex justify-content-between">
                                <label class="col-sm-4 col-form-label" for="horasInscripcion">Ingreso</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <select class="form-control" id="horasInscripcion" aria-label="horasInscripcion"
                                                name="horasInscripcion" disabled>
                                            <option value="" selected disabled>HORAS</option>
                                        </select>
                                    </div>
                                    <span class="text-danger d-none horasError" role="alert">
                                        <span class="msjHorasError"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3 d-flex justify-content-end" style="margin-top: -55px">
                                <button type="button" class="btn-cta altas mt-5 text-center" id="btn-add-hour"
                                        style="font-size: 12px;width: 65px" disabled>
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3 d-flex justify-content-between">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="table-responsive text-nowrap">
                                    @include('components.public.table', [
                                    'titleTable' => '',
                                    'searchable' => false,
                                    'paginate' => 0,
                                    ])
                                </div>
                            </div>
                        </div>

                        <h3 class="mainColor fw-bold altas mt-3 totalPagar">Total a pagar: S/<span
                                class="total"> 0.00</span></h3>
                        <button type="button" class="btn-cta altas mt-5" id="guardarRegistro" >
                            <img src="{{asset('assets/images/arrow-bt.svg')}}" class="icon me-2 me-lg-1"/> Inscríbete
                            aquí
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endguest
    @include('components.public.footer')
    @include('components.public.fixed')
    @include('components.public.modal',['titulo'=>false,'botones'=>false])

@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var montoHora = 0;
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

        $("#iniciasesion").on('click', function () {
            $("#modal").modal('show');
            $(".modal_cuerpo").html('');
            $(".modal_cuerpo").append(`
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-member" data-toggle="tab" data-target="#loginmember" type="button" role="tab" aria-controls="loginmember" aria-selected="true">Login Miembros</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-member" data-toggle="tab" data-target="#registermember" type="button" role="tab" aria-controls="registermember" aria-selected="false">Registrate</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="loginmember" role="tabpanel" aria-labelledby="login-member">
                            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h3>Inicio de Sesión para Miembros</h3>
                    <form action="{{ route('login.member') }}" method="post" autocomplete="off" id="login">
                        @csrf
            <input type="hidden" name="inscripcion" value="1">
            <div class="form-group first">
                <label for="username">Correo</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="username" name="email" value="{{ old('email') }}" autocomplete="off"
                                   autofill="off" autofocus required>
                            @error('email')
            <span class="invalid-feedback" role="alert">
                    Tu correo no esta registro / mal escrito
                </span>
@enderror
            </div>
            <div class="form-group last mb-4">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required autocomplete="off" autofill="off"
                                   autocomplete="current-passwprd">
                            @error('password')
            <span class="invalid-feedback" role="alert">
                    Error con tu contraseña
                </span>
@enderror
            </div>

            <div class="d-flex mb-4 align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" checked="checked"
                           name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('Recordar') }}</label>
                            </div>
                            <span class="ml-auto">
                                    @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                                       class="forgot-pass">{{ __('¿Olvidó su Contraseña?') }}</a>
                                @endif
            </span>
    </div>

    <input type="submit" value="Inicia Sesión" class="btn btn-block btn-primary">
</form>
</div>
</div>
</div>
<div class="tab-pane fade" id="registermember" role="tabpanel" aria-labelledby="register-member">
<h3>Registro de Miembros</h3>
                <form method="POST" action="{{ route('registro.member') }}" id="frm-register">
                <input type="hidden" name="inscripcion" value="1">
                @csrf
            <div class="row mb-3">
                <label for="tipodocumento_id"
                       class="col-md-4 col-form-label text-md-end">{{ __('Tipo de documento:') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control" id="tipodocumento_id" name="tipodocumento_id"
                                    onchange="$('#documentto').removeAttr('readonly')" required>
                                <option selected disabled>Seleccionar tipo</option>
                                @foreach ($tipoDocs as $tpd)
            <option value="{{ $tpd->id }}">{{ $tpd->abreviatura }}</option>
                                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row mb-3">
    <label for="documento"
           class="col-md-4 col-form-label text-md-end">{{ __('Nro Documento') }}</label>
                    <div class="col-md-6">
                        <input id="documentto" type="number"
                               class="form-control @error('documento') is-invalid @enderror" name="documento"
                               value="{{ old('documento') }}" maxLength="12"
                               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                               inputmode="numeric" readonly required>

                        @error('documento')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                            </span>
                        @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="apepaterno"
                   class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>

                    <div class="col-md-6">
                        <input id="apepaterno" type="text"
                               class="form-control @error('apepaterno') is-invalid @enderror" name="apepaterno"
                               value="{{ old('apepaterno') }}" maxlength="50" required>

                        @error('apepaterno')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
            </div>

        </div>

        <div class="row mb-3">
            <label for="apematerno"
                   class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>

                    <div class="col-md-6">
                        <input id="apematerno" type="text"
                               class="form-control @error('apematerno') is-invalid @enderror" name="apematerno"
                               value="{{ old('apematerno') }}" maxlength="50" required>

                        @error('apematerno')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="nombres" class="col-md-4 col-form-label text-md-end">{{ __('Nombres') }}</label>

                    <div class="col-md-6">
                        <input id="nombres" type="text"
                               class="form-control @error('nombres') is-invalid @enderror"
                               name="nombres" value="{{ old('nombres') }}" maxlength="50" required>

                        @error('nombres')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="movil" class="col-md-4 col-form-label text-md-end">{{ __('Celular') }}</label>

                    <div class="col-md-6">
                        <input id="movil" type="text" class="form-control @error('movil') is-invalid @enderror"
                               name="movil" value="{{ old('movil') }}" maxLength="12"
                               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                               required>

                        @error('movil')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password"
                   class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               required
                               autocomplete="new-password">

                        @error('password')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password-confirm"
                   class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <!-- <div class="row mb-0 d-flex justify-content-between text-center"> -->
                <div class="row justify-content-between">
                    <div class="offset-md-4 col-md-auto">
                        <button type="submit" class="btn-cta altas" id="buttonregister">
                            {{ __('Registrarme') }}
            </button>
        </div>
    </div>
</form>
</div>
</div>
`);
        })

        $(".actividad").on('click', function () {

            montoHora = $(this).attr('data-precio');

            let id = $(this).attr('data-id');

            $("#idPrograma").val(id);

            $("#horasInscripcion").attr('disabled', 'disabled');
            $("#horasInscripcion").html("");
            $("#horasInscripcion").append(
                '<option value="" selected disabled>HORAS</option>');

            $.ajax({
                method: 'GET',
                url: `/admin/inscripciones/obtener/${id}/dias`,
                success: function (resp) {
                    let data = resp;

                    if (data.length > 0) {
                        $("#diasInscripcion").removeAttr("disabled");
                        $("#diasInscripcion").html("");
                        $("#diasInscripcion").append(`<option value="" selected disabled>DÍAS</option>`);
                        data.forEach((e) => {

                            $("#diasInscripcion").append(`
                            <option value="${e.dia}">${e.dia}</option>
                            `);
                        });
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            });
        });

        // quitaar el error de días y solicitar los horarios
        $("#diasInscripcion").on('change', function () {
            let idServicio = $("#idPrograma").val();
            let diaBuscar = $(this).val();
            console.log(idServicio, diaBuscar);
            $(".diasError").addClass("d-none");
            $.ajax({
                type: "GET",
                url: `/admin/inscripciones/obtener/${idServicio}/${diaBuscar}/horas`,
                success: function (data) {
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
                error: function (err) {
                    console.log(err)
                }
            });
        });

        // Cargar horarios basados en días
        $("#horasInscripcion").on('change', function () {
            $(".horasError").addClass("d-none");
            $("#btn-add-hour").removeAttr('disabled');
        });

        // agregar nuevo horario a la tabla
        $("#btn-add-hour").on("click", function () {
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

                let montoTotal = (totalHorarios.length * 4) * montoHora
                $('.totalPagar').html('');
                $('.totalPagar').append(`
                    Total a pagar: S/<span class="total"> ${montoTotal}.00</span>
                `);
            }
        });

        //
        $("#guardarRegistro").on("click", function () {
            const inscripcionPublica = $("#inscripcionPublica").val();
            const idservicio = $("#idPrograma").val();
            const idmiembro = $("#idMiembro").val();
            let fechasDefinidas = [];

            console.log(idservicio,idmiembro);

            // Rellenar tabla de turnos y horarios
            $("#tableComponent").find("tbody tr").each(function (idx, row) {
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    idservicio,
                    idmiembro,
                    fechasDefinidas,
                    inscripcionPublica
                },
                success: function (resp) {
                    let data = resp;
                    if (data.success == 'ok') {
                        Swal.fire({
                            title: "Inscripción exitosa",
                            position: "center",
                            icon: "success",
                            allowOutsideClick: false,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: `<span style="color:#27326F">Entendido</span>`,
                            confirmButtonColor: "#FFF000",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload()
                            }
                        });
                    }
                },
                error: function (err) {
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

            let montoTotal = (totalHorarios.length * 4) * montoHora
            $('.totalPagar').html('');
            $('.totalPagar').append(`
                    Total a pagar: S/<span class="total"> ${montoTotal}.00</span>
                `);

        }

        // funcoin de mensaje
        function messagesInfo(title, icon, bodyMessage, textButton) {
            Swal.fire({
                title: `<strong>${title} <i class="fa-solid fa-face-scream"></i></strong>`,
                icon: `${icon}`,
                html: `<p>${bodyMessage}</p>`,
                showCloseButton: true,
                focusConfirm: true,
                confirmButtonText: `<span style="color:#27326F">${textButton}</span>`,
                confirmButtonColor: "#FFF000",
            });
        }

    </script>
@endpush
