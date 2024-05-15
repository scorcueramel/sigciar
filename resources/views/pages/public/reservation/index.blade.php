@extends('layouts.public.app')
@push('title','Reservas')
@push('css')
<style>
    .circulo {
        height: 27px;
        width: 10px !important;
        border: 1px solid #000;
        border-radius: 50%;
    }

    .title_rse {
        font-family: "Reddit Sans";
    }
</style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="row bg-secondary py-5">
        <div class="col-md-12">
            <div class="row py-5">
                <div class="col-md-12 text-center">
                    <h1 class="title_rse text-white">Reservas de Espacios</h1>
                </div>
            </div>
            <div class="row py-5">
                <div class="col-4 text-end">
                    <small>
                        <i class="fa-duotone fa-circle" style="color: yellow"></i>
                        Disponible
                    </small>
                </div>
                <div class="col-4 text-center">
                    <small>
                        <i class="fa-duotone fa-circle" style="color: yellow"></i>
                        Ocupado
                    </small>
                </div>
                <div class="col-4">
                    <small>
                        <i class="fa-duotone fa-circle" style="color: yellow"></i>
                        Sleccionado
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
