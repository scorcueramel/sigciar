<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{route('home.dashboard')}}" class="app-brand-link">
            <!-- <img src="{{asset('assets/images/ciar-logo-azul.png')}}" alt="CIAR" class="img-fluid img-thumbnail"> -->
            <img src="{{asset('assets/images/LOGO-AZUL-HORIZONTAL.png')}}" alt="CIAR" class="img-fluid img-thumbnail">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ $activePage == 'home' ? 'active' : '' }}">
            <a href="{{route('home.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <!-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Layouts</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-without-menu.html" class="menu-link">
                        <div data-i18n="Without menu">Without menu</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-without-navbar.html" class="menu-link">
                        <div data-i18n="Without navbar">Without navbar</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-container.html" class="menu-link">
                        <div data-i18n="Container">Container</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-fluid.html" class="menu-link">
                        <div data-i18n="Fluid">Fluid</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-blank.html" class="menu-link">
                        <div data-i18n="Blank">Blank</div>
                    </a>
                </li>
            </ul>
        </li> -->

        {{-- Sección de actividades --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Programas</span>
        </li>
        <li class="menu-item {{$activePage == 'tenis.edit' || $activePage == 'tenis.index' || $activePage == 'tenis.create' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'tenis.create' ? 'active' : '' }}">
                <i class="fa-solid fa-tennis-ball" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Programa de Tenis</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'tenis.index' ? 'active' : '' }}">
                    <a href="{{route('tenis.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Programas Creados</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'tenis.create' ? 'active' : '' }}">
                    <a href="{{ route('tenis.create',3) }}" class="menu-link">
                        <div data-i18n="Account">Nuevo Programa</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $activePage == 'nutricion.index' || $activePage == 'nutricion.create' || $activePage == 'nutricion.edit' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'nutricion.create' ? 'active' : '' }}">
                <i class="fa-regular fa-salad" style="margin-right: 13px"></i>
                <div data-i18n="Account Settings">Nutrición</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'nutricion.index' ? 'active' : '' }}">
                    <a href="{{route('nutricion.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Programas creados</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'nutricion.create' ? 'active' : '' }}">
                    <a href="{{route('nutricion.create')}}" class="menu-link">
                        <div data-i18n="Account">Nuevo Programa</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-regular fa-list-check" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Otros Programas</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Notifications">Programas creados</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Account">Nuevo Programa</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Sección de inscripciones --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Inscripciones</span>
        </li>
        <li class="menu-item {{ $activePage == 'inscripciones.index' || $activePage == 'inscripciones.create' || $activePage == 'inscripciones.edit' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'inscripciones.index' ? 'active' : '' }}">
                <i class="fa-regular fa-calendar-lines-pen" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Inscripción de Miembros</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'inscripciones.index' ? 'active' : '' }}">
                    <a href="{{route('inscripciones.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Miembros Inscritos</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'inscripciones.create' ? 'active' : '' }}">
                    <a href="{{ route('inscripciones.create') }}" class="menu-link">
                        <div data-i18n="Account">Inscribir Nuevo</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Sección de Noticias --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">INFORMACIÓN</span>
        </li>
        <li class="menu-item {{ $activePage == 'categorias.index' || $activePage == 'categorias.edit' || $activePage == 'categorias.create' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'categorias.create' ? 'active' : '' }}">
                <i class="fa-regular fa-layer-group" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Categorías</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'categorias.index' ? 'active' : '' }}">
                    <a href="{{route('categorias.index')}}" class="menu-link">
                        <div data-i18n="Account">Todas las Categorías</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'categorias.create' ? 'active' : '' }}">
                    <a href="{{ route('categorias.create') }}" class="menu-link">
                        <div data-i18n="Account">Nueva Categoría</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $activePage == 'noticias.index' || $activePage == 'noticias.edit' ||  $activePage == 'noticias.create' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'categorias.create' ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper" style="margin-right: 13px"></i>
                <div data-i18n="Authentications">Noticias</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'noticias.index' ? 'active' : '' }}">
                    <a href="{{route('noticias.index')}}" class="menu-link">
                        <div data-i18n="Basic">Todas las Noticias</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'noticias.create' ? 'active' : '' }}">
                    <a href="{{route('noticias.create')}}" class="menu-link">
                        <div data-i18n="Basic">Nueva Noticia</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Sección de Usuarios --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Control</span>
        </li>
        <li class="menu-item {{ $activePage == 'usuarios.index' || $activePage == 'usuarios.edit' || $activePage == 'usuarios.create' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-regular fa-users" style="margin-right: 13px"></i>
                <div data-i18n="Account Settings">Usuarios</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'usuarios.index' ? 'active' : '' }}">
                    <a href="{{route('usuarios.index')}}" class="menu-link">
                        <div data-i18n="Account">Todos los Usuarios</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'usuarios.create' ? 'active' : '' }}">
                    <a href="{{ route('usuarios.create') }}" class="menu-link">
                        <div data-i18n="Account">Nuevo Usuario</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $activePage == 'roles.index' || $activePage == 'roles.edit' || $activePage == 'roles.create' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-regular fa-lock" style="margin-right: 13px"></i>
                <div data-i18n="Authentications">Roles</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'roles.index' ? 'active' : '' }}">
                    <a href="{{route('roles.index')}}" class="menu-link">
                        <div data-i18n="Basic">Todos los Roles</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'roles.create' ? 'active' : '' }}">
                    <a href="{{route('roles.create')}}" class="menu-link">
                        <div data-i18n="Basic">Nuevo Rol</div>
                    </a>
                </li>
            </ul>
        </li>


        {{-- MANTENIMIENTO DE ESPACIOS --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Espacios</span>
        </li>
        <li class="menu-item {{ $activePage == 'sedes.index' || $activePage == 'sedes.create' || $activePage == 'sedes.edit' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'sedes.index' ? 'active' : '' }}">
                <i class="fa-regular fa-hotel" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Sedes</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'sedes.index' ? 'active' : '' }}">
                    <a href="{{route('sedes.index')}}" class="menu-link">
                        <div data-i18n="Account">Todas las Sedes</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'sedes.create' ? 'active' : '' }}">
                    <a href="{{route('sedes.create')}}" class="menu-link">
                        <div data-i18n="Notifications">Nueva Sede</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $activePage == 'lugares.index' || $activePage == 'lugares.create' || $activePage == 'lugares.edit' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'lugares.index' ? 'active' : '' }}">
                <i class="fa-regular fa-court-sport" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Lugares</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'lugares.index' ? 'active' : '' }}">
                    <a href="{{route('lugares.index')}}" class="menu-link">
                        <div data-i18n="Account">Todas los Lugares</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'lugares.create' ? 'active' : '' }}">
                    <a href="{{ route('lugares.create') }}" class="menu-link">
                        <div data-i18n="Notifications">Nueva Lugares</div>
                    </a>
                </li>
            </ul>
        </li>


        {{-- MANTENIMIENTO DE TIPOS --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Mantenimiento de Tipos</span>
        </li>
        <li class="menu-item {{ $activePage == 'tipo.servicio.index' || $activePage == 'tipo.servicio.create' || $activePage == 'tipo.servicio.edit' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'tipo.servicio.index' ? 'active' : '' }}">
                <i class="fa-solid fa-box-open" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Tipo de servicios</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'tipo.servicio.index' ? 'active' : '' }}">
                    <a href="{{route('tipo.servicio.index')}}" class="menu-link">
                        <div data-i18n="Account">Todos los Tipos</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'tipo.servicio.create' ? 'active' : '' }}">
                    <a href="{{route('tipo.servicio.create')}}" class="menu-link">
                        <div data-i18n="Notifications">Nuevo Tipo</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $activePage == 'subtipos.servicio.index' || $activePage == 'subtipos.servicio.create' || $activePage == 'subtipos.servicio.edit' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'subtipos.servicio.index' ? 'active' : '' }}">
                <i class="fa-solid fa-box-open-full" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Subtipo de Servicios</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'subtipos.servicio.index' ? 'active' : '' }}">
                    <a href="{{route('subtipos.servicio.index')}}" class="menu-link">
                        <div data-i18n="Account">Todos los Subtipos</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'subtipos.servicio.create' ? 'active' : '' }}">
                    <a href="{{ route('subtipos.servicio.create') }}" class="menu-link">
                        <div data-i18n="Notifications">Nuevo Subtipo</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $activePage == 'costos.lugares.index' || $activePage == 'costos.lugares.create' || $activePage == 'costos.lugares.edit' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ $activePage == 'costos.lugares.index' ? 'active' : '' }}">
                <i class="fa-regular fa-money-check-dollar-pen" style="margin-right: 13px;"></i>
                <div data-i18n="Account Settings">Costo por Lugar</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $activePage == 'costos.lugares.index' ? 'active' : '' }}">
                    <a href="{{route('costos.lugares.index')}}" class="menu-link">
                        <div data-i18n="Account">Todos Lugar Costos</div>
                    </a>
                </li>
                <li class="menu-item {{ $activePage == 'costos.lugares.create' ? 'active' : '' }}">
                    <a href="{{ route('costos.lugares.create') }}" class="menu-link">
                        <div data-i18n="Notifications">Nuevo Lugar Costos</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
<!-- / Menu -->
