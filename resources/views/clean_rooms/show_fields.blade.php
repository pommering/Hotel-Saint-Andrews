<!-- Room Number Field -->
<div class="col-sm-12">
    {!! Form::label('room_number', 'Room Number:') !!}
    <p>{{ $cleanRoom->room_number }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $cleanRoom->user_id }}</p>
</div>

<!-- Activitie Id Field -->
<div class="col-sm-12">
    {!! Form::label('activitie_id', 'Activitie Id:') !!}
    <p>{{ $cleanRoom->activitie_id }}</p>
</div>

<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{{ $cleanRoom->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{{ $cleanRoom->end_date }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cleanRoom->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cleanRoom->updated_at }}</p>
</div>

