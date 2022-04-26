@extends('layouts.layout')

@section('page')
    <div class="wide" id="all">
        <div class="breadcrumb-holder">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard/observations"><span id="title"></span></a></li>
                    <li class="breadcrumb-item active">Erfassen</li>
                </ul>
            </div>
        </div>
        <br>
        {!! Form::model($observation, ['method' => 'POST', 'action'=>'ObservationController@store']) !!}
        <div class="form-row">
            <div class="form-group col-md-2">
                {!! Form::label('health_information_id', 'Code:') !!}
                {!! Form::select('health_information_id', $healthinfos, null, ['class' => 'form-control', 'required']) !!}
{{--                {!! Form::hidden('observation_class_id', $observation_class['id'], null) !!}--}}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('observation_class_id', 'Code:') !!}
                {!! Form::select('observation_class_id', $observation_classes, null, ['class' => 'form-control', 'required', 'id' => 'observation_class_id', 'onchange' => "Change_Observation()"]) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('parameter', $observation_class['parameter_name'].':', ['id'=>'parameter_label']) !!}
                {!! Form::text('parameter', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-md-4" id="value_div" style="display:{{$observation_class['value_name']<>'' ? "block": "none"}}">
                {!! Form::label('value', $observation_class['value_name'].':', ['id'=>'value_label']) !!}
                {!! Form::text('value', null, ['class' => 'form-control', 'required']) !!}
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
            {!! Form::submit('Beobachtung erstellen', ['class' => 'btn btn-primary', 'id' => 'submit_btn'])!!}
        </div>
        {!! Form::close()!!}
    </div>

@endsection

@section('scripts')
<script>
    window.onload = function() {
        Change_Observation();
    }
    function Change_Observation() {
        var observation_class_id = document.getElementById('observation_class_id').value;
        var observation_classes = @json($observation_classes_all);
        var act_observation_class = null;
        observation_classes.forEach(observation_class => {
            if(observation_class['id'] == observation_class_id){
                act_observation_class = observation_class;
            }
        });
        if(act_observation_class['value_name'] == null){
            document.getElementById("value_div").style.display = "none";
            document.getElementById("value").removeAttribute("required");
            $('#value').val(null);
        }
        else{
            document.getElementById("value_div").style.display = "block";
            document.getElementById("value_div").setAttribute("required", true);
        }
        $('#submit_btn').val(act_observation_class['short_name'] + ' erstellen' );
        $('#title').text(act_observation_class['short_name']);
        $('#parameter_label').text(act_observation_class['parameter_name'] +':');
        $('#value_label').text(act_observation_class['value_name'] +':');
    }
</script>
@endsection
