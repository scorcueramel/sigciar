@extends('layouts.private.private', ['activePage' => 'noticias.edit'])
@push('title', 'Nueva Noticia')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Noticia /</span> Editar </h4>
<!-- Basic Layout & Basic with Icons -->
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <form method="post" action="{{route('noticias.update')}}" enctype="multipart/form-data" class="row g-3 needs-validation" id="form" novalidate>
            @csrf
            <input type="hidden" value="{{$noticia->noticia_id}}" name="id">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="categoria">Categorías</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="categoria2" class="input-group-text"><i class="fa-solid fa-layer-group"></i></span>
                                <select class="form-select" id="categoria" aria-label="categoria" name="categoria" required>
                                    <option selected disabled>Selecciona una categoría</option>
                                    @foreach ($categorias as $categoria)
                                    <option value="{{$categoria->id}}" {{ $noticia->categoria_id == $categoria->id ? 'selected' : ''  }}>{{$categoria->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text">Selecciona una categoría para la noticia</div>
                            @error('categoria')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="titulo">Título</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="titulo2" class="input-group-text"><i class="fa-regular fa-heading"></i></span>
                                <input type="text" id="titulo" class="form-control @error('titulo') is-invalid @enderror" placeholder="Título de la nota" aria-label="Título de la nota" aria-describedby="titulo2" name="titulo" value="{{old('titulo') ?? $noticia->titulo }}" maxlength="200" autofocus required />
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
                            <textarea id="extracto" class="form-control @error('extracto') is-invalid @enderror" placeholder="Extracto para la noticia" aria-label="Extracto para la noticia" aria-describedby="extracto2" maxlength="300" rows="1" name="extracto" required>{{old('extracto') ?? $noticia->extracto}}</textarea>
                            <div class="form-text">Recuerda, agregar solo un pequeño extracto de la noticia</div>
                            @error('extracto')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="cuerpo">Cuerpo</label>
                        <div class="col-sm-10">
                            <textarea id="cuerpo" class="form-control @error('cuerpo') is-invalid @enderror" placeholder="cuerpo para la noticia" aria-label="cuerpo para la noticia" aria-describedby="cuerpo2" maxlength="300" rows="1" name="cuerpo" required>{{old('cuerpo') ?? $noticia->cuerpo}}</textarea>
                            <div class="form-text">En esta sección agrega el cuelpo de la noticia</div>
                            @error('cuerpo')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="estado">Estado</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="estado" id="activo" value="A" {{ $noticia->estado == 'A' ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">ACTIVO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="estado" id="inactivo" value="I" {{ $noticia->estado == 'I' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inactivo">INACTIVO</label>
                            </div>
                            <div class="form-text">Inidica el estado inicial para la sede</div>
                            @error('estado')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="imagen">Imagen de portada</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="imagen" class="input-group-text @error('imagen') @enderror"><i class="bx bx-image-add"></i></span>
                                <input class="form-control" type="file" id="cargarImagen" placeholder="Carga una Imagen" aria-label="Cargar Imagen" aria-describedby="imagen" name="imagen" value="{{old('imagen') ?? $noticia->imagen_destacada}}" accept="image/*" max-size="2000"/>
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
                        <div class="col-xxl">
                            <div class="card-body d-flex justify-content-center">
                                <img class="img-fluid" src="{{ asset('assets/images/default-img.gif') }}" id="imagenSeleccionada" style="max-height: 335px;">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary">Actualizar Noticia</button>
                        </div>
                        <div class="col-sm-6 text-end">
                            <a href="{{route('noticias.index')}}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        let imgContent = $('#imagenSeleccionada');
        let rutaImgDefault = "{{ asset('/storage/noticias/')}}";
        let noticiaImagenDesctada = @json($noticia);
        let rutaImgStorage = `/storage/noticias/${noticiaImagenDesctada.imagen_destacada}`;
        noticiaImagenDesctada.imagen_destacada == null ? imgContent.attr('src',rutaImgDefault) : imgContent.attr('src',rutaImgStorage);

        $('#cargarImagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#extracto').summernote({
            placeholder: 'Extracto de la noticia',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ]
        });
        $('#cuerpo').summernote({
            placeholder: 'Cuerpo de la noticia',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ]
        });
    });

    $("#form").on('submit',function(){
        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
</script>
@endpush
