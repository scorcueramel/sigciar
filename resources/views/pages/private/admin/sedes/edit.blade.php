@extends('layouts.private.private', ['activePage' => 'sedes.edit'])
@push('title', 'Nueva Sede')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sedes /</span> Crear Nueva </h4>
<!-- Basic Layout & Basic with Icons -->
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Formulario de registro</h5>
                <small class="text-muted float-end">Nueva Sede</small>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('sedes.update',$sede->id)}}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="sede">Sede</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="sede2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                <input type="text" id="sede" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Nombre para la sede" aria-label="Nombre para la sede" aria-describedby="sede2" name="descripcion" value="{{old('descripcion') ?? $sede->descripcion}}" maxlength="100" autofocus required />
                                @error('descripcion')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="direccion">Dirección</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="direccion2" class="input-group-text"><i class="bx bx-trip"></i></span>
                                <textarea id="direccion" class="form-control @error('direccion') is-invalid @enderror" placeholder="Dirección del establecimiento" aria-label="Dirección del establecimiento" aria-describedby="direccion2" name="direccion" maxlength="250" required="required">
                                {{old('direccion') ?? $sede->direccion}}
                                </textarea>
                                @error('direccion')
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
                                <input class="form-control" type="file" id="cargarImagen" placeholder="Carga una Imagen" aria-label="Cargar Imagen" aria-describedby="imagen" name="imagen" value="{{old('imagen')}}" accept="image/*" />
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
                                <span id="estado2" class="input-group-text" required><i class="bx bx-check-square"></i></span>
                                <select class="form-select" id="estado" aria-label="estado" name="estado">
                                    <option selected disabled>Selecciona un estado inicial para la sede</option>
                                    <option value="I" {{ $sede->estado == "I" ? "selected" : ""  }}>BORRADOR</option>
                                    <option value="A" {{ $sede->estado == "A" ? "selected" : ""  }}>PUBLICADO</option>
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
                    <div class="row justify-content-between">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                        <div class="col-sm-6 text-end">
                            <a href="{{route('sedes.index')}}" class="btn btn-danger">Volver</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Basic Layout -->
    <div class="col-xxl" style="max-height: 355px;">
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-center">
                <img class="img-fluid"  id="imagenSeleccionada" style="height: 355px;">
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        let imgContent = $('#imagenSeleccionada');
        let rutaImgDefault = "{{ asset('/assets/images/default-img.png')}}";
        let sedeImagen = @json($sede);
        let rutaImgStorage = `/storage/sedes/${sedeImagen.imagen}`;
        sedeImagen.imagen == null ? imgContent.attr('src',rutaImgDefault) : imgContent.attr('src',rutaImgStorage);

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
