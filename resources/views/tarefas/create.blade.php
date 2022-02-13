@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Criar Tarefas</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'tarefas.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('tarefas.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Criar', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('tarefas.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
