@extends('layouts.layout')

@section('page')
    <div class="wide" id="all">
        <div class="breadcrumb-holder">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard/incidents">Allgemeine Geschehnisse</a></li>
                    <li class="breadcrumb-item active">Erfassen</li>
                </ul>
            </div>
        </div>
        <br>
        {!! Form::model($incident, ['method' => 'POST', 'action'=>'IncidentController@store']) !!}

        <div class="form-row">
            <div class="form-group col-md-2">
                {!! Form::label('health_information_id', 'Code:') !!}
                {!! Form::select('health_information_id', $healthinfos, null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-md-10">
                {!! Form::label('incident', 'Geschehniss:') !!}
                {!! Form::text('incident', null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-1">
                {!! Form::label('date', 'Datum:') !!}
                {!! Form::date('date', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('time', 'Zeit:') !!}
                {!! Form::time('time', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-md-10">
                {!! Form::label('comment', 'Bemerkung:') !!}
                {!! Form::text('comment', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::submit('Geschehniss erstellen', ['class' => 'btn btn-primary'])!!}
        </div>
        {!! Form::close()!!}
    </div>

@endsection
