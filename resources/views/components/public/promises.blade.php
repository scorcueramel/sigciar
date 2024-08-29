<section class="promesas padding bgLightblue" id="promesas">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h2 class="titulo mainColor altas fw-bold" data-aos="fade-up" data-aos-duration="1000">Nuestras Promesas</h2>
                <p data-aos="fade-up" data-aos-duration="1000">Apoyemos a nuestras jóvenes promesas</p>
            </div>
        </div>
        <div class="row padding3 justify-content-center">
            <div class="col-12 col-md-10">
                @if (count($promesas) > 0)
                <ul class="cloud-tags">
                    @foreach ($promesas as $promesa)
                    <li class="p-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="50">
                        <a href="#">
                            <div class="bgWhite item d-flex justify-content-center align-items-center text-start">
                                <img class="foto me-3" src="{{asset('/storage/promesas/'.$promesa->foto)}}" alt="">
                                <ul class="info nolist mb-0 py-3">
                                    <li>
                                        <h3 class="nombre black mb-0 altas fw-bold">{{ $promesa->nombre }}</h3>
                                    </li>
                                    <li class="edad">{{$promesa->edad}}</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <ul class="cloud-tags">
                    <li class="p-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="50">
                        <a href="#">
                            <div class="bgWhite item d-flex justify-content-center align-items-center text-start">
                                <img class="foto me-3" src="{{asset('assets/images/promesas/promesa2.webp')}}" alt="">
                                <ul class="info nolist mb-0 py-3">
                                    <li>
                                        <h3 class="nombre black mb-0 altas fw-bold">Jhon Heredia</h3>
                                    </li>
                                    <li class="edad">16 años</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    <li class="p-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <a href="#">
                            <div class="bgWhite item d-flex justify-content-center align-items-center text-start">
                                <img class="foto me-3" src="{{asset('assets/images/promesas/promesa3.webp')}}" alt="">
                                <ul class="info nolist mb-0 py-3">
                                    <li>
                                        <h3 class="nombre black mb-0 altas fw-bold">Christian Valverde</h3>
                                    </li>
                                    <li class="edad">12 años</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    <li class="p-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
                        <a href="#">
                            <div class="bgWhite item d-flex justify-content-center align-items-center text-start">
                                <img class="foto me-3" src="{{asset('assets/images/promesas/promesa4.webp')}}" alt="">
                                <ul class="info nolist mb-0 py-3">
                                    <li>
                                        <h3 class="nombre black mb-0 altas fw-bold">Christian Valverde</h3>
                                    </li>
                                    <li class="edad">15 años</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    <li class="p-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <a href="#">
                            <div class="bgWhite item d-flex justify-content-center align-items-center text-start">
                                <img class="foto me-3" src="{{asset('assets/images/promesas/promesa5.webp')}}" alt="">
                                <ul class="info nolist mb-0 py-3">
                                    <li>
                                        <h3 class="nombre black mb-0 altas fw-bold">Martin Gil</h3>
                                    </li>
                                    <li class="edad">14 años</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    <li class="p-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="250">
                        <a href="#">
                            <div class="bgWhite item d-flex justify-content-center align-items-center text-start">
                                <img class="foto me-3" src="{{asset('assets/images/promesas/promesa6.webp')}}" alt="">
                                <ul class="info nolist mb-0 py-3">
                                    <li>
                                        <h3 class="nombre black mb-0 altas fw-bold">José Martí</h3>
                                    </li>
                                    <li class="edad">16 años</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    <li class="p-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <a href="#">
                            <div class="bgWhite item d-flex justify-content-center align-items-center text-start">
                                <img class="foto me-3" src="{{asset('assets/images/promesas/promesa7.webp')}}" alt="">
                                <ul class="info nolist mb-0 py-3">
                                    <li>
                                        <h3 class="nombre black mb-0 altas fw-bold">Bruno Salinas</h3>
                                    </li>
                                    <li class="edad">13 años</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                    <li class="p-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="350">
                        <a href="#">
                            <div class="bgWhite item d-flex justify-content-center align-items-center text-start">
                                <img class="foto me-3" src="{{asset('assets/images/promesas/promesa9.webp')}}" alt="">
                                <ul class="info nolist mb-0 py-3">
                                    <li>
                                        <h3 class="nombre black mb-0 altas fw-bold">Gonzalo Fernandez</h3>
                                    </li>
                                    <li class="edad">12 años</li>
                                </ul>
                            </div>
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
        <div class="justify-content-center">
            <a class="btn-cta altas" href="nuestras-promesas.php" data-aos="fade-up" data-aos-duration="1000">
                <img src="{{asset('assets/images/arrow-bt.svg')}}" class="icon me-2 me-lg-1" /> Ver todos
            </a>
        </div>
    </div>
</section>
