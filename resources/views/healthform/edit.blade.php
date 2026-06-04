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
        <x-forms.form :action="route('healthform.update', $healthform)" accept-charset="UTF-8" method="PATCH" :model="$healthform" fullWidth=true>
        <h4>1. Personalie</h4>
        <hr>
        <x-forms.row>
            <x-forms.container class="col-md-3">
                <x-forms.text label="Vorname:" name="healthform[first_name]" required=true value="{{$healthform['first_name']}}"/>
            </x-forms.container>
            <x-forms.container class="col-md-3">
                <x-forms.text label="Nachname:" name="healthform[last_name]" required=true value="{{$healthform['last_name']}}"/>
            </x-forms.container>
            <x-forms.container class="col-md-3">
                <x-forms.text label="v/o:" name="healthform[nickname]" required=true value="{{$healthform['nickname']}}"/>
            </x-forms.container>
            <x-forms.container class="col-md-3">
                <x-forms.text label="Geburtstag:" name="healthform[birthday]" required=true value="{{$healthform['birthday']}}" type="date"/>
            </x-forms.container>
        </x-forms.row>
        <x-forms.row>
            <x-forms.container class="col-md-3">
                <x-forms.text label="Strasse:" name="healthform[street]" value="{{$healthform['street']}}"/>
            </x-forms.container>
            <x-forms.container class="col-md-3">
                <x-forms.text label="Postleitzahl:" name="healthform[zip_code]" class="autocomplete_txt" value="{{$healthform['zip_code']}}"/>
            </x-forms.container>
            <x-forms.container class="col-md-3">
                <x-forms.text label="Ortschaft:" name="healthform[city]" class="autocomplete_txt" value="{{$healthform['city']}}"/>
            </x-forms.container>
            <x-forms.hidden name="city_id" class="autocomplete_txt"/>
            <x-forms.container class="col-md-3">
                <x-forms.text label="Telefon (Bei Leitungspersonen):" name="healthform[phone_number]" value="{{$healthform['phone_number']}}"/>
            </x-forms.container>
        </x-forms.row>
        <br>
        <h4>2. Eltern (im Notfall zu erreichende Person)</h4>
        <hr>
        <x-forms.row>
            <x-forms.container class="col-md-4">
                <x-forms.text label="Name:" name="healthform[emergency_contact_name]" value="{{$healthform['emergency_contact_name']}}"/>
            </x-forms.container>
            <x-forms.container class="col-md-5">
                <x-forms.text label="Wohnadresse während der Lagerwoche:" name="healthform[emergency_contact_address]" value="{{$healthform['emergency_contact_address']}}"/>
            </x-forms.container>
            <x-forms.container class="col-md-3">
                <x-forms.text label="Telefon:" name="healthform[emergency_contact_phone]" value="{{$healthform['emergency_contact_phone']}}"/>
            </x-forms.container>
        </x-forms.row>
        <br>
        <h4>3. Hausarzt, Versicherung</h4>
        <hr>
        <x-forms.row>
            <x-forms.container class="col-md-6">
                <x-forms.text label="Hausarzt: Name, Telefon:" name="healthform[doctor_contact]" value="{{$healthform['doctor_contact']}}"/>
            </x-forms.container>
            <x-forms.container class="col-md-6">
                <x-forms.text label="Krankenkasse: Name, Versichertennummer:" name="healthform[health_insurance_contact]" value="{{$healthform['health_insurance_contact']}}"/>
            </x-forms.container>
        </x-forms.row>
        <x-forms.row>
            <x-forms.container class="col-md-6">
                <x-forms.text label="Unfallversicherung: Name, Versichertennummer:" name="healthform[accident_insurance_contact]" value="{{$healthform['accident_insurance_contact']}}"/>
            </x-forms.container>
        </x-forms.row>
        <br>
        <h4>4. Allergien</h4>
        <hr>
        <x-forms.row>
            <x-forms.container class="col-md-12">
                <x-forms.text-area label="Allergische Substanz - Wie zeigt sich die Allergie?" name="healthinfo[allergy]" value="{{$healthinfo['allergy']}}" rows=3/>
            </x-forms.container>
        </x-forms.row>
        <br>
        <h4>5. Gesundheitszustand</h4>
        <hr>
        <x-forms.row>
            <x-forms.container class="col-md-6">
                <x-forms.text-area label="kürzliche Unfälle / Krankheiten abgeschlossen?" name="healthinfo[recent_issues]" value="{{$healthinfo['recent_issues']}}" rows=2/>
            </x-forms.container>
            <x-forms.container class="col-md-6">
                <x-forms.text label="behandelnder Arzt: Name, Telefon:" name="healthinfo[recent_issues_doctor]" value="{{$healthinfo['recent_issues_doctor']}}"/>
            </x-forms.container>
        </x-forms.row>
            <x-forms.container>
                <x-forms.text-area label="Dauermedikation: Medikament (mitgeben!), Dosis, Zeitpunkt:" name="healthinfo[drug_longterm]" value="{{$healthinfo['drug_longterm']}}" rows=2/>
            </x-forms.container>
            <x-forms.container>
                <x-forms.text-area label="Bei Bedarf: Medikament (mitgeben!), Dosis:" name="healthinfo[drug_demand]" value="{{$healthinfo['drug_demand']}}" rows=2/>
            </x-forms.container>
            <x-forms.container>
                <x-forms.text-area label="Notfallmedikation: Medikament (mitgeben!), Dosis, Zeitpunkt:" name="healthinfo[drug_emergency]" value="{{$healthinfo['drug_emergency']}}" rows=2/>
            </x-forms.container>
        <br>
        <h4>6. Ergänzungen</h4>
        <hr>
        <x-forms.row>
            <div class="col-md-6">
                <x-forms.container>
                    <x-forms.checkbox label="Teilnehmer/-in kann schwimmen" name="healthform[swimmer]" value="{{$healthform['swimmer']}}"/>
                </x-forms.container>
                <x-forms.container>
                    <x-forms.checkbox label="Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie <b>lokale</b> Medikamente (Desinfektionsspray, Salber, Augentropfen, etc.) selbständig vom Sanitätsteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen." name="healthinfo[ointment_only_contact]" value="{{$healthinfo['ointment_only_contact']}}"/>
                </x-forms.container>
                <x-forms.container>
                    <x-forms.checkbox label="Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie <b>orale</b> Medikamente (z.B. Halslutschtabletten, orale Schmerzmedikamente) selbständig vom Sanitätsteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen." name="healthinfo[drugs_only_contact]" value="{{$healthinfo['drugs_only_contact']}}"/>
                </x-forms.container>
            </div>
            <x-forms.container class="col-md-6">
                <x-forms.text-area label="Bemerkungen (chronische Leiden, Bettnässer usw.)" name="healthinfo[chronicle_diseases]" value="{{$healthinfo['chronicle_diseases']}}" rows=9/>
            </x-forms.container>
        </x-forms.row>
        <br>
        <h4>7. Impfungen und Allergiepass</h4>
        <hr>
        <x-forms.row>
            <x-forms.container class="col-md-6">
                <x-forms.text label="Letzte Tetanus Impfung erfolgt am:" name="healthform[vaccination]" value="{{$healthform['vaccination']}}" placeholder="Datum bzw Keine"/>
            </x-forms.container>
            <x-forms.container class="col-md-6">
                @if(isset($healthform['file_allergies']))
                    Allergiepass schon hochgeladen <br>
                @endif
                <x-forms.file label="Allergiepass:" name="healthform[file_allergies]"/>
            </x-forms.container>
        </x-forms.row>
        <br>
        @if($health_questions->count()>0)

            <h4>8. Lagerspezifische Fragen</h4>
            <hr>
            <x-forms.row>
                @foreach($health_questions as $health_question)
                    <x-forms.container class="col-md-6">
                        <x-forms.text label="{{$health_question->question['name']}}" name="health_question[{{$health_question->id}}]" value="{{$health_question['answer']}}"/>
                    </x-forms.container>
                @endforeach
            </x-forms.row>
            <br>
        @endif
        <h4> @if($health_questions->count()>0)
                9.
            @else
                8.
            @endif
            Abschluss</h4>
        <hr>
        <x-forms.row>
            @if(!$camp['konekta'])
                <x-forms.container class="col-md-4">
                    <x-forms.button type="submit" class="btn btn-primary" name="submit_btn" value="save">
                        Gesundheitsblatt speichern
                    </x-forms.button>
                </x-forms.container> 
            @endif
            <div class="form-group col-md-6">
                <x-forms.checkbox label="Ich bestätige, dass alle Angaben vollständig sind, der Wahrheit entsprechen und dass meine Gesundheits-Daten für die Zeitdauer des Lagers gesammelt werden dürfen." name="healthinfo[accept_privacy_agreement]" value="{{$healthinfo['accept_privacy_agreement']}}"/>
                <br>
                <x-forms.container>
                    <x-forms.button type="submit" class="btn btn-primary" name="submit_btn" value="close">
                        Gesundheitsblatt abschliessen
                    </x-forms.button>
                </x-forms.container> 
            </div>
        </x-forms.row>

        </x-forms.form>
    </div>

@endsection


@push('scripts')
    <script type="module">
        //autocomplete script
        $(document).on('focus','.autocomplete_txt',function(){
            var type = $(this).attr('name');

            var autoType='name';
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
