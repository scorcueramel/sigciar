<header class="menu w-100" id="header" data-aos="fade-down" data-aos-delay="500">
    <div class="container-fluid">
        <nav class="d-flex flex-wrap align-items-center justify-content-end">
            <div class="logo-wrapper me-auto">
                <a class="enlace" href="{{ route('landing.index') }}">
                    <img class="logo" src="{{ asset('assets/images/ciar-logo.svg') }}" alt="Logo CIAR">
                </a>
            </div>
            <ul id="navegacion" class="navegacion nolist ls-05 altas mb-0">
                <li><a class="enlace btn-menu" href="{{route('landing.programas')}}">Programas</a></li>
                <li><a class="enlace btn-menu" href="{{$sedes}}">Sedes</a></li>
                <li><a class="enlace btn-menu" href="torneos.php">Torneos</a></li>
                <li><a class="enlace btn-menu" href="{{route('landing.promises')}}">Nuestras promesas</a></li>
                <li><a class="enlace btn-menu" href="{{route('landing.news')}}">Noticias</a></li>
                <li><a class="enlace btn-menu" href="quienes-somos.php">¿Quiénes somos?</a></li>
                <li><a class="enlace btn-menu reservar" href="{{ route('reservation') }}" target="_blank"><img
                            src="{{ asset('assets/images/calendar.svg') }}" class="icon me-2 me-lg-1" />Reservar
                        cancha</a></li>
                <li><a class="enlace btn-menu miembros ms-lg-3" href="{{ route('login.member') }}"><img
                            src="{{ asset('assets/images/miembro.svg') }}" class="icon me-2 me-lg-1" />Miembros</a></li>
            </ul>
            <label for="burger" class="burger ms-3 d-lg-none">
                <input type="checkbox" id="burger">
                <span></span><span></span><span></span>
            </label>
        </nav>
    </div>
</header>
