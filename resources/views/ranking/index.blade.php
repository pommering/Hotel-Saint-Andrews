@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ranking</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        {!! Form::open(['route' => 'ranking.index', 'method' => 'GET']) !!}
        <div class="clearfix">
            <p>Pesquisar por datas:<p>

            <div class="d-flex">
                <div class="form-group col-sm-5">
                    {!! Form::label('anos', 'Ano:') !!}
                    {!! Form::select('anos', $years, array_key_exists('anos', $searchLast) ? $searchLast['anos'] : date('Y'), ['class' => 'form-control custom-select']) !!}
                </div>
                <div class="form-group col-sm-5">
                    {!! Form::label('mes', 'Mês:') !!}
                    {!! Form::select('mes', ['1' => 'Janeiro','2' => 'Fevereiro','3' => 'Março','4' => 'Abril','5' => 'Maio','6' => 'Junho','7' => 'Julho','8' => 'Agosto','9' => 'Setembro','10' => 'Outubro','11' => 'Novembro','12' => 'Dezembro'], array_key_exists('mes', $searchLast) ? $searchLast['mes'] : date('n'), ['class' => 'form-control custom-select']) !!}
                </div>
                <div class="form-group col-sm-2 align-self-end">
                    {!! Form::submit('Consultar', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>

        {!! Form::close() !!}

        </div>

        <div class="card">
            <div class="card-body p-0">
                @include('ranking.table')
            </div>
        </div>
    </div>

@endsection

