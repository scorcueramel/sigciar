@extends('layouts.private.private', ['activePage' => 'membresias'])
@push('title', 'Membresias')
@section('content')
    <div class="row">
        @can('calendario.dashboard')
            <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="pt-4 px-3">
                            <h5 class="text-nowrap mb-2">Membresias</h5>
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
                                <div class="col-sm-12 col-md-3">
                                    <button class="btn btn-primary mt-4" type="button" id="btnBuscar">Búscar</button>
                                    <button class="btn btn-danger mt-4" type="button" id="btnLimpiar">Limpiar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 mb-3">
                            <div class="col-md-12 mx-2">
                                <div id='listado-membresias'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
@push('js')
    <script src="{{asset('assets/js/personalized/membership.js')}}"></script>
@endpush