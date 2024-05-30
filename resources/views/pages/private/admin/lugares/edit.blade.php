@extends('layouts.private.private', ['activePage' => 'lugares.edit'])
@push('title', 'Editar Lugar')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Lugares /</span> Editar : {{ $lugar->descripcion }} </h4>
<!-- Basic Layout & Basic with Icons -->
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Formulario de registro</h5>
                <small class="text-muted float-end">Nuevo Lugar</small>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('lugares.update',$lugar->id)}}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="lugar">Lugar</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="lugar2" class="input-group-text"><i class="fa-regular fa-court-sport"></i></span>
                                <input type="text" id="lugar" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Nombre para la lugar" aria-label="Nombre para la lugar" aria-describedby="lugar2" name="descripcion" value="{{old('descripcion') ?? $lugar->descripcion}}" maxlength="100" autofocus required />
                                @error('descripcion')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="costohora">Costo Hora</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="lugar2" class="input-group-text"><i class="fa-regular fa-money-bill"></i></span>
                                <input type="number" id="costohora" class="form-control @error('costohora') is-invalid @enderror" placeholder="S/.100.00" aria-label="Amount (to the nearest dollar)" value="{{ old('costohora') ?? $lugar->costohora}}" name="costohora" required>
                                <span class="input-group-text">.00</span>
                                @error('costohora')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="tipo">Tipo Costo</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="tipo2" class="input-group-text"><i class='bx bx-rotate-right'></i></span>
                                <select class="form-select" id="tipo" aria-label="tipo" name="tipo" required>
                                    <option selected disabled>Selecciona tipo</option>
                                    <option value="F" {{ $lugar->tipo == "F" ? "selected" : "" }}>FIJO</option>
                                    <option value="V" {{ $lugar->tipo == "V" ? "selected" : "" }}>VARIABLE</option>
                                </select>
                            </div>
                            <div class="form-text">Inidica el tipo de costo por hora</div>
                            @error('tipo')
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
                                    <option selected disabled>Selecciona estado</option>
                                    <option value="A" {{ $lugar->estado == "A" ? "selected" : "" }}>PUBLICADO</option>
                                    <option value="I" {{ $lugar->estado == "I" ? "selected" : "" }}>BORRADOR</option>
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
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="sede_id">Sedes</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="sede_id2" class="input-group-text"><i class="fa-regular fa-hotel"></i></span>
                                <select class="form-select" id="sede_id" aria-label="sede_id" name="sede_id" required>
                                    <option selected disabled>Selecciona sede</option>
                                    @foreach ($sedes as $sede)
                                        <option value="{{ $sede->id }}" {{ $lugar->sede_id == $sede->id ? 'selected' : '' }}>{{ $sede->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text">Debese seleccionar la sede a la que pernetece este lugar</div>
                            @error('sede_id')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                        <div class="col-sm-1">
                            <a href="{{route('lugares.index')}}" class="btn btn-danger">Volver</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Basic Layout -->
    {{-- <div class="col-xxl" style="max-height: 355px;">
        <div class="card mb-4">
            <!--
                <div class="card-header d-flex align-items-center justify-content-between">
                    <small class="text-muted float-end">Imagen cargada</small>
                    <h5 class="mb-0">Previsualización de imagen</h5>
                </div>
            -->
            <div class="card-body d-flex justify-content-center">
                <img class="img-fluid" src="{{ asset('assets/images/default-img.gif') }}" id="imagenSeleccionada" style="max-height: 355px;">
            </div>
        </div>
    </div> --}}
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
