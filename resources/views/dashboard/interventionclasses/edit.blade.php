@extends('layouts.layout')
@section('page')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/interventionclasses">Kategorie</a></li>
                <li class="breadcrumb-item active">Bearbeiten</li>
            </ul>
        </div>
    </div>
<section>
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display">Kategorie</h1>
        </header>
        <div class="row">

            <div class="col-sm-6">

                {!! Form::model($interventionclass, ['method' => 'PATCH', 'action'=>['InterventionClassController@update' , $interventionclass], 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('short_name', 'Kurzname:') !!}
                    {!! Form::text('short_name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('parameter_name', 'Parameter Name:') !!}
                    {!! Form::text('parameter_name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('value_name', 'Wert Name:') !!}
                    {!! Form::text('value_name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('default_text', 'Default Text:') !!}
                    {!! Form::textarea('default_text', null, ['class' => 'form-control', 'rows'=>3]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('file', 'Bild:') !!}
                    {!! Form::file('file', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::checkbox('with_picture', '1', null) !!}
                    {!! Form::label('with_picture', 'Mit Bildaufnahme') !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('show', '1', null) !!}
                    {!! Form::label('show', 'Anzeigen') !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Update Kategorie', ['class' => 'btn btn-primary'])!!}
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</section>
@endsection
