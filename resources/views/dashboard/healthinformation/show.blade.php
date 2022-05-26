@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/healthinformation">J+S-Patientenprotokoll</a></li>
                <li class="breadcrumb-item active">Protokoll von {{$healthinformation['code']}}</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 >J+S-Patientenprotokoll von {{$healthinformation['code']}}</h1>
            </header>
            <br>
            <div class="row">
                <div class="col-md-10">
                    <h3>Intervention erfassen</h3>
                    {!! Form::model($intervention, ['method' => 'POST', 'action'=>'InterventionController@store']) !!}
                        <div class="form-row">
                            <div class="form-group col-xl-2">
                                {!! Form::label('intervention_class_id', 'Code:') !!}
                                {!! Form::select('intervention_class_id', $intervention_classes, null, ['class' => 'form-control', 'required', 'id' => 'intervention_class_id', 'onchange' => "Change_Intervention()"]) !!}
                                {!! Form::hidden('health_information_id', $intervention['health_information_id'], null) !!}
                            </div>
                            <div class="form-group col-xl-6">
                                {!! Form::label('parameter', $intervention_class['parameter_name'].':', ['id'=>'parameter_label']) !!}
                                {!! Form::text('parameter', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group col-xl-4" id="value_div" style="display:{{$intervention_class['value_name']<>'' ? "block": "none"}}">
                                {!! Form::label('value', $intervention_class['value_name'].':', ['id'=>'value_label']) !!}
                                {!! Form::text('value', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-xl-2 col-6">
                                {!! Form::label('date', 'Datum:') !!}
                                {!! Form::date('date', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group col-xl-2 col-6">
                                {!! Form::label('time', 'Zeit:') !!}
                                {!! Form::time('time', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group col-xl-8 col-lg-12">
                                {!! Form::label('comment', 'Bemerkung:') !!}
                                {!! Form::text('comment', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Intervention erstellen', ['class' => 'btn btn-primary', 'id' => 'submit_btn'])!!}
                        </div>
                    {!! Form::close()!!}
                </div>
                <div class="col-md-2">
                    {!! Html::link('files/Notfallblatt.pdf', 'J+S-Notfallblatt herunterladen', ['target' => 'blank', 'class' =>'btn btn-primary']) !!}
                    @if(Auth::user()->isManager())
                        <br>
                        <br>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {!! Form::model($healthinformation, ['method' => 'POST', 'action'=>['HealthInformationController@uploadProtocol', $healthinformation], 'files' => true]) !!}

                        <div class="form-group">
                            {!! Form::file('file_protocol', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('J+S-Notfallblatt hochladen', ['class' => 'btn btn-primary'])!!}
                        </div>
                        {!! Form::close()!!}
                        <br>
                        <a href={{$healthinformation['file_protocol'] ? route('downloadProtocol',$healthinformation) : '#'}}>Protokoll herunterladen</a>
                    @endif
                </div>
            </div>
            <br>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h3>Informationen</h3>
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th scope="col" style="width:30%">Was</th>
                            <th scope="col" style="width:70%">Bemerkung</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:30%">kürzliche Unfälle / Krankheiten abgeschlossen?</td>
                                <td>{{$healthinformation['recent_issues']}}</td>
                            </tr>
                            <tr>
                                <td style="width:30%">behandelnder Arzt: Name, Telefon</td>
                                <td>{{$healthinformation['recent_issues_doctor']}}</td>
                            </tr>
                            <tr>
                                <td style="width:30%">Medikamente und Dosis</td>
                                <td>{{$healthinformation['drugs']}}</td>
                            </tr>
                            <tr>
                                <td style="width:30%">Salben ohne Rückfragen?</td>
                                <td>{{$healthinformation['ointment_only_contact'] ? 'Ja' : 'Nein'}}</td>
                            </tr>
                            <tr>
                                <td style="width:30%">Medikamente ohne Rückfragen?</td>
                                <td>{{$healthinformation['drugs_only_contact'] ? 'Ja' : 'Nein'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3>Allergien</h3>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                    <th scope="col" style="width:30%">Allergie</th>
                                    <th scope="col" style="width:70%">Kommentar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($healthinformation->allergies as $allergy)
                                <tr>
                                    <td>{{$allergy->allergy['name']}}</td>
                                    <td>{{$allergy['comment']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <x-intervention-table :interventionclasses="$intervention_classes" :healthinformation="$healthinformation"/>
        </div>
    </section>
@endsection

@section('scripts')
    <x-filter-buttons-javascript :healthinformation="$healthinformation"/>
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


