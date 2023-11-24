@extends('layouts.layout')
@section('page')
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Lager</h1>
            </header>
            @if ($errors->camps->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->camps->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-3">
                    {!! Form::open(['action'=>'CampController@store']) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::label('end_date', 'Schlussdatum:') !!}
                        {!! Form::date('end_date', null,  ['class' => 'form-control', 'required']) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::submit('Lager erstellen', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </section>
@endsection
