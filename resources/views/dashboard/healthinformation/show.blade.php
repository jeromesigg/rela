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
                                {!! Form::label('date', 'Datum:') !!}
                                {!! Form::date('date', null, ['class' => 'form-control', 'required']) !!}
                                <br>
                                {!! Form::label('time', 'Zeit:') !!}
                                {!! Form::time('time', null, ['class' => 'form-control', 'required']) !!}
                                <br>
                                {!! Form::label('user_erf', 'Erfasser:') !!}
                                {!! Form::text('user_erf', null, ['class' => 'form-control', 'required']) !!}
                                <br>
                                {!! Form::label('health_status_id', 'Dringlichkeit:') !!}
                                {!! Form::select('health_status_id', $health_status, null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-xl-8 col-lg-12">

                                <div class="form-row">
                                    <div class="form-group col-xl-6 col-lg-12">
                                    {!! Form::label('parameter','Parameter / Symptom:', ['id'=>'parameter_label']) !!}
                                    {!! Form::textarea('parameter', null, ['class' => 'form-control', 'required', 'rows'=> 3, 'id'=>'parameter_value']) !!}
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-12">
                                        {!! Form::label('value', 'Wert:', ['id'=>'value_label']) !!}
                                        {!! Form::textarea('value', null, ['class' => 'form-control', 'required', 'rows'=> 3]) !!}
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
                        @if ($healthinformation['file_protocol'])
                            <a href={{$healthinformation['file_protocol'] ? route('downloadProtocol',$healthinformation) : '#'}}>Protokoll herunterladen</a>
                        @endif
                        <br>
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
@endpush


