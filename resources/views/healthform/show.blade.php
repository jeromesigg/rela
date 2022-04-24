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
        <div class="col-md-1 healthform--label">
           Name:
        </div>
        <div class="col-md-8 healthform--text">
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
        <div class="col-md-1 healthform--label">
            Adresse:
        </div>
        <div class="col-md-11 healthform--text">
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
            Unfallversicherung: Name, Hotline:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthform['accident_insurance_contact']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 healthform--label">
            Krankenkasse: Name, Hotline:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthform['health_insurance_contact']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 healthform--label">
            Haftpflichtversicherung: Name, Hotline:
        </div>
        <div class="col-md-8 healthform--text">
            {{$healthform['liability_insurance_contact']}}
        </div>
    </div>
    <br>
    <h3>4. Gesundheitszustand</h3>
    <hr>
    <div class="row">
        <div class="col-md-6 healthform--label">
            kürzliche Unfälle / Krankheiten? abgeschlossen?
        </div>
        <div class="col-md-6 healthform--text">
            {{$healthinfo['recent_issues']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 healthform--label">
           behandelnder Arzt: Name, Telefon:
        </div>
        <div class="col-md-6 healthform--text">
            {{$healthinfo['recent_issues_doctor']}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 healthform--label">
            Medikamente (mitgeben!) und Dosis:
        </div>
        <div class="col-md-6 healthform--text">
            {{$healthinfo['drugs']}}
        </div>
    </div>
    <br>
    <h4>5. Allergien (Folgen / Medikament / Bemerkungen)</h4>
    <hr>
        @foreach($allergies as $allergy)
            <div class="row">
                <div class="col-md-3 healthform--label">
                    {{$allergy->allergy['name']}}
                </div>
                <div class="col-md-9 healthform--text">
                    {{$allergy['comment']}}
                </div>
            </div>
        @endforeach
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
            {{$healthinfo['drugs_only_contact'] ? 'Ja' : 'Nein'}}
        </div>
        <div class="col-md-11 healthform--label">
            Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie Medikamente (z.B.
            Schmerzmedikamente) selbständig vom Kursteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.
        </div>
    </div>
    <div class="healthform--label">
        Bemerkungen (chronische Leiden, Bettnässer usw.)
    </div>
    <div class="healthform--text">
        {{$healthinfo['chronicle_diseases']}}
    </div>
    <br>
    <div class="healthform--text">
        Kopie Impfausweis und evtl. Allergiepass beilegen!
    </div>
    <div class="healthform--label">
    Versicherung ist Sache der Teilnehmenden.
        <br>
    Alle wichtigen Angaben zum Gesundheitszustand sind auf diesem Blatt vermerkt.
    </div>
    <br>
    <a type="button" class="btn btn-info btn-sm" href="{{route('healthform.downloadPDF', $healthform)}}">Zur Druckansicht</a>
@endsection
