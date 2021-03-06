@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tarefas</h1>
                </div>
                @can('manager')
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('tarefas.create') }}">
                        Nova tarefa
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('tarefas.table')
            </div>
        </div>
    </div>

@endsection

