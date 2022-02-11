<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nome:') !!}
    <p>{{ $usuario->name }}</p>
</div>

<!-- Username Field -->
<div class="col-sm-12">
    {!! Form::label('username', 'Username:') !!}
    <p>{{ $usuario->username }}</p>
</div>

<!-- Manager Field -->
<div class="col-sm-12">
    {!! Form::label('manager', 'Cargo:') !!}
    <p>{{ ($usuario->manager !== false) ? 'Gerente' : 'Faxineira' }}</p>
</div>

