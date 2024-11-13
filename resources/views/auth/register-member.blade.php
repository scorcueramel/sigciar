@extends('layouts.public.public')
@push('title', 'Registrate ')
@section('content')
<div class="content d-flex align-items-center" style="background-color: #27326F; height:100vh">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 contents">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5 mt-2 text-center">
                            <h3 style="color:#fff !important">REGISTRO DE MIEMBRO</h3>
                        </div>
                        <form method="POST" action="{{ route('registro.member') }}" id="frm-register">
                            @csrf
                            <input type="hidden" name="inscripcion" value="0">
                            <div class="row mb-3">
                                <label for="tipodocumento_id" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de documento:') }}</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <label class="input-group-text" for="tipodocumento_id"><i class="fa-solid fa-id-card"></i></label>
                                        <select class="form-select" id="tipodocumento_id" name="tipodocumento_id" required>
                                            <option selected disabled>Seleccionar tipo</option>
                                            @foreach ($tipoDocs as $tpd)
                                            <option value="{{ $tpd->id }}">{{ $tpd->descripcion }} ({{ $tpd->abreviatura }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="documento" class="col-md-4 col-form-label text-md-end">{{ __('Nro Documento') }}</label>
                                <div class="col-md-6">
                                    <input id="documentto" type="number" class="form-control @error('documento') is-invalid @enderror" name="documento" value="{{ old('documento') }}" maxLength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" inputmode="numeric" readonly required>

                                    @error('documento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="apepaterno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>

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
                                <label for="apematerno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>

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
                                <label for="movil" class="col-md-4 col-form-label text-md-end">{{ __('Celular') }}</label>

                                <div class="col-md-6">
                                    <input id="movil" type="text" class="form-control @error('movil') is-invalid @enderror" name="movil" value="{{ old('movil') }}" maxLength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                                    @error('movil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <!-- <div class="row mb-0 d-flex justify-content-between text-center"> -->
                            <div class="row justify-content-between">
                                <div class="offset-md-4 col-md-auto">
                                    <button type="submit" class="btn btn-sm btn-primary" style="font-size: 16px;">
                                        {{ __('Registrarme') }}
                                    </button>
                                </div>
                                <div class="col-md-auto">
                                    <a href="{{ route('landing.index') }}" class="btn btn-danger" style="text-decoration: none; font-size: 16px;">
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
</div>
@endsection
@push('js')
<script>
    $('#tipodocumento_id').on('change', () => {
        $('#documentto').removeAttr("readonly");
        $("#documentto").val("")
    });

    $('#frm-register').on('submit', function() {
        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        })
    });
</script>
@endpush
