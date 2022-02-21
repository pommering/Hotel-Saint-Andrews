@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4 mt-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de horas</div>
                            <div class="h5 mb-0 font-weight-bold text-secondary">{{$dataInformation}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4 mt-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Limpezas Feitas</div>
                            <div class="h5 mb-0 font-weight-bold text-secondary">{{$clears}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4 mt-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Trabalho mais rápido</div>
                            <div class="h5 mb-0 font-weight-bold text-secondary">{{ $fast_time }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div id="chart" style="height: 350px; width: 100%"></div>
    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <script>
      const chart = new Chartisan({
        el: '#chart',
        url: "@chart('sample_chart')",
        hooks: new ChartisanHooks().legend().tooltip().datasets([{ type: 'line', fill: false }, 'bar']),
      });
    </script>
    <div>
</div>
@endsection
