<section class="actividades-inicio bgDark padding" id="actividades">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 text-start">
                <h2 class="titulo altas fw-bold mb-3 mb-lg-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="500">Centro internacional <span data-aos="fade-left" data-aos-duration="1000" data-aos-delay="700">de alto rendimiento</span></h2>
            </div>
            <div class="col-12 col-md-6 text-start mt-5">
                <p data-aos="fade-right" data-aos-duration="1000" data-aos-delay="500">Conoce todas nuestras actividades</p>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row padding3 justify-content-center">
            <div class="swiper swActividades col-11 col-md-12" data-aos="fade-up" data-aos-duration="1000">
                @if (!is_null($activitystarts))
                <div class="swiper-wrapper">
                    @foreach ($activitystarts as $acts)
                    <div class="swiper-slide col-11 col-md-3 py-4">
                        <div class="item-actividades-inicio position-relative">
                            <div class="contenedor-item">
                                <figure class="imagen-item">
                                    <a href="#">
                                        <img src="{{asset('assets/images/actividades/nutricion.webp')}}" class="w-100" />
                                    </a>
                                </figure>

                                <div class="overlay-item text-start">
                                    <div class="info-item py-3 px-3">
                                        <h3 class="titulo-item mb-0 altas">
                                            <a href="#">{{$acts->titulo}}</a>
                                        </h3>
                                        <div class="edades"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="swiper-wrapper">
                    <div class="swiper-slide col-11 col-md-3 py-4">
                        <div class="item-actividades-inicio position-relative">
                            <div class="contenedor-item">
                                <figure class="imagen-item">
                                    <a href="#">
                                        <img src="{{asset('assets/images/actividades/gimnasio.webp')}}" class="w-100" />
                                    </a>
                                </figure>

                                <div class="overlay-item text-start">
                                    <div class="info-item py-3 px-3">
                                        <h3 class="titulo-item mb-0 altas">
                                            <a href="#">Gimnasio</a>
                                        </h3>
                                        <div class="edades"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide col-11 col-md-3 py-4">
                        <div class="item-actividades-inicio position-relative">
                            <div class="contenedor-item">
                                <figure class="imagen-item">
                                    <a href="#">
                                        <img src="{{asset('assets/images/actividades/sala-sense-arena.webp')}}" class="w-100" />
                                    </a>
                                </figure>

                                <div class="overlay-item text-start">
                                    <div class="info-item py-3 px-3">
                                        <h3 class="titulo-item mb-0 altas">
                                            <a href="#">Sala Sense Arena</a>
                                        </h3>
                                        <div class="edades"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide col-11 col-md-3 py-4">
                        <div class="item-actividades-inicio position-relative">
                            <div class="contenedor-item">
                                <figure class="imagen-item">
                                    <a href="#">
                                        <img src="{{asset('assets/images/actividades/yoga.webp')}}" class="w-100" />
                                    </a>
                                </figure>

                                <div class="overlay-item text-start">
                                    <div class="info-item py-3 px-3">
                                        <h3 class="titulo-item mb-0 altas">
                                            <a href="#">Yoga</a>
                                        </h3>
                                        <div class="edades"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide col-11 col-md-3 py-4">
                        <div class="item-actividades-inicio position-relative">
                            <div class="contenedor-item">
                                <figure class="imagen-item">
                                    <a href="#">
                                        <img src="{{asset('assets/images/actividades/nutricion.webp')}}" class="w-100" />
                                    </a>
                                </figure>

                                <div class="overlay-item text-start">
                                    <div class="info-item py-3 px-3">
                                        <h3 class="titulo-item mb-0 altas">
                                            <a href="#">Nutrición</a>
                                        </h3>
                                        <div class="edades"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide col-11 col-md-3 py-4">
                        <div class="item-actividades-inicio position-relative">
                            <div class="contenedor-item">
                                <figure class="imagen-item">
                                    <a href="#">
                                        <img src="{{asset('assets/images/actividades/foda-tactico.webp')}}" class="w-100" />
                                    </a>
                                </figure>

                                <div class="overlay-item text-start">
                                    <div class="info-item py-3 px-3">
                                        <h3 class="titulo-item mb-0 altas">
                                            <a href="#">Foda táctico</a>
                                        </h3>
                                        <div class="edades"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide col-11 col-md-3 py-4">
                        <div class="item-actividades-inicio position-relative">
                            <div class="contenedor-item">
                                <figure class="imagen-item">
                                    <a href="#">
                                        <img src="{{asset('assets/images/actividades/game-set-match.webp')}}" class="w-100" />
                                    </a>
                                </figure>

                                <div class="overlay-item text-start">
                                    <div class="info-item py-3 px-3">
                                        <h3 class="titulo-item mb-0 altas">
                                            <a href="#">Game Set Match</a>
                                        </h3>
                                        <div class="edades"><a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="swiper-button-prev arrow">
                    <svg>
                        <use href="{{asset('assets/images/icons.svg')}}#arrow-prev" />
                    </svg>
                </div>
                <div class="swiper-button-next arrow">
                    <svg>
                        <use href="{{asset('assets/images/icons.svg')}}#arrow-next" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="justify-content-center">
            <a class="btn-cta altas" href="actividades.php" data-aos="fade-up" data-aos-duration="1000"><img src="{{asset('assets/images/arrow-bt.svg')}}" class="icon me-2 me-lg-1" />Todas las actividades</a>
        </div>
    </div>
</section>
