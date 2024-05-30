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
                        <button type="button" class="bg-transparent border-0 imagen" id="btn-imagen" data-bs-toggle="modal" data-bs-target="#modal">
                            @if ($datosPersona->imagen == null)
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar" class="rounded-circle img-fluid img-thumbnail" style="height: auto; max-width: 150px;">
                            @else
                            <img src="{{ asset('/storage/avatars/'.$dirName.'/'.$datosPersona->imagen) }}" alt="avatar" class="rounded-circle img-fluid img-thumbnail" style="height: auto; max-width: 150px;">
                            @endif
                        </button>
                        <h5 class="my-3">{{ $datosPersona->nombres }}</h5>
                        <p class="text-muted mb-1"><strong>{{ $datosPersona->tcdescripcion }}</strong></p>
                        <div class="d-flex justify-content-center mt-4 mb-2">
                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Quitar Foto</button>
                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1" id="btn-edit-info">Editar Información</button>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        <div class="row m-2">
                            <div class="col-md">
                                <p class="mb-3">
                                    <span class="text-primary font-italic me-1">Mis reservas</span>
                                </p>
                                <div class="row mb-2">
                                    <div class="col-md border border-secondary mx-1" style="background: #f1f2f3">
                                        <p class="text-center my-4">Aún no has realizado reservas</p>
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
                    <form action="">
                        <div class="card-body d-none dp_edicion">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Nombres</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <input type="text" class="form-control datos inputname" value="{{$datosPersona->nombres}}" disabled>
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
                                        <input type="text" class="form-control datos" value="{{$datosPersona->apepaterno}}" required disabled>
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
                                        <input type="text" class="form-control datos" value="{{$datosPersona->apematerno}}" required disabled>
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
                                        <input type="email" class="form-control datos" value="{{$datosPersona->correo}}" required disabled>
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
                                          <select class="form-select datos" name="" id="" required disabled>
                                            <option disabled selected> --- Selecciona Tipo de Documento --- </option>
                                            @foreach ($tipoDocumentos as $tpd)
                                            <option value="{{ $tpd->id }}">{{$tpd->descripcion}} ({{ $tpd->abreviatura }})</option>
                                            @endforeach
                                          </select>
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
                                        <input type="text" class="form-control datos" value="{{ $datosPersona->documento }}" required disabled>
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
                                        <input type="text" class="form-control datos" value="{{ $datosPersona->movil }}" required disabled>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-9">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Actualizar</button>
                                    <button type="button" class="btn btn-outline-danger btn-sm cancelar_edicion">Cancelar</button>
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
                                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Mis Notas</button>
                                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Notas del
                                            Entrenador</button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md border border-secondary  mx-1 mt-3" style="background: #f1f2f3">
                                                <p class="text-center my-4">Aún no se han creado notas privadas</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md border border-secondary  mx-1 mt-3" style="background: #f1f2f3">
                                                <p class="text-center my-4">Aún no se han creado notas del
                                                    entrenador.</p>
                                            </div>
                                        </div>
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
'botones' => true,
'boton_cerrar' => 'Cancelar',
'boton_guardar' => 'Guardar',
])
@push('js')
<script>
    $('#btn-imagen').on('click', function() {
        $('.modal_cuerpo').html('');
        $('.modal_cuerpo').html(`
                <form method="post" action="{{ route('image.user.update') }}" id="frmactualizafoto" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="idpersona" value="{{ $datosPersona->id }}"/>
                        <label for="imageFile" class="form-label">Selecciona una foto</label>
                        <input class="form-control" type="file" id="cargarImagen" name="imagen" accept="image/*"/>
                    </div>
                </form>
            `);
    });

    $('#btn-guardar').on('click', function() {
        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        })
        $('#frmactualizafoto').trigger('submit');
    })

    $('#btn-edit-info').on('click', function() {
        $('.dp_vista').addClass('d-none');
        $('.dp_edicion').removeClass('d-none');
        $('.datos').removeAttr('disabled');
        $('.datos').addClass('shadow-none');
        $('.inputname').focus();
        $(this).attr('disabled','disabled')
    });

    $('.cancelar_edicion').on('click',function(){
        $('.dp_vista').removeClass('d-none');
        $('.dp_edicion').addClass('d-none');
        $('.datos').attr('disabled');
        $('.datos').addClass('shadow-none');
        $('#btn-edit-info').removeAttr('disabled');
    });
</script>
@endpush
