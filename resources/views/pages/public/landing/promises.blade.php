@extends('layouts.public.landing')
@push('title', 'Actividades')
@section('content')
@include('components.public.header',['sedes'=>"/ciar/#sedes"])
<section class="banner esInterna position-relative">
    <div class="container padding position-relative">
        <div class="row justify-content-center justify-content-md-start position-relative">
            <div class="col-11 col-md-12 col-xl-12 text-center">
                <div class="padding2"></div>
                <h2 class="titulo altas fw-bold mb-3 mb-lg-4">Nuestras Promesas</h2>
            </div>
        </div>
    </div>
</section>
<section class="promesas-interna" id="promesas-interna">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h2 class="titulo mainColor altas fw-bold mt-5 mb-4">Apoyemos a jóvenes promesas</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut diam id risus molestie aliquam. Nam vel hendrerit lacus. Praesent orci dolor, pretium non efficitur ut, volutpat ac ante.</p>
            </div>
        </div>
        <div class="row padding2">
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/javier-heredia.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Javier Heredia</a>
                                </h3>
                                <div class="edades altas">14 años<a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/promesa2.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Cesar Araoz</a>
                                </h3>
                                <div class="edades altas">14 años <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/promesa3.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Julio Laos</a>
                                </h3>
                                <div class="edades altas">14 años <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/promesa4.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Jorge Milla</a>
                                </h3>
                                <div class="edades altas">14 años <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/promesa5.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Celia Garcia</a>
                                </h3>
                                <div class="edades altas">14 años <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/promesa6.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Brissa Klein</a>
                                </h3>
                                <div class="edades altas">14 años <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/promesa7.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Javier Heredia</a>
                                </h3>
                                <div class="edades altas">14 años <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/promesa8.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Javier Heredia</a>
                                </h3>
                                <div class="edades altas">14 años <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/promesas/promesa9.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="#">Javier Heredia</a>
                                </h3>
                                <div class="edades altas">14 años <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                            </div>
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
