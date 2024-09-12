@extends('layouts.public.landing')
@push('title', 'Actividades')
@section('content')
@include('components.public.header',['sedes'=>"/ciar/#sedes"])
<section class="banner esInterna position-relative">
    <div class="container padding position-relative">
        <div class="row justify-content-center justify-content-md-start position-relative">
            <div class="col-11 col-md-12 col-xl-12 text-center">
                <div class="padding2"></div>
                <h2 class="titulo altas fw-bold mb-3 mb-lg-4">Actividades</h2>
            </div>
        </div>
    </div>
</section>
<section class="actividades-interna" id="actividades-interna">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h2 class="titulo mainColor altas fw-bold mt-5 mb-4">¡Entrena Hoy!</h2>
                <p>Elige tu actividad e inscríbete ahora:</p>
            </div>
        </div>

        @if(count($actividades) <= 0)
            <div class="row padding2">
                <div class="col-12 col-md-4 py-4">
                    <div class="item-actividades position-relative">
                        <div class="contenedor-item">
                            <figure class="imagen-item">
                                <a href="#">
                                    <img src="{{asset('assets/images/default-img.png')}}" class="w-100" />
                                </a>
                            </figure>

                            <div class="overlay-item text-start">
                                <div class="info-item py-3 px-3">
                                    <h3 class="titulo-item altas mb-0">
                                        <a href="#">Título de la tarjeta</a>
                                    </h3>
                                    <div class="edades altas">Subtitulo de la tarjeta</div>
                                </div>
                            </div>
                            <div class="tag-item">clases</div>
                            <div class="precio text-start">
                                precio <span class="frecuencia"> cantidad de clases</span>
                                <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4 py-4">
                    <div class="item-actividades position-relative">
                        <div class="contenedor-item">
                            <figure class="imagen-item">
                                <a href="#">
                                    <img src="{{asset('assets/images/default-img.png')}}" class="w-100" />
                                </a>
                            </figure>

                            <div class="overlay-item text-start">
                                <div class="info-item py-3 px-3">
                                    <h3 class="titulo-item altas mb-0">
                                        <a href="#">Título de la tarjeta</a>
                                    </h3>
                                    <div class="edades altas">Subtitulo de la tarjeta</div>
                                </div>
                            </div>
                            <div class="tag-item">clases</div>
                            <div class="precio text-start">
                                precio <span class="frecuencia"> cantidad de clases</span>
                                <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4 py-4">
                    <div class="item-actividades position-relative">
                        <div class="contenedor-item">
                            <figure class="imagen-item">
                                <a href="#">
                                    <img src="{{asset('assets/images/default-img.png')}}" class="w-100" />
                                </a>
                            </figure>

                            <div class="overlay-item text-start">
                                <div class="info-item py-3 px-3">
                                    <h3 class="titulo-item altas mb-0">
                                        <a href="#">Título de la tarjeta</a>
                                    </h3>
                                    <div class="edades altas">Subtitulo de la tarjeta</div>
                                </div>
                            </div>
                            <div class="tag-item">clases</div>
                            <div class="precio text-start">
                                precio <span class="frecuencia"> cantidad de clases</span>
                                <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @else
            <div class="row padding2">
            @foreach($actividades as $actividad)
                <div class="col-12 col-md-4 py-4">
                    <div class="item-actividades position-relative">
                        <div class="contenedor-item">
                            <figure class="imagen-item">
                                <a href="#">
                                    <img src="{{asset('/storage/subtipos/'.$actividad->imagen)}}" class="w-100" />
                                </a>
                            </figure>

                            <div class="overlay-item text-start">
                                <div class="info-item py-3 px-3">
                                    <h3 class="titulo-item altas mb-0">
                                        <a href="#">{{$actividad->titulo}}</a>
                                    </h3>
                                    <div class="edades altas">{{$actividad->subtitulo}}</div>
                                </div>
                            </div>
                            <div class="tag-item">{{$actividad->medicion}}</div>
                            <div class="precio text-start">
                                desde S/ {{$actividad->desde}} <span class="frecuencia">/ 4 clases al mes</span>
                                <a href="{{route('actividades.detalle',$actividad->servicios_id)}}" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
            </div>
        @endif
    </div>
</section>
@include('components.public.footer')
@include('components.public.fixed')
@endsection
