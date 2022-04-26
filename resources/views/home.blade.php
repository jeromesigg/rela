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
    <div class="justify-content-center">
        <div class="card">
            <div class="container">
                <h4><b>Beobachtung</b></h4>
                {!! Form::open(['method' => 'GET', 'action'=>'ObservationController@create']) !!}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {!! Form::label('observation_class_id', 'Beobachtung:') !!}
                        {!! Form::select('observation_class_id', $observation_classes, null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('code', 'Persönliche Nummer:') !!}
                        {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                {!! Form::submit('Beobachtung erstellen', ['class' => 'btn btn-primary'])!!}
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection
