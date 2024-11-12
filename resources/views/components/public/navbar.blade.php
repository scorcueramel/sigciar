        {{-- Barra de navegación --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    <img src="{{asset('/assets/images/ciar-logo.svg')}}" class="w-100" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            {{-- <a class="btn btn-success" href="{{ route('login') }}">
                                <i class="fa-solid fa-user-vneck" style="color: #fff; margin-right: 5px"></i>
                                Ir a mi cuenta
                            </a> --}}
                            <a class="btn enlace btn-menu miembros ms-lg-3" href="{{ route('login.member') }}" style="background-color: transparent; border: 1px solid; color:#FFF000; border-radius: 30px; padding: 10px">
                                <img src="{{ asset('assets/images/miembro.svg') }}" class="icon me-2 me-lg-1" />Ir a mi cuenta
                            </a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if ($authenticate)
                                {{ $personalInfo[0]->nombres.' '.$personalInfo[0]->apepaterno.' '.$personalInfo[0]->apematerno }}
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if ($profile)
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('prfole.user') }}">
                                    {{ __('Mi Perfil') }}
                                    <i class="fa-solid fa-user"></i>
                                </a>
                                @endif
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                    <i class="fa-regular fa-arrow-up-left-from-circle fa-rotate-90"></i>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
