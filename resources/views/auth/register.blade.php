@extends('layouts.public.app')
@push('title', 'Registrate ')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registro de usuario') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="tipodoc"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Tipo de documento:') }}</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <label class="input-group-text" for="tipodco"><i
                                                class="fa-solid fa-id-card"></i></label>
                                        <select class="form-select" id="tipodoc">
                                            <option>Seleccionar tipo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="documento"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Documento') }}</label>
                                <div class="col-md-6">
                                    <input id="documento" type="number"
                                        class="form-control @error('documento') is-invalid @enderror" name="documento"
                                        value="{{ old('documento') }}" maxLength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" inputmode="numeric" disabled required>

                                    @error('documento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="apepaterno"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Apellido Parterno') }}</label>

                                <div class="col-md-6">
                                    <input id="apepaterno" type="text"
                                        class="form-control @error('apepaterno') is-invalid @enderror" name="apepaterno"
                                        value="{{ old('apepaterno') }}" required>

                                    @error('apepaterno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="apematerno"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Apellido Marterno') }}</label>

                                <div class="col-md-6">
                                    <input id="apematerno" type="text"
                                        class="form-control @error('apematerno') is-invalid @enderror" name="apematerno"
                                        value="{{ old('apematerno') }}" required>

                                    @error('apematerno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nombres"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nombres') }}</label>

                                <div class="col-md-6">
                                    <input id="nombres" type="text"
                                        class="form-control @error('nombres') is-invalid @enderror" name="nombres"
                                        value="{{ old('nombres') }}" required>

                                    @error('nombres')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="movil"
                                    class="col-md-4 col-form-label text-md-end">{{ __('movil') }}</label>

                                <div class="col-md-6">
                                    <input id="movil" type="text"
                                        class="form-control @error('movil') is-invalid @enderror" name="movil"
                                        value="{{ old('movil') }}" maxLength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                                    @error('movil')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Correo Eléctronico') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0 d-flex justify-content-between text-center">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
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
                url: "/ciar/obtener/tipo-docs",
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
            // let tipodoc = $('#tipodoc').val();
            $('#documento').removeAttr("disabled");
            $("#documento").val("")
            // if (tipodoc == "1") {
            //     $('#documento').on('input', function() {
            //         let doc = $('#documento').val();
            //         if (doc.length > 8) {
            //             $('#documento').val(doc.substring(0, (doc.length - 1)));
            //         }
            //     });
            // }
        });
    </script>
@endpush
