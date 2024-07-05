@extends('layouts.private.private', ['activePage' => 'roles.create'])
@push('title', 'Roles')
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
                <!-- Notifications -->
                <h5 class="card-header">Nombre para del nuevo rol</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-borderless border-bottom">
                        <thead>
                        <tr>
                            <th class="text-nowrap">Permisos</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-nowrap">
                                <label for="defaultCheck1">
                                    Permiso 1
                                </label>
                            </td>
                            <td>
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox" id="defaultCheck1" checked/>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <form action="javascript:void(0);">
                        <div class="row">
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Crear Rol</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Notifications -->
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
    </script>
@endpush
