@extends('layouts.private.private', ['activePage' => 'tipo.servicio.create'])
@push('title', 'Nueva Sede')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tipo Servicio /</span> Crear Nueva </h4>
<!-- Basic Layout & Basic with Icons -->
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Formulario de registro</h5>
                <small class="text-muted float-end">Nuevo Tipo Servicio</small>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('tipo.servicio.store')}}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="descripcion">Descripcion</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="descripcion2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                <input type="text" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Nombre para la descripcion" aria-label="Nombre para la descripcion" aria-describedby="descripcion2" name="descripcion" value="{{old('descripcion')}}" maxlength="100" autofocus required />
                                @error('descripcion')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="abreviatura">Abreviatura</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="abreviatura2" class="input-group-text"><i class="bx bx-trip"></i></span>
                                <input type="text" id="abreviatura" class="form-control ps-1 @error('abreviatura') is-invalid @enderror" placeholder="Abreviatura del establecimiento" maxlength="3" name="abreviatura" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="<u><em>No puedes</em> <strong>editar</strong></u> este campo porque es auto generado." readonly required>
                                @error('abreviatura')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="estado">Estado</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="estado" id="activo" value="A">
                                <label class="form-check-label" for="activo">ACTIVO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="estado" id="inactivo" value="I" checked>
                                <label class="form-check-label" for="inactivo">INACTIVO</label>
                            </div>
                            <div class="form-text">Inidica el estado inicial para la el tipo</div>
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
</div>
@endsection
@push('js')
<script>
    $("#descripcion").on('keyup', function() {
        var str = $(this).val();
        var length = 3;
        str = str.toUpperCase();
        var trimmedString = str.substring(0, length);
        $('#abreviatura').val(trimmedString);
    });
</script>
@endpush
