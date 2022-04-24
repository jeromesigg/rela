@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="container">
                    <h4><b>Patientenüberwachung</b></h4>
                    <p>Patientenüberwachung über längeren Zeitraum</p>
                    {!! Form::open(['method' => 'GET', 'action'=>'MonitoringController@create']) !!}
                    <div class="form-row">
                        <div class="form-group">
                            {!! Form::label('code', 'Persönliche Nummer:') !!}
                            {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    {!! Form::submit('Patientenüberwachung erstellen', ['class' => 'btn btn-primary'])!!}
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="container">
                    <h4><b>Verabreichte Medikation </b></h4>
                    <p>Verabreichte Medikation (Wirkstoff, Dosis, Datum)</p>
                    {!! Form::open(['method' => 'GET', 'action'=>'MedicationController@create']) !!}
                    <div class="form-row">
                        <div class="form-group">
                            {!! Form::label('code', 'Persönliche Nummer:') !!}
                            {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    {!! Form::submit('Medikation erstellen', ['class' => 'btn btn-primary'])!!}
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="container">
                    <h4><b>Durchgeführte Massnahmen </b></h4>
                    <p>Durchgeführte Massnahmen (Wunddesinfektion, Spliessen Entfernung, Kühlen, …)</p>
                    {!! Form::open(['method' => 'GET', 'action'=>'MeasureController@create']) !!}
                    <div class="form-row">
                        <div class="form-group">
                            {!! Form::label('code', 'Persönliche Nummer:') !!}
                            {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    {!! Form::submit('Massnahme erstellen', ['class' => 'btn btn-primary'])!!}
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="container">
                    <h4><b>Überwachung der Vitalfunktionen</b></h4>
                    <p>Überwachung der Vitalfunktionen (Körpertemperatur, Blutdruck, Puls, Sauerstoffsättigung, Blutzucker,…)</p>
                    {!! Form::open(['method' => 'GET', 'action'=>'SurveillanceController@create']) !!}
                    <div class="form-row">
                        <div class="form-group">
                            {!! Form::label('code', 'Persönliche Nummer:') !!}
                            {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    {!! Form::submit('Überwachung erstellen', ['class' => 'btn btn-primary'])!!}
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="container">
                    <h4><b>Zustand des Patienten</b></h4>
                    <p>Zustand des Patienten (GCS, Vitalfunktionen)</p>
                    {!! Form::open(['method' => 'GET', 'action'=>'HealthStatusController@create']) !!}
                    <div class="form-row">
                        <div class="form-group">
                            {!! Form::label('code', 'Persönliche Nummer:') !!}
                            {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    {!! Form::submit('Zustand erstellen', ['class' => 'btn btn-primary'])!!}
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="container">
                    <h4><b>Allgemeine Geschehnisse</b></h4>
                    <p>Allgemeine Geschehnisse (Ereignis, Zeitpunkt, nicht nur medizinisch – z.B auch Verstoss gegen Lagerregeln,…)</p>
                    {!! Form::open(['method' => 'GET', 'action'=>'IncidentController@create']) !!}
                    <div class="form-row">
                        <div class="form-group">
                            {!! Form::label('code', 'Persönliche Nummer:') !!}
                            {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    {!! Form::submit('Geschehnisse erstellen', ['class' => 'btn btn-primary'])!!}
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
