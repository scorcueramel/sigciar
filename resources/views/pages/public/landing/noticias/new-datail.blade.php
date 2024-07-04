@extends('layouts.public.landing')
@push('title', 'Actividades')
@section('content')
@include('components.public.header',['sedes'=>"/ciar/#sedes"])
<section class="banner esInterna position-relative">
    <div class="container padding position-relative">
        <div class="row justify-content-center justify-content-md-start position-relative">
            <div class="col-11 col-md-12 col-xl-12 text-center">
                <div class="padding2"></div>
                <h2 class="titulo altas fw-bold mb-3 mb-lg-4">{{$noticia->titulo}}</h2>
            </div>
        </div>
    </div>
</section>
<section class="noticias-detalle mt-5" id="noticias-detalle">
    <div class="container">
        <!-- <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <p class="fecha">May 24, 2024</p>
                    <h2 class="titulo mainColor altas fw-bold mt-2 mb-5">Machac sorprende a Djokovic para alcanzar su 1ª
                        final ATP Tour</h2>
                    <img src="images/noticias/noticia1.webp" class="w-100"
                         alt="Machac sorprende a Djokovic para alcanzar su 1ª final ATP Tour"/>
                    <div class="row text-start mt-5">
                        <p>Tomas Machac firmó este viernes la mayor victoria de su carrera en el Gonet Geneva Open,
                            donde sorprendió al No. 1 mundial Novak Djokovic 6-4, 0-6, 6-1 para alcanzar su primera
                            final ATP Tour.</p>

                        <p>El checo, presente en su primera semifinal en el circuito, logró moverse con soltura para
                            aguantar el ritmo de pelota a Djokovic. En un partido de ida y vuelta, Machac remontó un 1-4
                            en la primera manga antes de recibir un rosco de Djokovic en el segundo parcial. Sin
                            embargo, tras encajar siete juego consecutivos del serbio, Machac respondió ganando los
                            últimos seis juegos del partido para alcanzar la victoria.</p>

                        <p>"No tengo palabra en este momento, he luchado por cualquier pelota", dijo Machac. "Cuando te
                            enfrentas a Novak debes confiar. Hay que intentar jugar a tu máximo nivel y ver qué sucede".
                            Djokovic sufrió físicamente y llegó a recibir atención médica al final del primer set. El
                            balcánico, convertido en el semifinalista más veterano en la historia del torneo, pareció
                            recuperado en el segundo set y recuperó su gran movilidad antes de decaer en el tramo final
                            del partido.</p>

                        <p>El campeón de 98 títulos, que buscaba su primera final de la temporada, llegará a Roland
                            Garros para enfrentar a Pierre-Hugues Herbert en la primera ronda. Djokovic intentará
                            mantener el No. 1 del PIF ATP Rankings en París, donde Jannik Sinner puede sucederle en la
                            cima del circuito.</p>
                    </div>
                </div>
            </div>

            <div class="row padding2">
                <h2 class="titulo mainColor altas fw-bold mt-2 mb-2 text-start">Más noticias</h2>
                <div class="col-12 col-md-4 py-4">
                    <div class="item-noticias position-relative">
                        <div class="contenedor-item">
                            <figure class="imagen-item">
                                <a href="#">
                                    <img src="images/noticias/noticia1.webp" class="w-100"/>
                                </a>
                            </figure>

                            <div class="overlay-item text-start">
                                <div class="info-item py-3 px-3">
                                    <h3 class="titulo-item mb-0">
                                        <a href="#">Machac sorprende a Djokovic para alcanzar su 1ª final ATP Tour</a>
                                    </h3>
                                    <div class="edades altas"><a href="#" class="enlace"><img
                                                src="images/link.svg"/></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 py-4">
                    <div class="item-noticias position-relative">
                        <div class="contenedor-item">
                            <figure class="imagen-item">
                                <a href="#">
                                    <img src="images/noticias/noticia2.webp" class="w-100"/>
                                </a>
                            </figure>

                            <div class="overlay-item text-start">
                                <div class="info-item py-3 px-3">
                                    <h3 class="titulo-item mb-0">
                                        <a href="#">Lorem ipsum dolor sit amet, consec tetur adip iscing</a>
                                    </h3>
                                    <div class="edades altas"><a href="#" class="enlace"><img
                                                src="images/link.svg"/></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 py-4">
                    <div class="item-noticias position-relative">
                        <div class="contenedor-item">
                            <figure class="imagen-item">
                                <a href="#">
                                    <img src="images/noticias/noticia3.webp" class="w-100"/>
                                </a>
                            </figure>

                            <div class="overlay-item text-start">
                                <div class="info-item py-3 px-3">
                                    <h3 class="titulo-item mb-0">
                                        <a href="#">Etiam placerat dui in commodo purus hasellus</a>
                                    </h3>
                                    <div class="edades altas"><a href="#" class="enlace"><img
                                                src="images/link.svg"/></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        <div class="row d-flex justify-content-between">
            <div class="col-md-9">
                {!! $noticia->cuerpo !!}
            </div>
            <div class="col-md-3 mt-4">
                @if (count($noticiasCategoria) > 0)
                <div class="row mb-3">
                    <div class="col-md-12 mb-3 mt-2">
                        Mas noticias de interés
                    </div>
                    <div class="col-md-12">
                        @foreach ($noticiasCategoria as $notcat)
                        <a href="{{ route('landing.news.details',$notcat->slug) }}" style="text-decoration: none; cursor: pointer">
                            <div class="card" style="width: 16rem; background: #f1f1f1; border-radius: 10px; padding:10px">
                                <img class="card-img-top img-fluid img-thumbnail" src="{{asset('/storage/noticias/'.$notcat->imagen_destacada)}}" alt="Card image cap" width="200">
                                <div class="card-body mt-2">
                                    <p style="font-size:14px">{{ Str::ucfirst(Str::limit($notcat->titulo, 60)) }}</p>
                                    Ver más
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@include('components.public.footer')
@include('components.public.fixed')
@endsection
