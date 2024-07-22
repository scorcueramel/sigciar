@extends('layouts.private.private', ['activePage' => 'subtipos.servicio.create'])
@push('title', 'Nueva Sede')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Subtipo Servicio /</span> Crear Nueva </h4>
<!-- Basic Layout & Basic with Icons -->
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Formulario de registro</h5>
                <small class="text-muted float-end">Nuevo Subtipo Servicio</small>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card-body">
                        <form method="post" action="{{route('subtipos.servicio.store')}}" id="tiposervicio" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="titulo">Titulo</label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span id="titulo2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                        <input type="text" id="titulo" class="form-control @error('titulo') is-invalid @enderror" aria-label="Nombre para la titulo" aria-describedby="titulo2" name="titulo" value="{{old('titulo')}}" maxlength="100" autofocus required />
                                        @error('titulo')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="subtitulo">Subtitulo</label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span id="subtitulo2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                        <input type="text" id="subtitulo" class="form-control @error('subtitulo') is-invalid @enderror" aria-label="Nombre para la subtitulo" aria-describedby="subtitulo2" name="subtitulo" value="{{old('subtitulo')}}" maxlength="100"/>
                                        @error('subtitulo')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 form-label" for="medicion">Medicion</label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span id="medicion2" class="input-group-text"><i class="bx bx-trip"></i></span>
                                        <input type="text" id="medicion" class="form-control ps-1 @error('medicion') is-invalid @enderror" maxlength="20" name="medicion" value="{{old('medicion')}}" required>
                                        @error('medicion')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 form-label" for="estado">Estado</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="estado" id="activo" value="A">
                                        <label class="form-check-label" for="activo">PUBLICADO</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="estado" id="inactivo" value="I" checked>
                                        <label class="form-check-label" for="inactivo">BORRADOR</label>
                                    </div>
                                    <div class="form-text">Inidica el estado inicial para la el tipo</div>
                                    @error('estado')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="tiposervicio">Tipo de Servicio</label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-square-check"></i>
                                        </span>
                                        <select class="form-select" id="tiposervicio" aria-label="tiposervicio" name="tiposervicio" required>
                                            <option value="" selected disabled>SELECCIONAR</option>
                                            @foreach ($tiposervicios as $tps)
                                            <option value="{{$tps->id}}">{{$tps->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="imagen">Imagen</label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span id="imagen" class="input-group-text @error('imagen') @enderror"><i class="bx bx-image-add"></i></span>
                                        <input class="form-control" type="file" id="cargarImagen" placeholder="Carga una Imagen" aria-label="Cargar Imagen" aria-describedby="imagen" name="imagen" value="{{old('imagen')}}" accept="image/*" max-size="2000" />
                                    </div>
                                    <div class="form-text">Seleccionas imagenes en formato .PNG .JPG .JPEG</div>
                                    @error('imagen')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-end mt-3">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6" style="margin-top:-20px">
                    <div class="card-body d-flex justify-content-center">
                        <img class="img-fluid" src="{{ asset('assets/images/default-img.gif') }}" id="imagenSeleccionada" style="max-height: 335px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $('#tiposervicio').on('submit', function() {
        Swal.fire({
                icon: 'info',
                html: "Espere un momento porfavor ...",
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
    });

    $(document).ready(function() {
        $('#cargarImagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@endpush
