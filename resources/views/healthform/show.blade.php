@extends('layouts.layout')

@section('page')
    <div class="text-right">
        <div class="healthform--text">
        GESUNDHEITSBLATT
        </div>
        <div class="healthform--label">
        GS | 27.01.2021
        </div>
    </div>
    <!-- Page Header-->
    <h3>1. Personalie</h3>
    <hr>
    <div class="row">
        <div class="col-md-1 healthform--label">
            Vorname:
        </div>
        <div class="col-md-2 healthform--text">
            {{$healthform['first_name']}}
        </div>
        <div class="col-md-1 healthform--label">
           Name:
        </div>
        <div class="col-md-2 healthform--text">
            {{$healthform['last_name']}}
        </div>
        <div class="col-md-1 healthform--label">
            v/o:
        </div>
        <div class="col-md-1 healthform--text">
           {{$healthform['nickname']}}
        </div>
        <div class="col-md-2 healthform--label">
            Geburtstag:
        </div>
        <div class="col-md-2 healthform--text">
            {{Carbon\Carbon::parse($healthform['birthday'])->format('d.m.Y')}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-1 healthform--label">
            Strasse:
        </div>
        <div class="col-md-3 healthform--text">
            {{$healthform['street']}}
        </div>
        <div class="col-md-2 healthform--label">
           Ortschaft:
        </div>
        <div class="col-md-3 healthform--text">
            {{$healthform['zip_code']}} {{$healthform['city']}}
        </div>
        <div class="col-md-1 healthform--label">
            Telefon:
        </div>
        <div class="col-md-2 healthform--text">
            {{$healthform['phone_number']}}
        </div>
    </div>
    <br>
    <h3>2. Eltern (im Notfall zu erreichende Person)</h3>
    <hr>
    <div class="row">
        <div class="col-md-2 healthform--label">
           Name:
        </div>
        <div class="col-md-7 healthform--text">
            {{$healthform['emergency_contact_name']}}
        </div>
        <div class="col-md-1 healthform--label">
            Telefon:
        </div>
        <div class="col-md-2 healthform--text">
            {{ $healthform['emergency_contact_phone']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 healthform--label">
            Wohnadresse während ReLa:
        </div>
        <div class="col-md-10 healthform--text">
            {{$healthform['emergency_contact_address']}}
        </div>
    </div>
    <br>
    <h3>3. Hausarzt, Versicherung</h3>
    <hr>
    <div class="row">
        <div class="col-md-4 healthform--label">
            Hausarzt: Name, Telefon:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthform['doctor_contact']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 healthform--label">
            Krankenkasse: Name, Versichertennummer:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthform['health_insurance_contact']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 healthform--label">
            Unfallversicherung: Name, Versichertennummer:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthform['accident_insurance_contact']}}
        </div>
    </div>
    <br>
    <h3>4. Gesundheitszustand</h3>
    <hr>
    <div class="row">
        <div class="col-md-4 healthform--label">
            kürzliche Unfälle / Krankheiten? abgeschlossen?
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthinfo['recent_issues']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 healthform--label">
           behandelnder Arzt: Name, Telefon:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthinfo['recent_issues_doctor']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 healthform--label">
            Dauermedikation: Medikament (mitgeben!), Dosis, Zeitpunkt:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthinfo['drug_longterm']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 healthform--label">
            Bei Bedarf: Medikament (mitgeben!), Dosis:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthinfo['drug_demand']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 healthform--label">
            Notfallmedikation: Medikament (mitgeben!), Dosis, Zeitpunkt:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthinfo['drug_emergency']}}
        </div>
    </div>
    <br>
    <h4>5. Allergien</h4>
    <hr>
        <div class="row">
            <div class="col-md-12 healthform--label">
                {!! nl2br(e($healthinfo['allergy'])) !!}
            </div>
        </div>
    <br>
    <h4>6. Ergänzungen</h4>
    <hr>
    <div class="row">
        <div class="col-md-1 healthform--text">
            {{$healthform['swimmer'] ? 'Ja' : 'Nein'}}
        </div>
        <div class="col-md-11 healthform--label">
            Teilnehmer/-in kann schwimmen
        </div>
    </div>
    <div class="row">
        <div class="col-md-1 healthform--text">
            {{$healthinfo['ointment_only_contact'] ? 'Ja' : 'Nein'}}
        </div>
        <div class="col-md-11 healthform--label"  style="{{$healthinfo['ointment_only_contact'] ? '' : 'color:red'}}">
            Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie Sablen selbständig vom Lagerteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.
        </div>
    </div>
    <div class="row">
        <div class="col-md-1 healthform--text">
            {{$healthinfo['drugs_only_contact'] ? 'Ja' : 'Nein'}}
        </div>
        <div class="col-md-11 healthform--label" style="{{$healthinfo['drugs_only_contact'] ? '' : 'color:red'}}">
            Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie Medikamente (z.B.
            Schmerzmedikamente) selbständig vom Lagerteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 healthform--label">
            Bemerkungen (chronische Leiden, Bettnässer usw.)
        </div>
        <div class="col-md-10 healthform--text">
            {!! nl2br(e($healthinfo['chronicle_diseases'])) !!}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2 healthform--label">
            Letzte Tetanus-Impfung:
        </div>
        <div class="col-md-10 healthform--text">
            {{$healthform['vaccination']}}
        </div>
    </div>
    <div class="healthform--text">
        Evtl. <a href={{$healthform['file_allergies'] ? route('downloadAllergy',$healthform) : '#'}}>Allergiepass</a> beilegen!
    </div>
    <div class="healthform--label">
    Versicherung ist Sache der Teilnehmenden.
        <br>
    Alle wichtigen Angaben zum Gesundheitszustand sind auf diesem Blatt vermerkt.
    </div>
    <br>
    <a type="button" class="btn btn-info btn-sm" href="{{route('healthform.downloadPDF', $healthform)}}">Zur Druckansicht</a>
@endsection
