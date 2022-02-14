<!-- Room Number Field -->
<div class="col-sm-12">
    {!! Form::label('room_number', 'Número do quarto:') !!}
    <p>{{ $cleanRoom->room_number }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'Usuário responsável:') !!}
    <p>{{ $cleanRoom->user->name }}</p>
</div>

<!-- Activitie Id Field -->
<div class="col-sm-12">
    {!! Form::label('activitie_id', 'Tarefa feita:') !!}
    <p>{{ $tasksDone }}</p>
</div>

<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', 'Início:') !!}
    <p>{{ date('d/m/Y H:i:s', strtotime($cleanRoom->start_date)) }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', 'Término:') !!}
    <p>{{ date('d/m/Y H:i:s', strtotime($cleanRoom->end_date)) }}</p>
</div>
