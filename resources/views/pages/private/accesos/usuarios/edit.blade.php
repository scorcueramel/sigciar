@extends('layouts.private.private', ['activePage' => 'usuarios.edit'])
@push('title', 'Usuarios Editar')
@section('content')
    @include('components.private.messages-session')
    <div class="row d-flex align-items-center mb-4">
        <div class="col-md">
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Usuario /</span> Editar </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mx-4">
            <ul class="nav nav-pills flex-column flex-md-row mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                        type="button" role="tab" aria-controls="pills-home" aria-selected="true"><i
                            class="bx bx-user me-1"></i> Usuario
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                        type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><i
                            class="fa-solid fa-lock-open me-1"></i> Rol
                    </button>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            {!! Form::open(['route' => ['usuarios.update', $usuario->id], 'method' => 'PUT', 'files' => true]) !!}
            @csrf
            <div class="tab-content" id="pills-tabContent">
                <div class="card mb-4 tab-pane fade show active" id="pills-home" role="tabpanel"
                    aria-labelledby="pills-home-tab" tabindex="0">
                    <h5 class="card-header">Datos del Usuario</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="" alt="Avatar de usuario" class="d-block rounded" height="100"
                                width="100" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Subir foto</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" type="file" id="upload" class="account-file-input" hidden
                                        name="imagen" accept="image/*" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4"
                                    id="btn-quitar">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Quitar</span>
                                </button>

                                <p class="text-muted mb-0">Formatos permitidos JPG, GIF or PNG. peso Máximo de 800K</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="country">Tipo de Documento</label>
                                <select id="tipodocumento" class="select2 form-select" name="tipodocumento">
                                    <option value="" selected disabled>Seleccionar tipo de documento</option>
                                    @foreach ($tipodocumentos as $td)
                                        <option value="{{ $td->id }}"
                                            {{ $usuario->tipodocumento_id == $td->id ? 'selected' : '' }}>
                                            {{ $td->descripcion }}
                                            / {{ $td->abreviatura }}</option>
                                    @endforeach
                                </select>
                                @error('tipodocumento')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Nro. de documento</label>
                                <input class="form-control" type="number" id="nroDoc" name="numerodocumento"
                                    value="{{ $usuario->documento }}" />
                                @error('numerodocumento')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Nombres</label>
                                <input class="form-control" type="text" id="firstName" name="nombres"
                                    value="{{ $usuario->nombres }}" />
                                @error('nombres')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">Apellido Paterno</label>
                                <input class="form-control" type="text" name="apepaterno" id="lastname1"
                                    value="{{ $usuario->apepaterno }}" />
                                @error('apepaterno')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">Apellido Materno</label>
                                <input class="form-control" type="text" name="apematerno" id="lastname2"
                                    value="{{ $usuario->apematerno }}" />
                                @error('apematerno')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="movil">Celular</label>
                                <input type="text" id="movil" name="movil" class="form-control"
                                    placeholder="999 999 999" maxlength="15" value="{{ $usuario->movil }}" />
                                @error('movil')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    placeholder="john.doe@example.com" value="{{ $usuario->email }}" />
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="col-md-12 mb-2">
                                    <label for="email" class="form-label">Estado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="estado" id="publciado"
                                        value="A" {{ $usuario->estado == 'A' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publciado">Públicado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="estado" id="despublicado"
                                        value="I" {{ $usuario->estado == 'I' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="despublicado">Borrador</label>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="organization" class="form-label">Contaseña</label>
                                <input type="password" class="form-control" id="password" placeholder="************"
                                    name="password" />
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirm-password"
                                    placeholder="************" name="confirm-password" />
                            </div>
                        </div>

                    </div>
                    <!-- /Account -->
                </div>
                <div class="card mb-4 tab-pane fade" id="pills-profile" role="tabpanel"
                    aria-labelledby="pills-profile-tab" tabindex="0">
                    <!-- Notifications -->
                    <h5 class="card-header">Asignar Roles</h5>
                    <div class="card-body">
                        <span>Selecciona los <span class="notificationRequest"><strong>Roles</strong></span> que deseas
                            asigna a este usuario.
                        </span>
                        <div class="error"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless border-bottom px-1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Descripción</th>
                                    <th class="text-nowrap text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $id => $role)
                                    @if ($id != 1)
                                        <tr>
                                            <td class="text-nowrap">
                                                <label for="{{ $role }}">
                                                    {{ $role }}
                                                </label>
                                            </td>
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="roles[]"
                                                        id="{{ $role }}" value="{{ $role }}"
                                                        {{ $user->roles->contains($id) ? 'checked' : '' }} />
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        @error('roles')
                            <span class="invalid-feedback d-block ps-3" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="card-body">
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Actualizar Usuario</button>
                        </div>
                    </div>
                    <!-- /Notifications -->
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            let imgContent = $('#uploadedAvatar');
            let rutaImgDefault = "{{ asset('assets/images/user.png') }}";
            let usuarioImagen = @json($usuario);
            let rutaImgStorage = `/storage/avatars/${usuarioImagen.directorio}/${usuarioImagen.imagen}`;
            usuarioImagen.imagen == null ? imgContent.attr('src', rutaImgDefault) : imgContent.attr('src',
                rutaImgStorage);

            $('#upload').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#uploadedAvatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });

        $("#btn-quitar").on('click', function() {
            let defaultimg = "{{ asset('/assets/images/user.png') }}";
            $('#uploadedAvatar').attr("src", defaultimg);
            $('#upload').val("");
        });
    </script>
@endpush
