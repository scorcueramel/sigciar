@extends('layouts.private.private', ['activePage' => 'noticias.create'])
@push('title', 'Nueva Sede')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Noticia /</span> Crear Nueva </h4>
<!-- Basic Layout & Basic with Icons -->
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Formulario de registro</h5>
                <small class="text-muted float-end">Nueva Noticia</small>
            </div>
            <div class="card-body">
                <form method="post" action="#" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="titulo">Título</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="titulo2" class="input-group-text"><i class="fa-regular fa-heading"></i></span>
                                <input type="text" id="titulo" class="form-control @error('titulo') is-invalid @enderror" placeholder="Título de la nota" aria-label="Título de la nota" aria-describedby="titulo2" name="titulo" value="{{old('titulo')}}" maxlength="100" autofocus required />
                                @error('titulo')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="extracto">Extracto</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="extracto2" class="input-group-text"><i class="bx bx-trip"></i></span>
                                <textarea id="extracto" class="form-control @error('extracto') is-invalid @enderror"  placeholder="Extracto para la noticia" aria-label="Extracto para la noticia" aria-describedby="extracto2" maxlength="250" rows="1" name="extracto" required>{{old('extracto')}}</textarea>
                                @error('extracto')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="imagen">Imagen</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="imagen" class="input-group-text @error('imagen') @enderror"><i class="bx bx-image-add"></i></span>
                                <input class="form-control" type="file" id="cargarImagen" placeholder="Carga una Imagen" aria-label="Cargar Imagen" aria-describedby="imagen" name="imagen" value="{{old('imagen')}}" accept="image/*" max-size="2000"/>
                            </div>
                            <div class="form-text">Seleccionas imagenes en formato .PNG .JPG .JPEG</div>
                            @error('imagen')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="estado">Estado</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="estado2" class="input-group-text"><i class="bx bx-check-square"></i></span>
                                <select class="form-select" id="estado" aria-label="estado" name="estado" required>
                                    <option selected disabled>Selecciona un estado inicial para la sede</option>
                                    <option value="A" {{ old('estado') == "A" ? "selected" : "" }}>PUBLICADO</option>
                                    <option value="I" {{ old('estado') == "I" ? "selected" : "" }}>BORRADOR</option>
                                </select>
                            </div>
                            <div class="form-text">Inidica el estado inicial para la sede</div>
                            @error('estado')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Basic Layout -->
    <div class="col-xxl" style="max-height: 335px;">
        <div class="card mb-4">
            <!--
                <div class="card-header d-flex align-items-center justify-content-between">
                    <small class="text-muted float-end">Imagen cargada</small>
                    <h5 class="mb-0">Previsualización de imagen</h5>
                </div>
            -->
            <div class="card-body d-flex justify-content-center">
                <img class="img-fluid" src="{{ asset('assets/images/default-img.gif') }}" id="imagenSeleccionada" style="max-height: 335px;">
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
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
