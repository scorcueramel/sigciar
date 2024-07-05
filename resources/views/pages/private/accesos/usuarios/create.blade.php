@extends('layouts.private.private', ['activePage' => 'usuarios.create'])
@push('title', 'Usuarios')
@section('content')
    @include('components.private.messages-session')
    <div class="row d-flex align-items-center mb-4">
        <div class="col-md">
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Usuario /</span> Nuevo </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mx-4">
            <ul class="nav nav-pills flex-column flex-md-row mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true"><i class="bx bx-user me-1"></i> Usuario
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false"><i class="fa-solid fa-lock-open me-1"></i> Rol
                    </button>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="card mb-4 tab-pane fade show active" id="pills-home" role="tabpanel"
                     aria-labelledby="pills-home-tab" tabindex="0">
                    <h5 class="card-header">Datos del Usuario</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img
                                src="{{asset('assets/images/user.png')}}"
                                alt="Avatar de usuario"
                                class="d-block rounded"
                                height="100"
                                width="100"
                                id="uploadedAvatar"
                            />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Subir foto</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input
                                        type="file"
                                        id="upload"
                                        class="account-file-input"
                                        hidden
                                        accept="image/png, image/jpeg"
                                    />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Quitar</span>
                                </button>

                                <p class="text-muted mb-0">Formatos permitidos JPG, GIF or PNG. peso Máximo de 800K</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0"/>
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="country">Tipo de Documento</label>
                                    <select id="country" class="select2 form-select">
                                        <option value="">Seleccionar tipo de documento</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="Canada">Canada</option>
                                        <option value="China">China</option>
                                        <option value="France">France</option>
                                        <option value="Germany">Germany</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Korea">Korea, Republic of</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Russia">Russian Federation</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Nro. de documento</label>
                                    <input
                                        class="form-control"
                                        type="number"
                                        id="nroDoc"
                                        name="nroDoc"
                                    />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Nombres</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="firstName"
                                        name="firstName"
                                    />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Apellido Paterno</label>
                                    <input class="form-control" type="text" name="lastName" id="lastName"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Apellido Materno</label>
                                    <input class="form-control" type="text" name="lastName" id="lastName"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <input
                                        type="text"
                                        id="phoneNumber"
                                        name="phoneNumber"
                                        class="form-control"
                                        placeholder="999 999 999"
                                    />
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="email"
                                        name="email"
                                        placeholder="john.doe@example.com"
                                    />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="organization" class="form-label">Contaseña</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="organization"
                                        name="organization"
                                    />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="address" name="address"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card mb-4 tab-pane fade" id="pills-profile" role="tabpanel"
                     aria-labelledby="pills-profile-tab" tabindex="0">
                    <!-- Notifications -->
                    <h5 class="card-header">Recent Devices</h5>
                    <div class="card-body">
                      <span
                      >We need permission from your browser to show notifications.
                        <span class="notificationRequest"><strong>Request Permission</strong></span></span
                      >
                        <div class="error"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless border-bottom">
                            <thead>
                            <tr>
                                <th class="text-nowrap">Type</th>
                                <th class="text-nowrap text-center">✉️ Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-nowrap">New for you</td>
                                <td>
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1" checked/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">Account activity</td>
                                <td>
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck4" checked/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">A new browser used to sign in</td>
                                <td>
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck7" checked/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap">A new device is linked</td>
                                <td>
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck10" checked/>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <h6>When should we send you notifications?</h6>
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-sm-6">
                                    <select id="sendNotification" class="form-select" name="sendNotification">
                                        <option selected>Only when I'm online</option>
                                        <option>Anytime</option>
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary me-2">Crear Usuario</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /Notifications -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // Ejecuta la acción de buscar de la barra de búsqueda.
        // $('#buscador').click(()=>{
        //     alert('The Watcher');
        // });
    </script>
@endpush
