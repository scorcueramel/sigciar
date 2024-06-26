@extends('layouts.private.private', ['activePage' => 'categorias.create'])
@push('title', 'Nueva Categoría')
@push('css')
    <style>
        input[type=checkbox] {
            font-size: 20px !important;
        }
    </style>
@endpush
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Categorías /</span> Crear Nueva </h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row mb-3">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Formulario de registro</h5>
                    <small class="text-muted float-end">Nueva Categoría</small>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('categorias.nueva')}}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nombre">Nombre</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="nombre2" class="input-group-text"><i class="fa-regular fa-layer-group"></i></span>
                                    <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Nombre para la categoría" aria-label="Nombre para la sede" aria-describedby="nombre2" name="nombre" value="{{old('nombre')}}" maxlength="100" autofocus required />
                                    @error('nombre')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="slug">Slug</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="message2" class="input-group-text"><i class="fa-brands fa-letterboxd"></i></span>
                                    <input type="text" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug de la categoría" aria-label="Slug de la categoría" aria-describedby="slug2" name="slug" value="{{old('slug')}}" maxlength="150" autofocus required />
                                    @error('slug')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="publicado">Estado</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="estado" id="publciado" value="on">
                                    <label class="form-check-label" for="publciado">Públicado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="estado" id="despublicado" value="off" checked>
                                    <label class="form-check-label" for="despublicado">Despublicado</label>
                                </div>
                                <div class="form-text">
                                    Inidica el estado inicial para la nueva categoría
                                </div>
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
    </div>
@endsection
@push('js')
    <script>
        $("#nombre").on('keyup',function (){
            var str = $(this).val();
            str = str.replace(/\s+/g, '-').toLowerCase();
            $('#slug').val(str);
        });
    </script>
@endpush
