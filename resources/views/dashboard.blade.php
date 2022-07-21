@extends('layouts.app', ['class' => 'bg-dark'])

@section('view_title_name')
Panel principal
@endsection

@section('nav-dashboard')
active
@endsection

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Resumen</h6>
                                <h2 class="text-white mb-0">Total de ventas:</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chart-sales" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Efectividad</h6>
								@if (Auth()->user()->company->type_business === 1)
                                    <h2 class="mb-0">Reservas completadas</h2>
                                @else
                                    <h2 class="mb-0">Movimientos</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chart-orders" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush