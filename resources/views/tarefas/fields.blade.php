<!-- Assignment Field -->
<div class="form-group col-sm-6">
    {!! Form::label('assignment', 'Tarefa:') !!}
    {!! Form::text('assignment', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<div class="form-group col-sm-6 d-flex align-items-end">
    <div class="form-check">
        {!! Form::hidden('mandatory', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('mandatory', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('mandatory', 'Tarefa obrigatória', ['class' => 'form-check-label']) !!}
    </div>
</div>
