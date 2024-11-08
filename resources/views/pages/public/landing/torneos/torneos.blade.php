@extends('layouts.public.landing')
@push('title', 'Torneos')
@section('content')
@include('components.public.header',['sedes'=>"/ciar/#sedes"])
<section class="banner esInterna position-relative">
    <div class="container padding position-relative">
        <div class="row justify-content-center justify-content-md-start position-relative">
            <div class="col-11 col-md-12 col-xl-12 text-center">
                <div class="padding2"></div>
                <h2 class="titulo altas fw-bold mb-3 mb-lg-4">Torneos</h2>
            </div>
        </div>
    </div>
</section>
<section class="torneos-interna padding interna" id="torneos-interna">
    <div class="container">

        <h2 class="titulo mainColor altas fw-bold mb-5">Organizamos tu Torneo UTR</h2>

        <div class="row justify-content-center align-items-center">
            <div class="col-11 col-md-5">
                <img class="w-100" src="images/torneos.webp" alt="CIAR" />
            </div>
            <div class="col-11 col-md-6 text-start px-5 intro">
                <img class="logo my-4" src="images/utr-oracle.webp" alt="UTR" />
                <p class="lema">Contamos con la licencia UTR para organizar torneos y podemos organizar tu torneo con 4 jugadores del mismo nivel UTR.</p>
                <p>Nuestros torneos son con el modelo Round Robin de tal manera que en una jornada puedes jugar varios partidos al día.</p>
                <p>Para conseguir un buen UTR, esencial para obtener una beca universitaria en USA, se necesitan 30 partidos. Nosotros podemos organizar estos partidos a bajo costo, evitando gastos en viajes internacionales e incurrir en gastos de pasajes aéreos, hoteles, traslados y estadías.</p>
            </div>
        </div>
        <div class="row justify-content-center align-items-center padding2">
            <div class="col-11 col-md-5">
                <a class="btn-cta altas" href="#"><img src="images/arrow-bt.svg" class="icon me-2 me-lg-1" />Reserva tu Torneo aquí</a>
            </div>
        </div>
    </div>
</section>
@include('components.public.footer')
@include('components.public.fixed')
@endsection
