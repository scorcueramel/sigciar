<section class="tenis padding" id="tenis">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h2 class="titulo mainColor altas fw-bold mb-4" data-aos="fade-up" data-aos-duration="1000">¡Entrena tenis hoy!</h2>
                <p data-aos="fade-up" data-aos-duration="1000">Elige tu horario e inscríbete en línea</p>
            </div>
        </div>
        <div class="row padding3 justify-content-center">
            <div class="swiper swTenis col-11 col-md-11" data-aos="fade-up" data-aos-duration="1000">
                @if(!is_null($actividades))
                    <div class="swiper-wrapper">
                    @foreach($actividades as $actividad)
                        <div class="swiper-slide col-12 col-md-4 py-4">
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
                                        <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    </div>
                @else
                <div class="swiper-wrapper">
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                                            <a href="#">Tenis Adultos</a>
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
                    <div class="swiper-slide col-12 col-md-4 py-4">
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
                                            <a href="#">Tenis para Familias</a>
                                        </h3>
                                        <div class="edades altas"></div>
                                    </div>
                                </div>
                                <div class="tag-item">libre</div>
                                <div class="precio text-start">
                                    S/ 45 <span class="frecuencia">/ por participante</span>
                                    <a href="#" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a>
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
    </div>
</section>
