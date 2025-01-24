@extends('layouts.private.private', ['activePage' => 'costos.lugares.create'])
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
            <div class="card-body">
                <form method="post" action="{{route('costos.lugares.store')}}" id="costolugar" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="lugares">Lugares</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-square-check"></i>
                                </span>
                                <select class="form-select" id="lugares" aria-label="lugares" name="lugares" required>
                                    <option value="" selected disabled>SELECCIONAR</option>
                                    @foreach ($lugares as $l)
                                    <option value="{{$l->id}}">{{$l->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="tiposervicios">Tipos de Servicio</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-square-check"></i>
                                </span>
                                <select class="form-select" id="tiposervicios" aria-label="tiposervicios" name="tiposervicios" required>
                                    <option value="" selected disabled>SELECCIONAR</option>
                                    @foreach ($tiposervicios as $tps)
                                    <option value="{{$tps->id}}">{{$tps->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="descripcion">Descripcion</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span id="descripcion2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                <input type="text" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" aria-label="Nombre para la descripcion" aria-describedby="descripcion2" name="descripcion" value="{{old('descripcion')}}" maxlength="100" autofocus required />
                                @error('descripcion')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="abreviatura">Abreviatura</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span id="abreviatura2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                <input type="text" id="abreviatura" class="form-control @error('abreviatura') is-invalid @enderror" aria-label="Nombre para la abreviatura" aria-describedby="abreviatura2" name="abreviatura" value="{{old('abreviatura')}}" maxlength="2" autofocus required />
                                @error('abreviatura')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 form-label" for="costohora">Costo Hora</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span id="lugar2" class="input-group-text"><i class="fa-regular fa-money-bill"></i></span>
                                <input type="number" id="costohora" class="form-control @error('costohora') is-invalid @enderror" aria-label="Amount (to the nearest dollar)" value="{{ old('costohora') }}" name="costohora" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="7" required>
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
                        <label class="col-sm-3 form-label" for="tipo">Tipo de costo</label>
                        <div class="col-sm-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo" id="fijo" value="F">
                                <label class="form-check-label" for="fijo">FIJO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo" id="variable" value="V" checked>
                                <label class="form-check-label" for="variable">VARIABLE</label>
                            </div>
                            <div class="form-text">Inidica el tipo para la el costo por hora</div>
                            @error('estado')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
                    <div class="row justify-content-end mt-3">
                        <div class="col-sm-9">
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
        var length = 2;
        str = str.toUpperCase();
        var trimmedString = str.substring(0, length);
        $('#abreviatura').val(trimmedString);
    });
    $('#costohora').on('submit', function() {
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
