@extends('layouts.private.private', ['activePage' => 'usuarios.index'])
@push('title', 'Usuarios')
@section('content')
    @include('components.private.messages-session')
    <div class="row d-flex align-items-center">
        <div class="col-md">
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Usuarios /</span> Todas </h4>
        </div>
        <div class="col-md text-end">
            <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-info"><i
                    class="fa-solid fa-user-plus me-1"></i>Nuevo</a>
        </div>
    </div>
    <div class="row">
        <div class="card pt-2">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="table">
                    <thead>
                    <tr>
                        <th>TIPO DE DOCUMENTO</th>
                        <th>NRO DE DOCUMENTO</th>
                        <th style="width: 250px">NOMBRES Y APELLIDOS</th>
                        <th>MOVÍL</th>
                        <th>ESTADO</th>
                        <th>CORREO</th>
                        <th>ROLES</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($personas as $persona)
                        <tr>
                            <td>{{$persona->abreviatura}}</td>
                            <td>{{$persona->documento}}</td>
                            <td>{{$persona->nombres}} {{$persona->apepaterno}} {{$persona->apematerno}}</td>
                            <td>{{$persona->movil}}</td>
                            <td>
                                <span class="badge bg-label-{{$persona->estado == 'A' ? 'success' : 'danger'}}">
                                    {{$persona->estado == 'A' ? 'ACTIVO' : 'BLOQUEADO'}}
                                </span>
                            </td>
                            <td>{{$persona->email}}</td>
                            @if($persona->tipocategoria_id == 2)
                            <td>
                            <span class="badge bg-label-warning">
                                MIEMBRO
                            </span>
                            </td>
                            @else
                            <td>
                                @foreach($usuarios as $usuario)
                                    @if($usuario->id == $persona->usuario_id)
                                        @foreach ($usuario->getRoleNames() as $rolName)
                                            <span class="badge bg-label-primary">{{ $rolName }}
                                            </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            </td>
                            @endif
                            <td>
                                <div class="btn-group">
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow btn-sm"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center"
                                               href="{{route('usuarios.edit',$persona->id)}}">
                                                <i class='bx bx-edit-alt me-1'></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            @if($persona->estado == 'A')
                                                <form action="{{route('usuarios.destroy',$persona->id)}}" method="POST"
                                                      class="deleter" data-personaname="{{$persona->nombres}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="dropdown-item d-flex align-items-center bloquear"><i
                                                            class="fa-solid fa-hexagon-exclamation me-1"></i> Bloquear acceso
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{route('usuarios.destroy',$persona->id)}}" method="POST"
                                                      class="deleter" data-personaname="{{$persona->name}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="dropdown-item d-flex align-items-center desbloquear"><i
                                                            class="fa-solid fa-hexagon-check me-1"></i> Conceder Acceso
                                                    </button>
                                                </form>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#table').DataTable({
            paging: true,
            info: true,
            "order": [
                [0, "DESC"]
            ],
            responsive: true,
            autoWidth: false,
            processing: true,
            "pageLength": 10,
            "aLengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ],
            "language": {
                "lengthMenu": "Mostrar " +
                    `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value='10'>10</option>
                            <option value='15'>15</option>
                            <option value='20'>20</option>
                            <option value='-1'>Todos</option>
                        </select>` +
                    " Registros Por Página",
                "zeroRecords": "Sin Resultados",
                "info": "Mostrando Página _PAGE_ de _PAGES_",
                "infoEmpty": "Sin Resultados",
                "infoFiltered": "(Filtro de _MAX_ Registros Totales)",
                "search": "Búscar ",
                "paginate": {
                    "next": "›",
                    "previous": "‹"
                }
            },
        });

        $('.bloquear').on('click',function(){
            $(".deleter").on('submit', function (e) {
                e.preventDefault();
                let personaname = $(this).attr('data-personaname');
                Swal.fire({
                    title: "Bloquear usuario?",
                    html: `Vas a <strong>BLOQUEAR</strong> al usuario<br/> <p class="mt-2"><strong>${personaname}</strong>, esto le impedirá el acceso al sistema.</p>`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si Bloquear",
                    cancelButtonText: "No Bloquear",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'info',
                            html: "Espere un momento porfavor ...",
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        this.submit();
                    }
                });
            });
        });

        $(".desbloquear").on('click',function(){
            $(".deleter").on('submit', function (e) {
                e.preventDefault();
                let personaname = $(this).attr('data-personaname');
                Swal.fire({
                    title: "Desbloquear usuario?",
                    html: `Vas a <strong>DESBLOQUEAR</strong> al usuario<br/> <p class="mt-2"><strong>${personaname}</strong>, el usuario volvera a contar con acceso al sistema.</p>`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si Desbloquear",
                    cancelButtonText: "No Desbloquear",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'info',
                            html: "Espere un momento porfavor ...",
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush
