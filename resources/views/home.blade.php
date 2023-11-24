@extends('layouts.layout')

@section('page')
    <div class="wide" id="all"><section class="py-5">
    <div class="container py-4">
        {!! Form::open(['method' => 'POST', 'action'=>'HealthFormController@edit']) !!}
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-dismissable alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>
                        {!! session()->get('success') !!}
                    </strong>
                </div>
            @endif
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('code', 'Persönliche Nummer:') !!}
                    {!! Form::number('code', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('camp_code', 'Lager-Nummer:') !!}
                    {!! Form::number('camp_code', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Suchen', ['class' => 'btn btn-primary'])!!}
        </div>
        {!! Form::close()!!}
    </div>
</section>
</div>
@endsection
