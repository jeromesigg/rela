@extends('layouts.layout')

@section('page')
    <div class="wide" id="all">
        <h3>Hallo {{$healthform->nickname}}</h3>
        <br>
        {!! Form::model($healthform, ['method' => 'Patch', 'action'=>['HealthFormController@update',$healthform->id]]) !!}
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
                {!! Form::text('healthform[street]', $healthform['street'], ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('healthform[zip_code]', 'Postleitzahl:') !!}
                {!! Form::number('healthform[zip_code]', $healthform['zip_code'], ['class' => 'form-control autocomplete_txt', 'required']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('healthform[city]', 'Ortschaft:') !!}
                {!! Form::text('healthform[city]', $healthform['city'], ['class' => 'form-control autocomplete_txt', 'required']) !!}
            </div>
            {!! Form::hidden('city_id', null, ['class' => 'form-control autocomplete_txt']) !!}
            <div class="form-group col-md-3">
                {!! Form::label('healthform[phone_number]', 'Telefon:') !!}
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
                {!! Form::label('healthform[emergency_contact_address]', 'Adresse:') !!}
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
                {!! Form::label('healthform[accident_insurance_contact]', 'Unfallversicherung: Name, Hotline:') !!}
                {!! Form::text('healthform[accident_insurance_contact]', $healthform['accident_insurance_contact'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('healthform[health_insurance_contact]', 'Krankenkasse: Name, Hotline:') !!}
                {!! Form::text('healthform[health_insurance_contact]', $healthform['health_insurance_contact'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('healthform[liability_insurance_contact]', 'Haftpflichtversicherung: Name, Hotline:') !!}
                {!! Form::text('healthform[liability_insurance_contact]', $healthform['liability_insurance_contact'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <br>
        <h4>4. Gesundheitszustand</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('healthinfo[recent_issues]', 'kürzliche Unfälle / Krankheiten abgeschlossen?') !!}
                {!! Form::textarea('healthinfo[recent_issues]', $healthinfo['recent_issues'], ['class' => 'form-control', 'rows' => 4]) !!}
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('healthinfo[recent_issues_doctor]', 'behandelnder Arzt: Name, Telefon:') !!}
                    {!! Form::text('healthinfo[recent_issues_doctor]', $healthinfo['recent_issues_doctor'], ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('healthinfo[drugs]', 'Medikamente (mitgeben!) und Dosis:') !!}
                    {!! Form::text('healthinfo[drugs]', $healthinfo['drugs'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <br>
        <h4>5. Allergien (Folgen / Medikament / Bemerkungen)</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('allergies[0]', 'Heuschnupfen') !!}
                {!! Form::text('allergies[0]', $allergies[0]['comment'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('allergies[1]', 'Bienen- / Wespenstiche') !!}
                {!! Form::text('allergies[1]', $allergies[1]['comment'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('allergies[2]', 'Asthma bei / nach') !!}
                {!! Form::text('allergies[2]', $allergies[2]['comment'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('allergies[3]', 'Lebensmittel') !!}
                {!! Form::text('allergies[3]', $allergies[3]['comment'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('allergies[4]', 'Medikament (Wirkstoff)') !!}
                {!! Form::text('allergies[4]', $allergies[4]['comment'], ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('allergies[5]', 'anderes') !!}
                {!! Form::text('allergies[5]', $allergies[5]['comment'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <br>
        <h4>6. Ergänzungen</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-2">
                {!! Form::checkbox('healthform[swimmer]', '1', $healthform['swimmer']) !!}
                {!! Form::label('healthform[swimmer]', 'Teilnehmer/-in kann schwimmen') !!}
            </div>
            <div class="form-group col-md-5">
                {!! Form::checkbox('healthinfo[ointment_only_contact]', '1', $healthinfo['ointment_only_contact']) !!}{!! Form::label('healthinfo[ointment_only_contact]', 'Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie Salben selbständig vom Kursteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.') !!}
            </div>
            <div class="form-group col-md-5">
                {!! Form::checkbox('healthinfo[drugs_only_contact]', '1', $healthinfo['drugs_only_contact']) !!}{!! Form::label('healthinfo[drugs_only_contact]', 'Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie Medikamente (z.B.
Schmerzmedikamente) selbständig vom Kursteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.') !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('healthinfo[chronicle_diseases]', 'Bemerkungen (chronische Leiden, Bettnässer usw.)') !!}
            {!! Form::textarea('healthinfo[chronicle_diseases]', $healthinfo['chronicle_diseases'], ['class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <br>
        <h4>7. Abschluss</h4>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::submit('Gesundheitsblatt speichern', ['class' => 'btn btn-primary', 'name' => 'submit_btn', 'value' => 'save'])!!}
            </div>
            <div class="form-group col-md-6">
                Ich bestätige, dass alle Angaben vollständig sind und der Wahrheit entsprechen:
                {!! Form::submit('Gesundheitsblatt abschliessen', ['class' => 'btn btn-primary', 'name' => 'submit_btn', 'value' => 'close'])!!}
            </div>
        </div>
        {!! Form::close()!!}
    </div>

@endsection


@section('scripts')
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
@endsection
