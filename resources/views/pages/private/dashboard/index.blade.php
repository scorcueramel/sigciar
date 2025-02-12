@extends('layouts.private.private', ['activePage' => 'home'])
@push('title', 'Panel de Administración')
@section('content')
<div class="row">
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Bienvenido {{$personalInfo[0]->nombres}}! 🎉</h5>
                        <p class="mb-4">
                            Recuerda revisar tus actividades programdas
                        </p>

                        <a href="{{route('calendario.general')}}" class="btn btn-sm btn-outline-primary">Ir actividades</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('assets/images/man-with-laptop-light.png')}}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-4 order-1">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 order-2">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/images/chart-success.png') }}" alt="chart success" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="javascript:void(0);">View
                                        More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                            +72.80%</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/images/wallet-info.png') }}" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="javascript:void(0);">View
                                        More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span>Sales</span>
                        <h3 class="card-title text-nowrap mb-1">$4,679</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                            +28.42%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-8 col-lg-4 order-2 order-md-2">
        <div class="row">
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/images/paypal.png') }}" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                    <a class="dropdown-item" href="javascript:void(0);">View
                                        More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="d-block mb-1">Payments</span>
                        <h3 class="card-title text-nowrap mb-2">$2,456</h3>
                        <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/images/cc-primary.png') }}" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                    <a class="dropdown-item" href="javascript:void(0);">View
                                        More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Transactions</span>
                        <h3 class="card-title mb-2">$14,857</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                            +28.14%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    // cambiar esa respuesta llamada grafico_inscritos solo por grafico
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: @json($dataGrafico),
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'INSCRIPCIONES 2024'
                }
            }
        }
    });

    // const ctx = document.getElementById('myChart');

    // const Utils = ChartUtils.init();

    // const actions = [{
    //     name: 'Randomize',
    //     handler(chart) {
    //         chart.data.datasets.forEach(dataset => {
    //             dataset.data = chart.data.labels.map(() => {
    //                 return [Utils.rand(-100, 100), Utils.rand(-100, 100)];
    //             });
    //         });
    //         chart.update();
    //     }
    // }, ];

    // const DATA_COUNT = 7;
    // const NUMBER_CFG = {
    //     count: DATA_COUNT,
    //     min: -100,
    //     max: 100
    // };

    // const labels = Utils.months({
    //     count: 8
    // });

    // const data = {
    //     labels: labels,
    //     datasets: [{
    //             label: 'Dataset 1',
    //             data: labels.map(() => {
    //                 return [Utils.rand(-100, 100), Utils.rand(-100, 100)];
    //             }),
    //             backgroundColor: Utils.CHART_COLORS.red,
    //         },
    //         {
    //             label: 'Dataset 2',
    //             data: labels.map(() => {
    //                 return [Utils.rand(-100, 100), Utils.rand(-100, 100)];
    //             }),
    //             backgroundColor: Utils.CHART_COLORS.blue,
    //         },
    //     ]
    // };

    // new Chart(ctx, {
    //     type: 'bar',
    //     data: data,
    //     options: {
    //         responsive: true,
    //         plugins: {
    //             legend: {
    //                 position: 'top',
    //             },
    //             title: {
    //                 display: true,
    //                 text: 'Chart.js Floating Bar Chart'
    //             }
    //         }
    //     }
    // });
</script>
@endpush
