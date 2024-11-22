@php
    use App\Models\Persona;
    use Illuminate\Support\Str;

    $person = Persona::where('id', Auth::user()->id)->get();
    $persona = $person[0];
    $rol = Str::after(Str::before(Auth::user()->roles->pluck('name'), '"]'), '["');
@endphp
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
     id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        {{--<div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                 <button type="button" class="btn btn-sm btn-transparent" id="buscador">
                    <i class="bx bx-search fs-4 lh-0"></i>
                </button>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
                 @if ($authenticate)
                    <marquee direction="right">
                        {{ $nombres[0]->nombres . ' ' . $nombres[0]->apepaterno . ' ' . $nombres[0]->apematerno }}
                    </marquee>
                @endif
            </div>
        </div>--}}
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            @php
              $counter = 4;
            @endphp

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow mt-3" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <button type="button" class="btn" style="background: transparent; font-size: 20px; margin-top: -10px">
                        @if($counter > 0 )
                            <i class="fa-solid fa-bell-ring"></i><span class="badge badge-danger" style="background: red; border-radius: 50%; font-size:10px !important;">{{$counter}}</span>
                            <span class="sr-only">unread messages</span>
                        @else
                            <i class="fa-solid fa-bell"></i><span class="badge badge-danger" style="background: red; border-radius: 50%; font-size:10px !important;">{{$counter}}</span>
                            <span class="sr-only">unread messages</span>
                        @endif
                    </button>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @for($i=0; $i < $counter; $i++)
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="d-flex align-items-center align-middle d-flex ">
                              <i class="flex-shrink-0 bx bx-envelope me-2"></i>
                              <span class="flex-grow-1 align-middle me-5">Título Mensaje Nuevo</span>
{{--                              <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">{{$i}}</span>--}}
                              <span class="flex-shrink-0 badge badge-center bg-danger">X</span>
                            </span>
                        </a>
                    </li>
                    @endfor
                </ul>
            </li>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('assets/images/user.png') }}" alt class="w-px-40 h-auto rounded-circle"/>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/images/user.png') }}" alt
                                             class="w-px-40 h-auto rounded-circle"/>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{$persona->nombres}}</span>
                                    <small class="text-muted">{{ $rol }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('usuarios.edit',Auth::id())}}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Mi Períl</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                    </li> -->
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Cerrar Sesion</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout.staff') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
