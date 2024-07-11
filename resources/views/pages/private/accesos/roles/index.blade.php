@extends('layouts.private.private', ['activePage' => 'roles.index'])
@push('title', 'Roles')
@section('content')
    @include('components.private.messages-session')
    <div class="row d-flex align-items-center">
        <div class="col-md">
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Roles /</span> Todos </h4>
        </div>
        <div class="col-md text-end">
            <a href="{{route('roles.create')}}" class="btn btn-sm btn-info"><i
                    class="fa-solid fa-lock-keyhole me-1"></i>Nuevo</a>
        </div>
    </div>
    <div class="card pt-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <th>NOMBRE</th>
                        <th>PERMISOS</th>
                        <th>ACCIONES</th>
                        </thead>
                        <tbody>
                        @foreach($roles as $rol)
                            <tr>
                                <td>{{$rol->name}}</td>
                                <td>
                                    @foreach($permisosroles as $pr)
                                        @if($rol->id == $pr->rolid)
                                            <span
                                                class="badge rounded-pill bg-label-dark me-1 mb-1">{{Str::upper($pr->namepermission)}}</span>
                                        @endif
                                    @endforeach
                                </td>
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
                                            <li><a class="dropdown-item d-flex align-items-center"
                                                   href="{{route('roles.edit',$rol->id)}}"><i
                                                        class='bx bx-edit-alt me-1'></i>Editar</a>
                                            </li>
                                            <li>
                                                <form action="{{route('roles.destroy',$rol->id)}}" method="POST"
                                                      class="deleter" data-rolname="{{$rol->name}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="dropdown-item d-flex align-items-center"><i
                                                            class='bx bx-trash-alt me-1'></i>Borrar
                                                    </button>
                                                </form>
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
    </div>
@endsection
@push('js')
    <script>
        // Ejecuta la acción de buscar de la barra de búsqueda.
        // $('#buscador').click(()=>{
        //     alert('The Watcher');
        // });
        $(".deleter").on('submit', function (e) {
            e.preventDefault();
            let rolname = $(this).attr('data-rolname');
            Swal.fire({
                title: "Seguro de eliminar?",
                html: `Vas a eliminar el rol<br/> <p class="mt-2"><strong>${rolname}</strong></p>`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si eliminar",
                cancelButtonText: "No eliminar",
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
        })
    </script>
@endpush
