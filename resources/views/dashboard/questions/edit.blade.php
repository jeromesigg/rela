@extends('layouts.layout')
@section('page')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/questions">Individuelle Fragen</a></li>
                <li class="breadcrumb-item active">Bearbeiten</li>
            </ul>
        </div>
    </div>
<section>
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display">Individuelle Fragen</h1>
        </header>
        <div class="row">

            <div class="col-sm-6">

                {!! Form::model($question, ['method' => 'PATCH', 'action'=>['QuestionController@update' , $question]]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Frage:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('sortindex', 'Sort-Index:') !!}
                    {!! Form::text('sortindex', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('active', '1', null) !!}
                    {!! Form::label('active', 'Aktiv') !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Update Individuelle Fragen', ['class' => 'btn btn-primary'])!!}
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</section>
@endsection
