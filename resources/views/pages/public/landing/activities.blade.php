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
        <div class="row padding2">
            <div class="col-12 col-md-4 py-4">
                <div class="item-actividades position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/actividades/tenis-pequenos.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Tenis pequeños</a>
                                </h3>
                                <div class="edades altas">4-9 años</div>
                            </div>
                        </div>
                        <div class="tag-item">clases</div>
                        <div class="precio text-start">
                            desde S/ 200 <span class="frecuencia">/ 4 clases al mes</span>
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
                                <img src="{{asset('assets/images/actividades/tenis-ninos.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Tenis niños</a>
                                </h3>
                                <div class="edades altas">9-12 años</div>
                            </div>
                        </div>
                        <div class="tag-item">clases</div>
                        <div class="precio text-start">
                            desde S/ 200 <span class="frecuencia">/ 4 clases al mes</span>
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
                                <img src="{{asset('assets/images/actividades/tenis-jovenes.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Tenis jóvenes</a>
                                </h3>
                                <div class="edades altas">13-18 años</div>
                            </div>
                        </div>
                        <div class="tag-item">clases</div>
                        <div class="precio text-start">
                            desde S/ 200 <span class="frecuencia">/ 4 clases al mes</span>
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
                                <img src="{{asset('assets/images/actividades/tenis-adultos.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Tenis adultos</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">clases</div>
                        <div class="precio text-start">
                            desde S/ 200 <span class="frecuencia">/ 4 clases al mes</span>
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
                                <img src="{{asset('assets/images/actividades/tenis-familias.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Tenis para familias</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">libre</div>
                        <div class="precio text-start">
                            desde S/ 45 <span class="frecuencia">/ cada participante</span>
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
                                <img src="{{asset('assets/images/actividades/foda-tactico.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Foda táctico</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">clínica</div>
                        <div class="precio text-start">
                            S/ 200 <span class="frecuencia">/ 4 horas</span>
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
                                <img src="{{asset('assets/images/actividades/estudio-biomecanico.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Estudio biomecanico</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">clínica</div>
                        <div class="precio text-start">
                            S/ 250 <span class="frecuencia">/ 2 horas</span>
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
                                <img src="{{asset('assets/images/actividades/game-set-match.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Game Set Match</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">clínica</div>
                        <div class="precio text-start">
                            S/ 350 <span class="frecuencia">/ 3 horas</span>
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
                                <img src="{{asset('assets/images/actividades/mejora-tu-saque.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Mejora tu saque</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">clínica</div>
                        <div class="precio text-start">
                            S/ 300 <span class="frecuencia">/ 3 horas</span>
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
                                <img src="{{asset('assets/images/actividades/nutricion.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Nutrición</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">salud</div>
                        <div class="precio text-start">
                            S/ 150 <span class="frecuencia">/ 1 hora</span>
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
                                <img src="{{asset('assets/images/actividades/fixu-fisio.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Fixu - Fisio</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">salud</div>
                        <div class="precio text-start">
                            S/ 150 <span class="frecuencia">/ 1 hora</span>
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
                                <img src="{{asset('assets/images/actividades/endocrinologia.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Endocrinologia</a>
                                </h3>
                                <div class="edades altas"></div>
                            </div>
                        </div>
                        <div class="tag-item">salud</div>
                        <div class="precio text-start">
                            S/ 120 <span class="frecuencia">/ 1 hora</span>
                            <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@include('components.public.footer')
@include('components.public.fixed')
@endsection
