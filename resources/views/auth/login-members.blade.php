@extends('layouts.public.auth')
@push('title','Iniciar Sesión')
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{asset('assets/auth/images/ciar-login.webp')}}" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6 contents">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h3>Inicio de Sesión para Miembros</h3>
                            <!-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p> -->
                        </div>
                        @if(Session::has('warning'))

                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Lo sentimos!</strong> {{Session::get('warning')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        <form action="{{ route('login.member') }}" method="post" autocomplete="off" id="login">
                            @csrf
                            <div class="form-group first">
                                <label for="username">Correo</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="username" name="email" value="{{ old('email') }}" autocomplete="off" autofill="off" autofocus required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    Tu correo no esta registro / mal escrito
                                </span>
                                @enderror
                            </div>
                            <div class="form-group last mb-4">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="off" autofill="off" autocomplete="current-passwprd">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    Error con tu contraseña
                                </span>
                                @enderror
                            </div>

                            <div class="d-flex mb-5 align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" checked="checked" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">{{ __('Recordar') }}</label>
                                </div>
                                <span class="ml-auto">
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-pass">{{ __('¿Olvidó su Contraseña?') }}</a>
                                    @endif
                                </span>
                            </div>

                            <input type="submit" value="Ingresar" class="btn btn-block btn-primary">

                            <div class="text-white">
                                <span class="d-block text-center my-4 text-muted">&mdash; ó &mdash;</span>
                                <a href="{{route('registro.member')}}" class="btn btn-block btn-primary pt-3 text-decoration-none text-light">
                                    Registrame
                                </a>
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
