@extends('layouts.public.public')
@push('title', 'Mi Perfil')
@push('css')
<style>
    .imagen img {
        filter: grayscale(0%);
        filter: gray;
        -webkit-filter: grayscale(0%);
        filter: none;
        -webkit-transition: all 1s ease;
        transition: 1s ease;
    }

    .imagen img:hover {
        filter: grayscale(100%);
        -webkit-filter: grayscale(100%) blur(2px);
        -webkit-transition: all 1s ease;
        transition: 1s ease;
    }
</style>
@endpush
@section('content')
<section class="mt-2">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('landing.index') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reservation') }}">Reservas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Perfil de usuario</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if ($errors->any())
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-hexagon-exclamation" style="margin-right: 12px"></i>
            <strong>¡Lo sentimos!</strong>
            @foreach ($errors->all() as $error)
            <span class="text-black">{{ $error }}</span>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <button type="button" class="bg-transparent border-0 imagen" id="btn-imagen"
                            data-bs-toggle="modal" data-bs-target="#modal">
                            @if ($datosPersona->imagen == null)
                            <img
                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                alt="avatar" class="rounded-circle img-fluid img-thumbnail"
                                style="height: auto; max-width: 150px;">
                            @else
                            <img
                                src="{{ asset('/storage/avatars/'.$datosPersona->directorio.'/'.$datosPersona->imagen) }}"
                                alt="avatar" class="rounded-circle img-fluid img-thumbnail"
                                style="height: auto; max-width: 150px;">
                            @endif
                        </button>
                        <h5 class="my-3">{{ $datosPersona->nombres }}</h5>
                        <p class="text-muted mb-1"><strong>{{ $datosPersona->tcdescripcion }}</strong></p>
                        <div class="d-flex justify-content-center mt-4 mb-2">
                            <form action="{{ route('image.user.remove') }}" method="post" id="btnQuitarFoto">
                                @csrf
                                <input type="hidden" name="foto" value="{{ $datosPersona->id }}">
                                @if ($datosPersona->imagen != null)
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-outline-danger" id="quitar-foto">Quitar Foto
                                </button>
                                @endif
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-outline-primary ms-1" id="btn-edit-info">Editar Información
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                    <div class="card-body p-3">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-programs-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-programs" type="button" role="tab"
                                    aria-controls="nav-programs" aria-selected="true">Mis Programas
                                </button>
                                <button class="nav-link" id="nav-reservation-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-reservation" type="button" role="tab"
                                    aria-controls="nav-reservation" aria-selected="false">Mis Reservas
                                </button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-programs" role="tabpanel"
                                aria-labelledby="nav-programs-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md border border-secondary  mx-3 mt-3"
                                        style="background: #f1f2f3">
                                        <?php
                                        $contador1 = 0;
                                        ?>
                                        @if(count($programas) > 0)
                                        <div class="accordion accordion-flush my-3" id="accordionFlushExample">
                                            @foreach($programas as $programa)
                                            @if ($programa->tiposervicio_id != 1)
                                            <?php
                                            $contador1++;
                                            ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapse{{$programa->servicios_id}}"
                                                        aria-expanded="false"
                                                        aria-controls="flush-collapse{{$programa->servicios_id}}">
                                                        {{$programa->descripcion}}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse{{$programa->servicios_id}}"
                                                    class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        {!! Str::replace('|','<br />',Str::after($programa->horario_inscripcion, '|'))!!}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        @if ($contador1 == 0)
                                        <p class="text-center my-4">Aún no tienes programas.</p>
                                        @endif
                                        @else
                                        <p class="text-center my-4">Aún no tienes programas.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-reservation" role="tabpanel"
                                aria-labelledby="nav-reservation-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md border border-secondary  mx-3 mt-3"
                                        style="background: #f1f2f3">
                                        <?php
                                        $contador2 = 0;
                                        ?>
                                        @if(count($programas) > 0)
                                        <div class="accordion accordion-flush my-3" id="accordionFlushExample">
                                            @foreach($programas as $programa)
                                            @if ($programa->tiposervicio_id == 1)
                                            <?php
                                            $contador2++;
                                            ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapse{{$programa->servicios_id}}"
                                                        aria-expanded="false"
                                                        aria-controls="flush-collapse{{$programa->servicios_id}}">
                                                        {{$programa->descripcion}}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse{{$programa->servicios_id}}"
                                                    class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        {!! Str::replace('|','<br />',Str::after($programa->horario_inscripcion, '|'))!!}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        @if ($contador2 == 0)
                                        <p class="text-center my-4">Aún no tienes reservas.</p>
                                        @endif
                                        @else
                                        <p class="text-center my-4">Aún no tienes reservas.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body dp_vista">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Nombre Completo</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $datosPersona->nombres }}
                                    {{ $datosPersona->apepaterno }}
                                    {{ $datosPersona->apematerno }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Correo Electrónico</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ Str::upper($datosPersona->correo) }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Tipo de Documento</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $datosPersona->tipodocdesc }}
                                    ({{ $datosPersona->tipodocabrev }})</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Número de Documento</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $datosPersona->documento }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Teléfono Movil</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $datosPersona->movil }}</p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('user.editar', $datosPersona->id) }}" method="post"
                        id="frmactualizardata">
                        @csrf
                        <div class="card-body d-none dp_edicion">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Nombres</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input type="text"
                                            class="form-control datos inputname @error('nombres') is-invalid @enderror"
                                            value="{{ $datosPersona->nombres }}" name="nombres" required
                                            disabled>
                                        @error('nombres')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Apellido Paterno</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input type="text"
                                            class="form-control datos @error('apepaterno') is-invalid @enderror"
                                            value="{{ $datosPersona->apepaterno }}" name="apepaterno" required
                                            disabled>
                                        @error('apepaterno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Apellido Materno</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input type="text"
                                            class="form-control datos @error('apematerno') is-invalid @enderror"
                                            value="{{ $datosPersona->apematerno }}" name="apematerno" required
                                            disabled>
                                        @error('apematerno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Correo Electrónico</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input type="email"
                                            class="form-control datos @error('correo') is-invalid @enderror"
                                            value="{{ $datosPersona->correo }}" name="correo" required disabled>
                                        @error('correo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Tipo de Documento</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <select
                                            class="form-select datos @error('tipo_documento') is-invalid @enderror"
                                            name="tipo_documento" required disabled>
                                            <option disabled selected> --- Selecciona Tipo de Documento ---</option>
                                            @foreach ($tipoDocumentos as $tpd)
                                            <option value="{{ $tpd->id }}"
                                                {{ $datosPersona->tipodocid == $tpd->id ? 'selected' : '' }}>
                                                {{ $tpd->descripcion }}
                                                ({{ $tpd->abreviatura }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('tipo_documento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Número de Documento</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input type="text"
                                            class="form-control datos @error('documento') is-invalid @enderror"
                                            value="{{ $datosPersona->documento }}" name="documento" required
                                            disabled>
                                        @error('documento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Teléfono Movil</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input type="text"
                                            class="form-control datos @error('movil') is-invalid @enderror"
                                            value="{{ $datosPersona->movil }}" name="movil" required disabled>
                                        @error('movil')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Contraseña</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input id="password" type="password"
                                            class="form-control datos @error('password') is-invalid @enderror"
                                            placeholder="••••••••" name="password" autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Confirmar Contraseña</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input id="password-confirm" type="password" class="form-control datos"
                                            placeholder="••••••••" name="password_confirmation"
                                            autocomplete="new-password">
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-outline-primary btn-sm">Actualizar</button>
                                    <button type="button"
                                        class="btn btn-outline-danger btn-sm cancelar_edicion">Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-notes-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-notes" type="button" role="tab"
                                            aria-controls="nav-notes" aria-selected="true">Mis Notas
                                        </button>
                                        <button class="nav-link" id="nav-trainer-notes-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-trainer-notes" type="button" role="tab"
                                            aria-controls="nav-trainer-notes" aria-selected="false">Notas del Entrenador
                                        </button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-notes" role="tabpanel"
                                        aria-labelledby="nav-notes-tab" tabindex="0">
                                        <div class="row mt-3">
                                            <div class="col-md-12 mx-3">
                                                <button class="btn btn-outline-primary btn-sm" id="crearnota">Crear nota privada</button>
                                            </div>
                                        </div>
                                        @if (count($notasPrivadas) > 0)
                                        <div class="row">
                                            <div class="col-md border border-secondary mx-3 mt-3"
                                                style="background: #f1f2f3">
                                                <div class="accordion accordion-flush my-3" id="accordionFlushExample">
                                                    <?php
                                                    $contador3 = 0;
                                                    ?>
                                                    @foreach($notasPrivadas as $programa)
                                                    <?php
                                                    $contador3++;
                                                    ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#flush-collapse{{$programa->id}}"
                                                                aria-expanded="false"
                                                                aria-controls="flush-collapse{{$programa->id}}">
                                                                Nota {{ $contador3 }}
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapse{{$programa->id}}"
                                                            class="accordion-collapse collapse"
                                                            data-bs-parent="#accordionFlushExample">
                                                            <div class="accordion-body">
                                                                <div class="row">

                                                                    <div class="col-md-8 d-flex align-items-center">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                {{ $programa->detalle }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="row">
                                                                            <div class="col-12 d-flex justify-content-end">
                                                                                <button type="button" class="btn btn-sm btn-success mx-1" onclick="javascript:editarNotaModal({{$programa->id}});" ddata-toggle="tooltip" data-placement="top" title="Editar Nota"><i class="fa-solid fa-file-pen"></i></button>
                                                                                <button type="button" class="btn btn-sm btn-danger" onclick="javascript:eliminarNota({{$programa->id}});" ddata-toggle="tooltip" data-placement="top" title="Editar Eliminar"><i class="fa-solid fa-trash"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-md border border-secondary mx-3 mt-3"
                                                style="background: #f1f2f3">
                                                <p class="text-center my-4">Aún no se han creado notas privadas</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="nav-trainer-notes" role="tabpanel"
                                        aria-labelledby="nav-trainer-notes-tab" tabindex="0">
                                        @if (count($notasEntrenador) > 0)
                                        <div class="row">
                                            <div class="col-md border border-secondary mx-3 mt-3"
                                                style="background: #f1f2f3">
                                                <div class="accordion accordion-flush my-3" id="accordionFlushExample">
                                                    <?php
                                                    $contador4 = 0;
                                                    ?>
                                                    @foreach($notasEntrenador as $programa)
                                                    <?php
                                                    $contador4++;
                                                    ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#flush-collapse{{$programa->id}}"
                                                                aria-expanded="false"
                                                                aria-controls="flush-collapse{{$programa->id}}">
                                                                {{ $programa->servicio }}
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapse{{$programa->id}}"
                                                            class="accordion-collapse collapse"
                                                            data-bs-parent="#accordionFlushExample">
                                                            <div class="accordion-body">
                                                                <div class="row">

                                                                    <div class="col-md-8 d-flex align-items-center">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                {{ $programa->detalle }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-md border border-secondary mx-3 mt-3"
                                                style="background: #f1f2f3">
                                                <p class="text-center my-4">Aún no se han creado notas del
                                                    entrenador.</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@include('components.public.modal', [
'titulo' => true,
'titulo_modal' => 'Cambiar mi foto de perfil',
'botones' => false,
'boton_cerrar' => 'Cancelar',
'boton_guardar' => 'Guardar',
])
@push('js')
<script>
    $('#btn-imagen').on('click', function() {
        $('#modalLabel').html('CAMBIAR MI FOTO DE PERFIL');
        $('.modal_cuerpo').html('');
        $('.modal_cuerpo').html(`
                <form method="post" action="{{ route('image.user.update') }}" id="frmactualizafoto" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="idpersona" value="{{ $datosPersona->id }}"/>
                        <label for="imageFile" class="form-label">Selecciona una foto</label>
                        <input class="form-control" type="file" id="cargarImagen" name="imagen" accept="image/*"/>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" onclick="javascript:guardarFoto()">Guardar</button>
                    </div>
                </form>
            `);
    });

    function guardarFoto() {
        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function guardarNota() {
        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });

    }

    $('#btn-edit-info').on('click', function() {
        $('.dp_vista').addClass('d-none');
        $('.dp_edicion').removeClass('d-none');
        $('.datos').removeAttr('disabled');
        $('.datos').addClass('shadow-none');
        $('.inputname').focus();
        $(this).attr('disabled', 'disabled')
    });

    $('.cancelar_edicion').on('click', function() {
        $('.dp_vista').removeClass('d-none');
        $('.dp_edicion').addClass('d-none');
        $('.datos').attr('disabled');
        $('.datos').addClass('shadow-none');
        $('#btn-edit-info').removeAttr('disabled');
    });

    $('#quitar-foto').on('click', function() {
        Swal.fire({
            title: "¿Elimar tu foto?",
            html: "<small>Al eliminar tu foto no la podrás recuperar, tendras que cargar una nueva de ser necesario</small>",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, Quitar",
            cancelButtonText: "No, cancelar!",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'info',
                    html: "Espere un momento porfavor ...",
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                })
                $('#btnQuitarFoto').trigger('submit');
            }
        });
    });

    $('#frmactualizardata').on('submit', function() {
        Swal.fire({
            icon: 'info',
            html: "Espere mientras actualizamos sus datos...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    $("#crearnota").on("click", function() {
        $("#modal").modal("show");
        $('#modalLabel').html('MIS NOTA PRIVADAS');
        $('.modal_cuerpo').html('');
        $('.modal_cuerpo').html(`
            <form method="post" action="{{ route('notas.privadas.user') }}" id="guardarnota" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nota-miembro" class="form-label">Nota</label>
                    <textarea class="form-control" id="nota-miembro" name="nota" rows="3" placeholder="Escribe una nota aquí" maxlength="300" aria-describedby="description" onkeypress="javascript:document.getElementById('error').classList.add('d-none')" style="height: 150px;" required></textarea>
                    <div id="description" class="form-text text-primary">300 caracteres como máximo permitido.</div>
                    <div class="d-none" id="error">
                        <p class="text-danger">Debes ingresar una nota para enviar</p>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" onclick="javascript:guardarNota()">Guardar</button>
                </div>
            </form>
        `);
    });

    function actualizarNota() {
        let id = $("#informe_id").val();
        let detalle = $("#nota-miembro").val();

        $.ajax({
            type: "POST",
            url: "{{route('actualizar.notas.user')}}",
            data: {
                detalle,
                id
            },
            success: function(response) {
                guardarNota();
                window.location.reload();
            }
        });
    }

    function editarNotaModal(idinforme) {
        $.ajax({
            type: "GET",
            url: `/ciar/edit/${idinforme}/notas`,
            success: function(response) {
                let data = response[0];
                $("#modal").modal("show");
                $('#modalLabel').html('MIS NOTA PRIVADAS');
                $(".modal_cuerpo").html("");
                $(".modal_cuerpo").html(`
                    <input type="hidden" id="informe_id" value="${data.id}">
                    <div class="mb-3">
                        <label for="nota-miembro" class="form-label">Nota</label>
                        <textarea class="form-control" id="nota-miembro" name="detalle" rows="3" placeholder="Escribe una nota aquí" maxlength="300" aria-describedby="description" onkeypress="javascript:document.getElementById('error').classList.add('d-none')" style="height: 150px;" required>${data.detalle}</textarea>
                        <div id="description" class="form-text text-primary">300 caracteres como máximo permitido.</div>
                        <div class="d-none" id="error">
                            <p class="text-danger">Debes ingresar una nota para enviar</p>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" onclick="javascript:actualizarNota()">Guardar</button>
                    </div>
                `);
            }
        });
    }

    function eliminarNota(idinforme) {
        Swal.fire({
            title: `¿Eliminar Nota?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: `/ciar/eliminar/${idinforme}/notas`,
                    success: function(response) {
                        guardarNota();
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>
@endpush
