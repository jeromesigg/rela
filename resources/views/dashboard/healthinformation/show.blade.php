@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help" :subtitle="$subtitle"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <div class="row">
                <div class="col-md-10">
                    <h3>Intervention erfassen</h3>
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
                        @if(isset($intervention['date_close']))
                            <hr class="h-1 mx-auto my-4 bg-gray-300 border-0 rounded md:my-10 dark:bg-gray-700">
                            <div class="form-row">
                                <div class="form-group col-xl-2 col-lg-12">
                                    {!! Form::label('date_close', 'Datum Ende Behandlung:') !!}
                                    {!! Form::date('date_close', null, ['class' => 'form-control', 'required']) !!}
                                    <br>
                                    {!! Form::label('time_close', 'Zeit Ende Behandlung:') !!}
                                    {!! Form::time('time_close', null, ['class' => 'form-control', 'required']) !!}
                                    <br>
                                    {!! Form::label('user_close', 'Erfasser Ende Behandlung:') !!}
                                    {!! Form::text('user_close', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                                <div class="form-group col-xl-8 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('further_treatment', 'Weiteres Prozedere:') !!}
                                        {!! Form::textarea('further_treatment', null, ['class' => 'form-control', 'rows'=> 3, 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('comment_close', 'Bemerkung Ende Behandlung:') !!}
                                        {!! Form::textarea('comment_close', null, ['class' => 'form-control', 'rows'=> 3]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            {!! Form::submit('Intervention erstellen', ['class' => 'btn btn-primary', 'id' => 'submit_btn'])!!}
                            @if(!isset($intervention['intervention_master_id']))
                                <a href="#" class="btn btn-primary" role="button" onclick="addIntervention()">Untergeordnete Intervention hinzufügen</a>
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
        function newDelete($index){
            console.log($index);
            document.getElementById("intervention_new_"+$index).remove();
        }
        function addIntervention(){
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
                    new_interventions++;
                },
            });
            // var health_status = @json($health_status);
            // console.log(health_status);
            // Get the element where the inputs will be added to
            // var container = document.getElementById("container_new_interventions");
            // var hr = document.createElement("hr");
            // hr.classList.add('h-0.5', 'mx-auto', 'my-4', 'bg-gray-300', 'border-0', 'rounded', 'md:my-10', 'dark:bg-gray-700');
            // container.appendChild(hr);
            // var br = document.createElement("br");
            // // Append a node with a random text
            // // Create an <input> element, set its type and name attributes
            // var div_formrow = document.createElement("div");
            // div_formrow.classList.add('form-row', 'ml-10');

            // var div_form_group_1 = document.createElement("div");
            // div_form_group_1.classList.add('form-group', 'col-xl-2', 'col-lg-12');

            // div_form_group_1.appendChild(CreateInput('hidden', 'intervention_new['+new_interventions+'][health_information_id]', false,  health_information['id']));
            // div_form_group_1.appendChild(CreateInput('hidden', 'intervention_new['+new_interventions+'][intervention_id]'));

            // var div_form_row_date = document.createElement("div");
            // div_form_row_date.classList.add('form-row');

            // var date = moment();
            // var div_form_row_date_col = document.createElement("div");
            // div_form_row_date_col.classList.add('form-group', 'col-xl-6', 'col-lg-12');
            // div_form_row_date_col.appendChild( CreateLabel('Datum', 'intervention_new['+new_interventions+'][date]'));
            // div_form_row_date_col.appendChild( CreateInput('date', 'intervention_new['+new_interventions+'][date]', true,  date.format('YYYY-MM-DD')));

            // var div_form_row_time_col = document.createElement("div");
            // div_form_row_time_col.classList.add('form-group', 'col-xl-6', 'col-lg-12');
           
            // div_form_row_time_col.appendChild( CreateLabel('Zeit', 'intervention_new['+new_interventions+'][time]'));
            // div_form_row_time_col.appendChild( CreateInput('time', 'intervention_new['+new_interventions+'][time]', true,  date.format('HH:mm')));
            // div_form_row_date.appendChild(div_form_row_date_col);
            // div_form_row_date.appendChild(div_form_row_time_col);
            // div_form_group_1.appendChild(div_form_row_date);
            // div_form_group_1.appendChild(br);
            // div_form_group_1.appendChild( CreateLabel('Erfasser', 'intervention_new['+new_interventions+'][user_erf]'));
            // div_form_group_1.appendChild( CreateInput('text', 'intervention_new['+new_interventions+'][user_erf]', true));
            // div_form_group_1.appendChild(br);
            // div_form_group_1.appendChild( CreateLabel('Dringlichkeit', 'intervention_new['+new_interventions+'][health_status_id]'));
            // div_form_group_1.appendChild( CreateInput('select', 'intervention_new['+new_interventions+'][health_status_id]', true, '', health_status));
            // div_formrow.appendChild(div_form_group_1);
            // container.appendChild(div_formrow);
         
        }
        // function CreateInput(inputType, name, required = false, value = '', array=[]){
        //     var input = document.createElement("input");
        //     input.type = inputType;
        //     input.value =value;
        //     input.name = name;
        //     input.id =  name;
        //     input.required = required;
        //     input.classList.add('form-control');
        //     if(array.length>0){
        //         array.forEach(element => {
        //             console.log(element);
        //             var option = document.createElement("option");
        //             option.value=element;
        //         });
        //     }
        //     return input;
        // }
        // function CreateLabel(name, labelFor){
        //     var label = document.createElement("label");
        //     label.htmlFor = labelFor + ":";
        //     label.innerHTML = name;
        //     return label;
        // }
        window.addIntervention = addIntervention;
        window.newDelete = newDelete;
    </script>
@endpush


