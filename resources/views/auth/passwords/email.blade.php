@extends('layouts.public.auth')
@push('title','Recuperar Contraseña')
@section('content')
<div class="content d-flex align-items-center" style="background-color: #27326F; height:100vh">
    <div class="container py-5 rounded" style="background-color: #202645;">
        <div class="row">
            <div class="col-md-12 contents">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-8">
                        <div class="mb-4 text-center">
                            <h3 style="color:#fff !important">¿Olvidaste tu contraseña?</h3>
                        </div>
                        <div class="mb-4 text-center">
                            <p style="color:#fff !important">Ingresa tu email registrado para enviarte<br> un enlace y resetear tu contraseña</p>
                        </div>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label" style="color:#fff; text-align: end;">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0 mt-4">
                                <div class="offset-md-4 mt-2">
                                    <button type="submit" class="btn btn-primary" style="font-size: 18px;">
                                        {{ __('Restablecer Contraseña') }}
                                    </button>
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
    $('#login').submit(function() {
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
