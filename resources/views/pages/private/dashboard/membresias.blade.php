@extends('layouts.private.private', ['activePage' => 'membresias'])
@push('title', 'Membresias')
@section('content')
    <div class="row">
        @can('calendario.dashboard')
            <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="pt-4 px-3 mb-4">
                            <h5 class="text-nowrap mb-2">Gestión de membresias</h5>
                            <div class="row mt-4">
                                <div class="col-sm-12 col-md-2">
                                    <label for="sedes">Sede</label>
                                    <select class="form-select" aria-label="sedes" id="sedes" name="sede">
                                        <option value="" selected>SELECCIONAR SEDE</option>
                                        @foreach($sedes as $s)
                                            <option value="{{$s->id}}">{{$s->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="lugares">Lugar</label>
                                    <select class="form-select" aria-label="Lugares" name="lugar" id="lugares" disabled>
                                        <option value="" selected>SELECCIONAR LUGAR</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="programas">Programas</label>
                                    <select class="form-select" aria-label="programas" id="programas"
                                            name="programas" disabled>
                                        <option value="" selected>SELECCIONAR PROGRAMA</option>
                                    </select>
                                    <span class="d-none program-validate"></span>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="estados">Estados</label>
                                    <select class="form-select" aria-label="estados" id="estados"
                                            name="estados" disabled>
                                        <option value="" selected disabled>SELECCIONAR ESTADO</option>
                                        <option value="null">TODOS</option>
                                        <option value="PE">PENDIENTE</option>
                                        <option value="CA">CANCELADO</option>
                                        <option value="RE">RETIRADO</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <button class="btn btn-primary mt-4 disabled" type="button" id="btnBuscar">Búscar
                                    </button>
                                    <button class="btn btn-danger mt-4 disabled" type="button" id="btnLimpiar">Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 mb-3 d-none" id="table-section">
                            <div class="col-md-12 mx-2">
                                <div class="d-none text-center" id="loading-data">
                                    <div class="spinner-border text-primary h2" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="h5">
                                        Cargando ...
                                    </div>
                                </div>
                                <div class="text-nowrap table-responsive d-none">
                                    <table class="table table-striped table-borderless table-hover nowrap" id="table"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NOMBRES</th>
                                            <th>DOCUMENTO</th>
                                            <th>PROGRAMA</th>
                                            <th>SEDE</th>
                                            <th>LUGAR</th>
                                            <th>PENDIENTES</th>
                                            <th>CANCELADO</th>
                                            <th>RETIRADO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    @include('components.private.modal',['withTitle'=>true])
@endsection
@push('js')
    <script src="{{asset('assets/js/personalized/membership.js')}}"></script>
@endpush