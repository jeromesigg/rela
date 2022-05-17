@extends('layouts.layout')

@section('page')
    <div class="wide" id="all">
        <div class="breadcrumb-holder">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard/interventions"><span id="title">Interventionen</span></a></li>
                    <li class="breadcrumb-item active">Erfassen</li>
                </ul>
            </div>
        </div>
        <br>
        {!! Form::model($intervention, ['method' => 'POST', 'action'=>'InterventionController@store']) !!}
            <div class="form-row">
                <div class="form-group col-md-2">
                    {!! Form::label('health_information_id', 'Code:') !!}
                    {!! Form::select('health_information_id', $healthinfos, null, ['class' => 'form-control', 'required']) !!}
    {{--                {!! Form::hidden('intervention_class_id', $intervention_class['id'], null) !!}--}}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('intervention_class_id', 'Code:') !!}
                    {!! Form::select('intervention_class_id', $intervention_classes, null, ['class' => 'form-control', 'required', 'id' => 'intervention_class_id', 'onchange' => "Change_intervention()"]) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('parameter', $intervention_class['parameter_name'].':', ['id'=>'parameter_label']) !!}
                    {!! Form::text('parameter', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-4" id="value_div" style="display:{{$intervention_class['value_name']<>'' ? "block": "none"}}">
                    {!! Form::label('value', $intervention_class['value_name'].':', ['id'=>'value_label']) !!}
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
                {!! Form::submit('Intervention erstellen', ['class' => 'btn btn-primary', 'id' => 'submit_btn'])!!}
            </div>
        {!! Form::close()!!}
    </div>

@endsection

@section('scripts')
<script>
    window.onload = function() {
        Change_Intervention();
    }
    function Change_Intervention() {
        var intervention_class_id = document.getElementById('intervention_class_id').value;
        var intervention_classes = @json($intervention_classes_all);
        var act_intervention_class = null;
        intervention_classes.forEach(intervention_class => {
            if(intervention_class['id'] == intervention_class_id){
                act_intervention_class = intervention_class;
            }
        });
        if(act_intervention_class['value_name'] == null){
            document.getElementById("value_div").style.display = "none";
            document.getElementById("value").removeAttribute("required");
            $('#value').val(null);
        }
        else{
            document.getElementById("value_div").style.display = "block";
            document.getElementById("value_div").setAttribute("required", true);
        }
        $('#submit_btn').val(act_intervention_class['short_name'] + ' erstellen' );
        $('#title').text(act_intervention_class['short_name']);
        $('#parameter_label').text(act_intervention_class['parameter_name'] +':');
        $('#value_label').text(act_intervention_class['value_name'] +':');
    }
</script>
@endsection
