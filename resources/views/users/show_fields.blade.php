<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nome:') !!}
    <p>{{ $users->name }}</p>
</div>

<!-- Username Field -->
<div class="col-sm-12">
    {!! Form::label('username', 'Acesso:') !!}
    <p>{{ $users->username }}</p>
</div>

<!-- Manager Field -->
<div class="col-sm-12">
    {!! Form::label('manager', 'Cargo:') !!}
    <p>{{ ($users->manager !== false) ? 'Gerente' : 'Faxineira' }}</p>
</div>

