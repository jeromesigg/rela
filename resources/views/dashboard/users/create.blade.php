@extends('layouts.layout')
@section('page')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/users">Personen</a></li>
                <li class="breadcrumb-item active">Erfassen</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Person</h1>
            </header>
            <div class="row">
                <div class="col-sm-6">
                    <p>Person Erstellen:</p>
                    {!! Form::open(['method' => 'POST', 'action'=>'AdminUsersController@store']) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'name@abt', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'E-Mail:') !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'name@abt.ch', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('is_Manager', '1', null) !!}
                        {!! Form::label('is_Manager', 'Hauptleitung') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('is_Helper', '1', null) !!}
                        {!! Form::label('is_Helper', 'Helfer') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Passwort:') !!}
                        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Person Erstellen', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}

                </div>
            </div>
        </div>
    </section>
@endsection
