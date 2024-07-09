@extends('layouts.private.private', ['activePage' => 'roles.create'])
@push('title', 'Roles')
@push('css')
    <style>
        .tarjeta {
            min-height: 19rem;
        }

        .tarjeta__cabecera {
            background-color: #696CFF;
            margin-bottom: 25px;
        }

        .tarjeta__cuerpo {
            color: #000;
        }
    </style>
@endpush
@section('content')
    @include('components.private.messages-session')
    <div class="row d-flex align-items-center mb-3">
        <div class="col-md">
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Rol /</span> Nuevo </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Nombre del rol</h5>
                <!-- Notifications -->
                <div class="card-body">
                    {!! Form::open(['route' => 'roles.store', 'method' => 'POST','class'=>'onsubmit']) !!}
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nombrerol" required>
                            @error('nombrerol')
                            <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4 mx-1">
                        <div class="col-sm-12 p-3 border rounded">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="todos">
                                <label class="form-check-label" for="todos">{{Str::upper('Activar todos')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Dashboard')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.dashboard'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.dashboard', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Sedes')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.sedes'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.sedes', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Lugares')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.lugares'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.lugares', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Tenis')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.tenis'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.tenis', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Inscripciones')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.inscripciones'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.inscripciones', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Categorias')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.categorias'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.categorias', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Noticias')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.noticias'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.noticias', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Usuario')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.usuario'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.usuario', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="card text-white mb-3 tarjeta">
                                <div class="card-header tarjeta__cabecera">{{Str::upper('Roles')}}</div>
                                <div class="card-body tarjeta__cuerpo">
                                    @foreach ($permisos as $permiso)
                                        @if (Str::contains($permiso->name,'.roles'))
                                            <div class="form-check form-switch">
                                                <input class="name form-check-input checkpermiso" type="checkbox"
                                                       role="switch"
                                                       id="{{$permiso->name}}" name="permission[]"
                                                       value="{{$permiso->id}}">
                                                <label class="form-check-label"
                                                       for="{{$permiso->name}}">{{ strtoupper(str_replace('.roles', '', $permiso->name)) }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Crear Rol</button>
                                <a href="{{route('roles.index')}}" role="button"
                                   class="btn btn-outline-danger">Cancelar</a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /Notifications -->
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function () {
            var permisos = $('.checkpermiso');

            $('#todos').on('click', function () {
                if (this.checked) {
                    for (var i = 0; i < permisos.length; i++) {
                        if (permisos[i].type == 'checkbox')
                            permisos[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < permisos.length; i++) {
                        if (permisos[i].type == 'checkbox')
                            permisos[i].checked = false;
                    }
                }
            });

            $('.checkpermiso').on('click', function () {
                if ($('.checkpermiso:checked').length == $('.checkpermiso').length) {
                    $('#todos').prop('checked', true);
                } else {
                    $('#todos').prop('checked', false);
                }
            });
        });
        $('.onsubmit').on('submit', function (e) {
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
