@extends('layouts.public.landing')
@push('title', 'Noticias')
@section('content')
@include('components.public.header',['sedes'=>'#sedes'])
<section class="banner esInterna position-relative">
    <div class="container padding position-relative">
        <div class="row justify-content-center justify-content-md-start position-relative">
            <div class="col-11 col-md-12 col-xl-12 text-center">
                <div class="padding2"></div>
                <h2 class="titulo altas fw-bold mb-3 mb-lg-4">Noticias</h2>
            </div>
        </div>
    </div>
</section>

<section class="noticias-interna" id="noticias-interna">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h2 class="titulo mainColor altas fw-bold mt-5 mb-4">últimas novedades</h2>
            </div>
        </div>
        <div class="row padding2">
            <div class="col-12 col-md-4 py-4">
                <div class="item-noticias position-relative">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            <a href="#">
                                <img src="{{asset('assets/images/noticias/noticia1.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Machac sorprende a Djokovic para alcanzar su 1ª final ATP Tour</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
                                <img src="{{asset('assets/images/noticias/noticia2.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Lorem ipsum dolor sit amet, consec tetur adip iscing</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
                                <img src="{{asset('assets/images/noticias/noticia3.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Etiam placerat dui in commodo purus hasellus</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
                                <img src="{{asset('assets/images/noticias/noticia4.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Fringilla ullamcorper urna ac tellus luctus imperdietr</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
                                <img src="{{asset('assets/images/noticias/noticia5.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Etiam urna tortor luctus sit amet sem nec ultricies</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
                                <img src="{{asset('assets/images/noticias/noticia6.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Nam hendrerit arcu tortor eu porta mauris faucibus eu</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
                                <img src="{{asset('assets/images/noticias/noticia7.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Fringilla ullamcorper urna ac tellus luctus imperdietr</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
                                <img src="{{asset('assets/images/noticias/noticia8.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Etiam urna tortor luctus sit amet sem nec ultricies</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
                                <img src="{{asset('assets/images/noticias/noticia9.webp')}}" class="w-100" />
                            </a>
                        </figure>

                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item mb-0">
                                    <a href="#">Nam hendrerit arcu tortor eu porta mauris faucibus eu</a>
                                </h3>
                                <div class="edades altas"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
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
