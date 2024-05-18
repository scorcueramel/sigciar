@extends('layouts.public.app')
@push('title', 'Registrate ')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Datos personales del usuario') }}</div>

                <div class="card-body">
                    <form action="{{route('actualizar.datos.usuario')}}" method="post">
                        @csrf
                        <input type="hidden" name="userid" value="{{Auth::user()->id}}">
                        <div class="row mb-3">
                            <label for="tipodoc" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de documento:') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <label class="input-group-text" for="tipodco"><i class="fa-solid fa-id-card"></i></label>
                                    <select class="form-select" id="tipodoc" name="tipodocumento_id" required>
                                        <option>Seleccionar tipo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="numerodoc" class="col-md-4 col-form-label text-md-end">{{ __('Documento') }}</label>
                            <div class="col-md-6">
                                <input id="numerodoc" type="number" class="form-control @error('documento') is-invalid @enderror" name="documento" value="{{ old('documento') }}" maxLength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" inputmode="numeric" readonly required>

                                @error('documento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apepaterno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Parterno') }}</label>

                            <div class="col-md-6">
                                <input id="apepaterno" type="text" class="form-control @error('apepaterno') is-invalid @enderror" name="apepaterno" value="{{ old('apepaterno') }}" maxlength="50" required>

                                @error('apepaterno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apematerno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Marterno') }}</label>

                            <div class="col-md-6">
                                <input id="apematerno" type="text" class="form-control @error('apematerno') is-invalid @enderror" name="apematerno" value="{{ old('apematerno') }}" maxlength="50" required>

                                @error('apematerno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nombres" class="col-md-4 col-form-label text-md-end">{{ __('Nombres') }}</label>

                            <div class="col-md-6">
                                <input id="nombres" type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" value="{{ old('nombres') }}" maxlength="50" required>

                                @error('nombres')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="movil" class="col-md-4 col-form-label text-md-end">{{ __('movil') }}</label>

                            <div class="col-md-6">
                                <input id="movil" type="text" class="form-control @error('movil') is-invalid @enderror" name="movil" value="{{ old('movil') }}" maxLength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                                @error('movil')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0 d-flex justify-content-between text-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('login') }}" class="btn btn-danger">
                                    {{ __('Volver') }}
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(() => {
        $.ajax({
            type: "GET",
            url: "/ciar/usuarios/obtener/tipo-docs",
            success: function(response) {
                let resp = response.tipos;
                $('#tipodoc').html('');
                $('#tipodoc').append(`
                        <option value="" disabled selected>Seleccionar tipo</option>
                    `);
                resp.forEach((e) => {
                    $('#tipodoc').append(`
                        <option value="${e.id}">${e.descripcion}</option>
                        `);
                });
            }
        });
    });

    $('#tipodoc').on('change', () => {
        $('#numerodoc').removeAttr("readonly");
        $("#numerodoc").val("")
    });
</script>
@endpush
