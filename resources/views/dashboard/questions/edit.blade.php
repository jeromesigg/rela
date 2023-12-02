@extends('layouts.layout')
@section('page')
    <x-page-title :title="$title" :help="$help"/>
<section>
    <div class="container-fluid">
        <!-- Page Header-->
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
