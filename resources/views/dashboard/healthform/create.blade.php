@extends('layouts.layout')

@section('page')
    <div class="wide" id="all">
        <div class="breadcrumb-holder">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard/users">Personen</a></li>
                    <li class="breadcrumb-item active">Erfassen</li>
                </ul>
            </div>
        </div>
        <br>
        {!! Form::open(['method' => 'POST', 'action'=>'HealthFormController@store']) !!}
            <h4>1. Personalie</h4>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    {!! Form::label('first_name', 'Vorname:') !!}
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-3">
                    {!! Form::label('last_name', 'Name:') !!}
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('nickname', 'v/o:') !!}
                    {!! Form::text('nickname', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('birthday', 'Geburtstag:') !!}
                    {!! Form::date('birthday', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <div class="form-group col-md-2">
                    {!! Form::label('group_id', 'Abteilung:') !!}
                    {!! Form::select('group_id', $groups, null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::label('street', 'Strasse:') !!}
                    {!! Form::text('street', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('zip_code', 'Postleitzahl:') !!}
                    {!! Form::number('zip_code', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-3">
                    {!! Form::label('city', 'Ortschaft:') !!}
                    {!! Form::text('city', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-3">
                    {!! Form::label('phone_number', 'Telefon:') !!}
                    {!! Form::text('phone_number', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::submit('Gesundheitsblatt erstellen', ['class' => 'btn btn-primary'])!!}
            </div>
        {!! Form::close()!!}
    </div>

@endsection
