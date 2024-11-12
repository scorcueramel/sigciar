@extends('layouts.public.public')
@push('title', 'Reservas')
@push('paidhead')
<script type="text/javascript"
    src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
    kr-public-key="{{config('services.izipay.public_key')}}" kr-post-url-success="{{route('paid.izipay')}}">
</script>

<link rel="stylesheet"
    href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.css">
<script
    src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js">
</script>
@endpush
@push('css')
<style>
    input {
        /* background-color: transparent !important; */
        border: 0 !important;
    }

    /*
    label,input{
        font-size: 16px !important;
    }

    input{
        font-weight: bold !important;
        color: #272F59 !important;
    } */
</style>
@endpush
@section('content')
@include('components.public.navbar',['profile'=>true])
<div class="container-fluid">
    <input type="hidden" id="loginCheck" value="{{ Auth::check() }}">
    <div class="row d-flex justify-content-center bg-secondary py-4">
        <div class="col-md-6">
            <div class="row mb-5">
                <div class="col-md-12 text-center">
                    <h1 class="title_rse text-white">Detalles de tu Reserva</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-4 pb-3 d-flex justify-content-center">
        @if(Session::has('warning'))
        <div class="col-md-10">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Lo sentimos!</strong> {{Session::get('warning')}}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>
    <div class="row py-4 d-flex justify-content-center">
        <div class="card w-75" style="background-color: #fff !important;">
            <div class="card-body">
                <input type="hidden" value="{{$datosReserva['codigo']}}">
                <div class="row d-flex justify-content-between">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="mb-3">
                            <label for="inicio" class="form-label">Inicio</label>
                            <input type="text" class="form-control" value="{{$datosReserva['inicio']}}" id="inicio" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="fin" class="form-label">Fin</label>
                            <input type="text" class="form-control" value="{{$datosReserva['fin']}}" id="fin" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="sedeseleccionada" class="form-label">Sede</label>
                            <input type="text" class="form-control" value="{{$datosReserva['sede']}}" id="sedeseleccionada" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="lugarseleccionado" class="form-label">Lugar</label>
                            <input type="text" class="form-control" value="{{$datosReserva['lugarModal']}}" id="lugarseleccionado" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" class="form-control" value="{{$datosReserva['precio']}}.00" id="precio" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 d-flex justify-content-center align-items-center">
                        <div class="kr-embedded" kr-form-token="{{$formToken}}">
                            <div class="kr-pan"></div>
                            <div class="kr-expiry"></div>
                            <div class="kr-security-code"></div>
                            <button class="kr-payment-button"></button>
                            <div class="kr-form-error"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
