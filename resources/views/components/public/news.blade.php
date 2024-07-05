<section class="noticias padding" id="noticias">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h2 class="titulo mainColor altas fw-bold" data-aos="fade-up" data-aos-duration="1000">Noticias</h2>
            </div>
        </div>
        <div class="row padding3">
            <div class="swiper swNoticias col-11 col-md-12" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
                @if (count($noticias) > 0)
                <div class="swiper-wrapper">
                    @foreach ($noticias as $noticia)
                    <div class="swiper-slide col-12 col-md-4 py-4">
                        <div class="item-noticias position-relative">
                            <div class="contenedor-item">
                                <figure class="imagen-item">
                                    <a href="{{ route('landing.news.details',$noticia->slug) }}">
                                        <img src="{{asset('/storage/noticias/'.$noticia->imagen_destacada)}}" class="w-100" />
                                    </a>
                                </figure>

                                <div class="overlay-item text-start">
                                    <div class="info-item py-3 px-3">
                                        <h3 class="titulo-item mb-0">
                                            <a href="#">{{ Str::ucfirst(Str::limit($noticia->titulo, 80)) }}</a>
                                        </h3>
                                        <div class="edades altas"><a href="{{ route('landing.news.details',$noticia->slug) }}" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="swiper-wrapper">
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                </div>
                @endif
                <div class="swiper-button-prev arrow"><svg>
                        <use href="{{asset('assets/images/icons.svg')}}#arrow-prev" />
                    </svg></div>
                <div class="swiper-button-next arrow"><svg>
                        <use href="{{asset('assets/images/icons.svg')}}#arrow-next" />
                    </svg></div>
            </div>
        </div>
        <div class="justify-content-center">
            <a class="btn-cta altas" href="{{ route('landing.news') }}" data-aos="fade-up" data-aos-duration="1000"><img src="{{asset('assets/images/arrow-bt.svg')}}" class="icon me-2 me-lg-1" /> Más noticias</a>
        </div>
    </div>
</section>
