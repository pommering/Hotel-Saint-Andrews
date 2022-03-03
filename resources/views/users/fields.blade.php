<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Senha:') !!}
    {!! Form::password('password', ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Manager Field -->
@cannot('equal-id', $users)
    <div class="form-group col-sm-6 d-flex align-items-end">
        <div class="form-check">
            {!! Form::hidden('manager', 0, ['class' => 'form-check-input']) !!}
            {!! Form::checkbox('manager', '1', null, ['class' => 'form-check-input']) !!}
            {!! Form::label('manager', 'Gerente', ['class' => 'form-check-label']) !!}
        </div>
    </div>
@endif

