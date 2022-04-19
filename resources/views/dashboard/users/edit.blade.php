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
            <h1 class="h3 display">Leiter</h1>
        </header>
        <div class="row">

            <div class="col-sm-6">

                {!! Form::model($user, ['method' => 'PATCH', 'action'=>['AdminUsersController@update' , $user->id]]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
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
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Update Leiter', ['class' => 'btn btn-primary'])!!}
                </div>
                {!! Form::close()!!}

                {!! Form::open(['method' => 'DELETE', 'action'=>['AdminUsersController@destroy', $user->id]]) !!}
                <div class="form-group">
                {!! Form::submit('Lösche Leiter', ['class' => 'btn btn-danger'])!!}
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</section>
@endsection
