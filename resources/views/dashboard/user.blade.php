@extends('layouts.layout')

@section('page')
    <h1>Hallo {{$aktUser->name}}</h1>
    {!! Form::model($aktUser, ['method' => 'PATCH', 'class' => 'card', 'action'=>['UsersController@update', $aktUser]]) !!}

        <div class="card-header">
            <h3 class="card-title">Mein Profil</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'readonly' => true]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'E-Mail:') !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Passwort:') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Passwort Wiederholen:') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="card-footer text-right">
            {!! Form::submit('Speichern', ['class' => 'btn btn-primary'])!!}
        </div>
    {!! Form::close()!!}
@endsection
