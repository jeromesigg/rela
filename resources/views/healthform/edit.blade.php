@extends('layouts.layout')

@section('page')
    <x-page-title :title="$title" :help="$help" :subtitle="$subtitle" :header="false"/>
    <div class="wide" id="all">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::model($healthform, ['method' => 'Patch', 'action'=>['HealthFormController@update',$healthform], 'files' => true]) !!}
        <h4>1. Personalie</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-3">
                {!! Form::label('healthform[first_name]', 'Vorname:') !!}
                {!! Form::text('healthform[first_name]', $healthform['first_name'], ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('healthform[last_name]', 'Name:') !!}
                {!! Form::text('healthform[last_name]', $healthform['last_name'], ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('healthform[nickname]', 'v/o:') !!}
                {!! Form::text('healthform[nickname]', $healthform['nickname'], ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('healthform[birthday]', 'Geburtstag:') !!}
                {!! Form::date('healthform[birthday]', $healthform['birthday'], ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('healthform[street]', 'Strasse:') !!}
                {!! Form::text('healthform[street]', $healthform['street'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('healthform[zip_code]', 'Postleitzahl:') !!}
                {!! Form::number('healthform[zip_code]', $healthform['zip_code'], ['class' => 'form-control autocomplete_txt']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('healthform[city]', 'Ortschaft:') !!}
                {!! Form::text('healthform[city]', $healthform['city'], ['class' => 'form-control autocomplete_txt']) !!}
            </div>
            {!! Form::hidden('city_id', null, ['class' => 'form-control autocomplete_txt']) !!}
            <div class="form-group col-md-3">
                {!! Form::label('healthform[phone_number]', 'Telefon (Bei Leitungspersonen):') !!}
                {!! Form::text('healthform[phone_number]', $healthform['phone_number'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <br>
        <h4>2. Eltern (im Notfall zu erreichende Person)</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('healthform[emergency_contact_name]', 'Name:') !!}
                {!! Form::text('healthform[emergency_contact_name]', $healthform['emergency_contact_name'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-5">
                {!! Form::label('healthform[emergency_contact_address]', 'Wohnadresse während der Lagerwoche:') !!}
                {!! Form::text('healthform[emergency_contact_address]', $healthform['emergency_contact_address'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('healthform[emergency_contact_phone]', 'Telefon:') !!}
                {!! Form::text('healthform[emergency_contact_phone]', $healthform['emergency_contact_phone'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <br>
        <h4>3. Hausarzt, Versicherung</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('healthform[doctor_contact]', 'Hausarzt: Name, Telefon:') !!}
                {!! Form::text('healthform[doctor_contact]', $healthform['doctor_contact'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('healthform[health_insurance_contact]', 'Krankenkasse: Name, Versichertennummer:') !!}
                {!! Form::text('healthform[health_insurance_contact]', $healthform['health_insurance_contact'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('healthform[accident_insurance_contact]', 'Unfallversicherung: Name, Versichertennummer:') !!}
                {!! Form::text('healthform[accident_insurance_contact]', $healthform['accident_insurance_contact'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <br>
        <h4>4. Allergien</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('healthinfo[allergy]', 'Allergische Substanz - Wie zeigt sich die Allergie?') !!}
                {!! Form::textarea('healthinfo[allergy]', $healthinfo['allergy'], ['class' => 'form-control', 'rows' => 3]) !!}
            </div>

        </div>
        <br>
        <h4>5. Gesundheitszustand</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('healthinfo[recent_issues]', 'kürzliche Unfälle / Krankheiten abgeschlossen?') !!}
                {!! Form::textarea('healthinfo[recent_issues]', $healthinfo['recent_issues'], ['class' => 'form-control', 'rows' => 2]) !!}
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('healthinfo[recent_issues_doctor]', 'behandelnder Arzt: Name, Telefon:') !!}
                    {!! Form::text('healthinfo[recent_issues_doctor]', $healthinfo['recent_issues_doctor'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('healthinfo[drug_longterm]', 'Dauermedikation: Medikament (mitgeben!), Dosis, Zeitpunkt:') !!}
            {!! Form::textarea('healthinfo[drug_longterm]', $healthinfo['drug_longterm'], ['class' => 'form-control', 'rows' => 2]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('healthinfo[drug_demand]', 'Bei Bedarf: Medikament (mitgeben!), Dosis:') !!}
            {!! Form::textarea('healthinfo[drug_demand]', $healthinfo['drug_demand'], ['class' => 'form-control', 'rows' => 2]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('healthinfo[drug_emergency]', 'Notfallmedikation: Medikament (mitgeben!), Dosis, Zeitpunkt:') !!}
            {!! Form::textarea('healthinfo[drug_emergency]', $healthinfo['drug_emergency'], ['class' => 'form-control', 'rows' => 2]) !!}
        </div>
        <br>
        <h4>6. Ergänzungen</h4>
        <hr>
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::checkbox('healthform[swimmer]', '1', $healthform['swimmer']) !!}
                    {!! Form::label('healthform[swimmer]', 'Teilnehmer/-in kann schwimmen') !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('healthinfo[ointment_only_contact]', '1', $healthinfo['ointment_only_contact'], ['class'=>'healthform__checkbox']) !!}
                    <label for="healthinfo[ointment_only_contact]">
                        Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie <b>lokale</b> Medikamente (Desinfektionsspray, Salber, Augentropfen, etc.) selbständig vom Sanitätsteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.
                    </label>
                </div>
                <div class="form-group">
                    {!! Form::checkbox('healthinfo[drugs_only_contact]', '1', $healthinfo['drugs_only_contact'], ['class'=>'healthform__checkbox']) !!}
                    <label for="healthinfo[drugs_only_contact]">
                        Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie <b>orale</b> Medikamente (z.B. Halslutschtabletten, orale Schmerzmedikamente) selbständig vom Sanitätsteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.
                    </label>
                </div>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('healthinfo[chronicle_diseases]', 'Bemerkungen (chronische Leiden, Bettnässer usw.)') !!}
                {!! Form::textarea('healthinfo[chronicle_diseases]', $healthinfo['chronicle_diseases'], ['class' => 'form-control', 'rows' => 9]) !!}
            </div>
        </div>
        <br>
        <h4>7. Impfungen und Allergiepass</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('healthform[vaccination]', 'Letzte Tetanus Impfung erfolgt am:') !!}
                {!! Form::text('healthform[vaccination]', $healthform['vaccination'], ['class' => 'form-control' , 'placeholder' => 'Datum bzw Keine']) !!}
            </div>
            <div class="form-group col-md-6">
                @if(isset($healthform['file_allergies']))
                    Allergiepass schon hochgeladen <br>
                @endif
                {!! Form::label('healthform[file_allergies]', 'Allergiepass:') !!}
                {!! Form::file('healthform[file_allergies]', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <br>
        @if($health_questions->count()>0)

            <h4>8. Lagerspezifische Fragen</h4>
            <hr>
            <div class="form-row">
                @foreach($health_questions as $health_question)
                    <div class="form-group col-md-6">
                        {!! Form::label('health_question['. $health_question->id.']', $health_question->question['name']) !!}
                        {!! Form::text('health_question['. $health_question->id.']', $health_question['answer'], ['class' => 'form-control']) !!}
                    </div>
                @endforeach
            </div>
            <br>
        @endif
        <h4> @if($health_questions->count()>0)
                9.
            @else
                8.
            @endif
            Abschluss</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::submit('Gesundheitsblatt speichern', ['class' => 'btn btn-primary', 'name' => 'submit_btn', 'value' => 'save'])!!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::checkbox('healthinfo[accept_privacy_agreement]', '1', $healthinfo['accept_privacy_agreement']) !!}
                Ich bestätige, dass alle Angaben vollständig sind, der Wahrheit entsprechen und dass meine Gesundheits-Daten für die Zeitdauer des Lagers gesammelt werden dürfen.
                <br>

                {!! Form::submit('Gesundheitsblatt abschliessen', ['class' => 'btn btn-primary', 'name' => 'submit_btn', 'value' => 'close'])!!}
            </div>
        </div>
        {!! Form::close()!!}
    </div>

@endsection


@push('scripts')
    <script type="text/javascript">
        //autocomplete script
        $(document).on('focus','.autocomplete_txt',function(){
            type = $(this).attr('name');

            if(type =='healthform[city]')autoType='name';
            if(type =='healthform[zip_code]')autoType='plz';
            if(type =='city_id')autoType='id';

            $(this).autocomplete({
                minLength: 2,
                highlight: true,
                source: function( request, response ) {
                    $.ajax({
                        url: "{{ route('searchajaxcity') }}",
                        dataType: "json",
                        data: {
                            term : request.term,
                            type : type,
                        },
                        success: function(data) {
                            var array = $.map(data, function (item) {
                                return {
                                    label: item['plz'] + ' ' + item['name'],
                                    value: item[autoType],
                                    data : item
                                }
                            });
                            response(array)
                        }
                    });
                },
                select: function( event, ui ) {
                    var data = ui.item.data;
                    $("[name='healthform[city]']").val(data.name);
                    $("[name='healthform[zip_code]']").val(data.plz);
                    $("[name='city_id']").val(data.id);
                }
            });
        });
    </script>
@endpush
