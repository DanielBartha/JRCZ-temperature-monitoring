@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="row" id="noData" style="display: none">
        <div class="col-12">
            <div class="alert bg-info px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline" id="noDataContent"> </span>
            </div>
        </div>
    </div>
    {{-- Room temperatures chart --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <h2 class="card-title">{{ __('Room temperatures') }}<small
                                    class="card-category"></small></h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartContainerTemperature" style="height: 100%; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CO2 levels chart --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <h2 class="card-title">{{ __('CO2 levels') }}<small class="card-category"> - ppm</small>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartContainerCo2" style="height: 100%; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  Middelburg outside temperature that day  --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category"> {{ __('Outside temperature that day') }}</h5>
                    <h3 class="card-title"><i class="tim-icons icon-world text-primary"></i> Middelburg</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="padding: 15px; text-align: right">
                        <canvas id="chartContainerOutsideTemperature" style="height: 100%; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Minimum temperatures chart  --}}
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Minimum Temperatures') }}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartContainerMinTemp"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{--  Maximum temperatures chart  --}}
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Maximum Temperatures') }}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartContainerMaxTemp"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{--  Average temeperatures charts  --}}
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Average Temperatures') }}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartContainerAverageTemperature"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1/dist/chartjs-plugin-zoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/black/js/charts_temp_and_co2/chartImport.js"></script>>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
