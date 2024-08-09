@extends('layouts.private.private', ['activePage' => 'calendario.general'])
@push('title', 'Panel de Administración')
@section('content')
<div class="row">
    @can('calendario.dashboard')
    <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
            <div class="row row-bordered g-0">
                <div class="pt-4 px-3">
                    <h5 class="text-nowrap mb-2">Calendario Genelares de Actividades</h5>
                    <div class="row mt-5">
                        <div class="col-sm-12 col-md-2">
                            <label for="">Sede</label>
                            <select class="form-select" aria-label="sedes" id="sedes">
                                <option value="" disabled selected>Selecciona una sede</option>
                                <option value="0">TODOS</option>
                                @foreach ($sedes as $sede)
                                <option value="{{$sede->id}}">{{$sede->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="">Lugar</label>
                            <select class="form-select" aria-label="Lugares" id="lugares" disabled>
                                <option value="" disabled selected>Selecciona un lugar</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="">Tipó de Servicio</label>
                            <select class="form-select" aria-label="tiposervicio">
                                <option value="" disabled selected>Selecciona un tipo de servicio</option>
                                @foreach ($tiposervicios as $tiposervicio)
                                <option value="{{$tiposervicio->id}}">{{$tiposervicio->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <button class="btn btn-primary mt-4">Búscar</button>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 mb-3">
                    <div class="col-md-12 mx-2">
                        <div id='calendario'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
@push('js')
<script src="{{asset('assets/template/js/personalized/activity-calendar.js')}}"></script>
@endpush
