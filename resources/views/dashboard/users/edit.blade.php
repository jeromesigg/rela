@extends('layouts.layout')
@section('page')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/users">Personen</a></li>
                <li class="breadcrumb-item active">Aktualisieren</li>
            </ul>
        </div>
    </div>
<section>
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display">Personen</h1>
        </header>
        <div class="row">

            <div class="col-sm-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {!! Form::model($user, ['method' => 'PATCH', 'action'=>['AdminUsersController@update' , $user]]) !!}
                <div class="form-group">
                    {!! Form::label('username', 'Name:') !!}
                    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'name@abt', 'autocomplete' => 'username',  'required']) !!}
                </div>
                <div id="user_information_form">
                    <div class="form-group">
                        {!! Form::label('email', 'E-Mail:') !!}
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'name@abt.ch', 'autocomplete' => 'email', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('role_id', 'Rolle:') !!}
                        {!! Form::select('role_id', [''=>'Wähle Rolle'] + $roles, null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('active', 'Aktiv:') !!}
                        {!! Form::checkbox('active', '1', $camp_user['active']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Passwort:') !!}
                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'autocomplete' => 'new-password']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', __('Passwort bestätigen')) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm', 'autocomplete' => 'new-password']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::submit('Person aktualisieren', ['class' => 'btn btn-primary'])!!}
                </div>
                {!! Form::close()!!}

                {!! Form::open(['method' => 'DELETE', 'action'=>['AdminUsersController@destroy', $user]]) !!}
                <div class="form-group">
                {!! Form::submit('Personen löschen', ['class' => 'btn btn-danger'])!!}
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</section>
@endsection
