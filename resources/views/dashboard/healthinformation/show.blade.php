@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help" :subtitle="$subtitle"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <div class="row">
                <div class="col-md-10">
                    <h3>{{isset($intervention['id']) ? 'Intervention Nr. ' . $intervention->number() . ' aktualisieren' : 'Intervention erstellen'}}</h3>
                    {!! Form::model($intervention, ['method' => 'POST', 'action'=>'InterventionController@store', 'files' => true]) !!}
                        <div class="form-row">
                            <div class="form-group col-xl-2 col-lg-12">
                                {!! Form::hidden('health_information_id', $intervention['health_information_id']) !!}
                                {!! Form::hidden('intervention_id', $intervention['id']) !!}
                                @if(!isset($intervention['id']) || isset($intervention['intervention_master_id']))
                                    {!! Form::label('intervention_master_id', 'Übergeordnete Intervention:') !!}
                                    {!! Form::select('intervention_master_id', $intervention_masters, null, ['class' => 'form-control']) !!}
                                @endif
                                <br>
                                <div class="form-row">
                                    <div class="form-group col-xl-6 col-lg-12">
                                        {!! Form::label('date', 'Datum:') !!}
                                        {!! Form::date('date', null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-12">
                                        {!! Form::label('time', 'Zeit:') !!}
                                        {!! Form::time('time', null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>
                                <br>
                                {!! Form::label('user_erf', 'Erfasser:') !!}
                                {!! Form::text('user_erf', null, ['class' => 'form-control', 'required']) !!}
                                <br>
                                {!! Form::label('health_status_id', 'Dringlichkeit:') !!}
                                {!! Form::select('health_status_id', $health_status, null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group col-xl-8 col-lg-12">

                                <div class="form-row">
                                    <div class="form-group col-xl-6 col-lg-12">
                                    {!! Form::label('parameter','Parameter / Symptom:', ['id'=>'parameter_label']) !!}
                                    {!! Form::textarea('parameter', null, ['class' => 'form-control', 'required', 'rows'=> 3, 'id'=>'parameter_value']) !!}
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-12">
                                        {!! Form::label('value', 'Wert:', ['id'=>'value_label']) !!}
                                        {!! Form::textarea('value', null, ['class' => 'form-control', 'rows'=> 3]) !!}
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-xl-6 col-lg-12">
                                        {!! Form::label('medication', 'Intervention / Medikation:') !!}
                                        {!! Form::textarea('medication', null, ['class' => 'form-control', 'rows'=> 4]) !!}
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-12">
                                        {!! Form::label('comment', 'Bemerkung:') !!}
                                        {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows'=> 4]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xl-2 col-lg-12">
                                <a href="#" class="intervention_image"> <img src="/img/xabcde.png" alt="" id="intervention_file" width="40%"></a>

                                <div class="form-group" id="intervention_picture">
                                    {!! Form::label('file', 'Bild:') !!}
                                    {!! Form::file('file', ['accept' => 'image/*', 'capture'=>'camera']) !!}
                                </div>
                            </div>
                        </div>
                        @foreach($interventions as $key => $intervention_sub)
                            <hr class="h-0.5 mx-auto my-4 bg-gray-300 border-0 rounded md:my-10 dark:bg-gray-700">
                            <p>Intervention Nr. {{$intervention_sub->number()}}</p>
                            <div class="form-row ml-10">
                                <div class="form-group col-xl-2 col-lg-12">
                                    {!! Form::hidden('intervention_sub['.$key.'][health_information_id]', $intervention_sub['health_information_id']) !!}
                                    {!! Form::hidden('intervention_sub['.$key.'][intervention_id]', $intervention_sub['id']) !!}
                                    <br>
                                    <div class="form-row">
                                        <div class="form-group col-xl-6 col-lg-12">
                                            {!! Form::label('intervention_sub['.$key.'][date]', 'Datum:') !!}
                                            {!! Form::date('intervention_sub['.$key.'][date]', $intervention_sub['date'], ['class' => 'form-control', 'required']) !!}
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12">
                                            {!! Form::label('intervention_sub['.$key.'][time]', 'Zeit:') !!}
                                            {!! Form::time('intervention_sub['.$key.'][time]',  $intervention_sub['time'], ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>
                                    <br>
                                    {!! Form::label('intervention_sub['.$key.'][user_erf]', 'Erfasser:') !!}
                                    {!! Form::text('intervention_sub['.$key.'][user_erf]',  $intervention_sub['user_erf'], ['class' => 'form-control', 'required']) !!}
                                    <br>
                                    {!! Form::label('intervention_sub['.$key.'][health_status_id]', 'Dringlichkeit:') !!}
                                    {!! Form::select('intervention_sub['.$key.'][health_status_id]', $health_status,  $intervention_sub['health_status_id'], ['class' => 'form-control', 'required']) !!}
                                </div>
                                <div class="form-group col-xl-8 col-lg-12">

                                    <div class="form-row">
                                        <div class="form-group col-xl-6 col-lg-12">
                                        {!! Form::label('intervention_sub['.$key.'][parameter]','Parameter / Symptom:', ['id'=>'parameter_label']) !!}
                                        {!! Form::textarea('intervention_sub['.$key.'][parameter]',  $intervention_sub['parameter'], ['class' => 'form-control', 'required', 'rows'=> 3, 'id'=>'parameter_value']) !!}
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12">
                                            {!! Form::label('intervention_sub['.$key.'][value]', 'Wert:', ['id'=>'value_label']) !!}
                                            {!! Form::textarea('intervention_sub['.$key.'][value]',  $intervention_sub['value'], ['class' => 'form-control', 'rows'=> 3]) !!}
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-xl-6 col-lg-12">
                                            {!! Form::label('intervention_sub['.$key.'][medication]', 'Intervention / Medikation:') !!}
                                            {!! Form::textarea('intervention_sub['.$key.'][medication]',  $intervention_sub['medication'], ['class' => 'form-control', 'rows'=> 4]) !!}
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12">
                                            {!! Form::label('intervention_sub['.$key.'][comment]', 'Bemerkung:') !!}
                                            {!! Form::textarea('intervention_sub['.$key.'][comment]',  $intervention_sub['comment'], ['class' => 'form-control', 'rows'=> 4]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xl-2 col-lg-12">
                                    <div class="form-group" id="intervention_picture">
                                        {!! Form::label('intervention_sub['.$key.'][file]', 'Bild:') !!}
                                        {!! Form::file('intervention_sub['.$key.'][file]', ['accept' => 'image/*', 'capture'=>'camera']) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div id="container_new_interventions">
                        </div>
                        <x-intervention-close :close="$intervention_close"/>
                        
                        <div class="form-group">
                            {!! Form::submit(isset($intervention['id']) ? 'Intervention aktualisieren' : 'Intervention erstellen', ['class' => 'btn btn-primary', 'id' => 'submit_btn'])!!}
                            @if(!isset($intervention['intervention_master_id']))
                                <a href="#" class="btn btn-primary" role="button" id="addIntervention">Untergeordnete Intervention hinzufügen</a>
                            @endif
                            @if(isset($intervention['id']) && !isset($intervention['date_close']))
                                <a href="#" class="btn btn-primary" role="button" id="closeIntervention">Intervention abschliessen</a>
                            @endif
                        </div>
                    {!! Form::close()!!}
                </div>
                <div class="col-md-2">
                    @if(!$camp['konekta'])
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
                            @if ($healthinformation['file_protocol'])
                                <a href={{$healthinformation['file_protocol'] ? route('downloadProtocol',$healthinformation) : '#'}}>Protokoll herunterladen</a>
                            @endif
                            <br>
                        @endif
                        <a href={{route('healthinformation.print',$healthinformation)}} class="btn btn-primary" target="blank">Druckversion</a>
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
                                <td style="width:30%">Dauermedikation: Medikament, Dosis, Zeitpunkt</td>
                                <td>{{$healthinformation['drug_longterm']}}</td>
                            </tr>
                            <tr>
                                <td style="width:30%">Bei Bedarf: Medikament, Dosis</td>
                                <td>{{$healthinformation['drug']}}</td>
                            </tr>
                            <tr>
                                <td style="width:30%">Notfallmedikation: Medikament, Dosis, Zeitpunkt</td>
                                <td>{{$healthinformation['drug_emergency']}}</td>
                            </tr>
                            <tr>
                                <td style="width:30%">Bemerkungen (chronische Leiden, Bettnässer usw.)</td>
                                <td>{!! nl2br(e($healthinformation['chronicle_diseases'])) !!}</td>
                            </tr>
                            <tr style="{{$healthinformation['ointment_only_contact'] ? '' : 'color:red'}}">
                                <td style="width:30%">Salben ohne Rückfragen?</td>
                                <td>{{$healthinformation['ointment_only_contact'] ? 'Ja' : 'Nein'}}</td>
                            </tr>
                            <tr style="{{$healthinformation['drugs_only_contact'] ? '' : 'color:red'}}">
                                <td style="width:30%">Medikamente ohne Rückfragen?</td>
                                <td>{{$healthinformation['drugs_only_contact'] ? 'Ja' : 'Nein'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3>Allergien</h3>
                    <p>{!! nl2br(e($healthinformation['allergy'])) !!}</p>
                </div>
            </div>
            <hr>
            <x-intervention-table :healthinformation="$healthinformation"/>
        </div>
    </section>
@endsection

@push('scripts')
    <x-filter-buttons-javascript :healthinformation="$healthinformation"/>
    <script type="module">
        var new_interventions = 0;
        $('#addIntervention').click(function($e) {
            $e.preventDefault();
            var health_information = @json($healthinformation);
            var intervention = @json($intervention);
            $.ajax({
                url: '{{ route('interventions.addNew') }}',
                type: 'GET',
                data: {
                    healthInformation_id: health_information['id'],
                    index: new_interventions,
                },
                success: function (response) {
                    $('#container_new_interventions').append(response);
                    let el = document.getElementById('newDelete_' + new_interventions);
                    el.addEventListener("click", function(event) {
                        event.preventDefault();
                        this.parentElement.parentElement.parentElement.remove();
                    });
                    new_interventions++;
                },
            });
        });
        $('#closeIntervention').click(function($e) {
            $e.preventDefault();
            var intervention = @json($intervention);
            $.ajax({
                url: '{{ route('interventions.closeAjax') }}',
                type: 'GET',
                data: {
                    intervention_id: intervention['id'],
                },
                success: function (response) {
                    $('#container_intervention_close').empty();
                    $('#container_intervention_close').append(response);
                    let date =  new Date();
                    let dstrings = getHTML5DateTimeStringsFromDate(date);
                    document.querySelector('#date_close').value = dstrings[0];
                    document.querySelector('#time_close').value = dstrings[1];
                },
            });
        });
        function getHTML5DateTimeStringsFromDate(d) {
            // Date string
            let ds = d.getFullYear().toString().padStart(4, '0') + '-' + (d.getMonth()+1).toString().padStart(2, '0') + '-' + d.getDate().toString().padStart(2, '0');

            // Time string
            let ts = d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');

            // Return them in array
            return [ds, ts];
        }
    </script>
@endpush


