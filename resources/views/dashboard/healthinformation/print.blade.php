<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('app.name', 'ReLa Gesundheits-DB') }}">
    <meta name="author" content="Jérôme Sigg">
    <meta name="robots" content="all,follow">

    <title>{{ config('app.name', 'ReLa Gesundheits-DB') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    @vite([
      'resources/css/app.css',
      'resources/js/app.js'])
</head>

<body style="background: white">
<section>
    <div class="container-fluid" style="page-break-inside:avoid; width:1100px">
        <img src="/img/logo_region.svg" alt="" width="400px">
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
            <div class="col-md-6 healthform--label">
                Hausarzt: Name, Telefon:
            </div>
            <div class="col-md-6 healthform--text">
                {{$healthform['doctor_contact']}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 healthform--label">
                Krankenkasse: Name, Versichertennummer:
            </div>
            <div class="col-md-6 healthform--text">
                {{$healthform['health_insurance_contact']}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 healthform--label">
                Unfallversicherung: Name, Versichertennummer:
            </div>
            <div class="col-md-6 healthform--text">
                {{$healthform['accident_insurance_contact']}}
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
                {{$healthInformation['recent_issues']}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 healthform--label">
                behandelnder Arzt: Name, Telefon:
            </div>
            <div class="col-md-6 healthform--text">
                {{$healthInformation['recent_issues_doctor']}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 healthform--label">
                Dauermedikation: Medikament (mitgeben!), Dosis, Zeitpunkt:
            </div>
            <div class="col-md-6 healthform--text">
                {{$healthInformation['drug_longterm']}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 healthform--label">
                Bei Bedarf: Medikament (mitgeben!), Dosis:
            </div>
            <div class="col-md-6 healthform--text">
                {{$healthInformation['drug_demand']}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 healthform--label">
                Notfallmedikation: Medikament (mitgeben!), Dosis, Zeitpunkt:
            </div>
            <div class="col-md-6 healthform--text">
                {{$healthInformation['drug_emergency']}}
            </div>
        </div>
        <br>
        <h3>5. Allergien</h3>
        <hr>
        <div class="row">
            <div class="col-md-12 healthform--label">
                {!! nl2br(e($healthInformation['allergy'])) !!}
            </div>
        </div>
        <br>
        <h3>6. Ergänzungen</h3>
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
                {{$healthInformation['ointment_only_contact'] ? 'Ja' : 'Nein'}}
            </div>
            <div class="col-md-11 healthform--label">
                Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie Sablen selbständig vom Lagerteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 healthform--text">
                {{$healthInformation['drugs_only_contact'] ? 'Ja' : 'Nein'}}
            </div>
            <div class="col-md-11 healthform--label">
                Mir dürfen bei Bedarf und unter Berücksichtigung allfälliger Allergien rezeptfreie Medikamente (z.B. Schmerzmedikamente) selbständig vom Lagerteam verabreicht werden. Wir behalten uns vor, in Notfällen ohne Rücksprache einen Arzt aufzusuchen.
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 healthform--label">
                Bemerkungen (chronische Leiden, Bettnässer usw.)
            </div>
            <div class="col-md-9 healthform--text">
                {!! nl2br(e($healthInformation['chronicle_diseases'])) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3 healthform--label">
                Letzte Tetanus-Impfung:
            </div>
            <div class="col-md-9 healthform--text">
                {{$healthform['vaccination']}}
            </div>
        </div>
        <br>
        <h3>7. Interventionen</h3>
        <hr>
        <table class="table table-striped table-bordered" style="width:100%" id="datatable">
            <thead>
            <tr>
                <th scope="col">Datum</th>
                <th scope="col">Status</th>
                <th scope="col">Paramater</th>
                <th scope="col">Wert</th>
                <th scope="col">Intervention Medikation</th>
                <th scope="col">Bild</th>
                <th scope="col">Kommentar</th>
            </tr>
            </thead>
            <tbody>
        @foreach($healthInformation->interventions as $intervention)
            <tr>
                <td> {{\Carbon\Carbon::parse($intervention['date'])->format('d.m.Y')}} {{$intervention['time']}}</td>
                <td> {{$intervention->health_status ? $intervention->health_status['name'] : ''}}</td>
                <td> {{$intervention['parameter']}}</td>
                <td> {{$intervention['value']}}</td>
                <td> {{$intervention['medication']}}</td>
                <td> <a href="#" class="intervention_image"><img src="{{Storage::url($intervention['file'])}}" alt="" width="250px"></a></td>
                <td> {{$intervention['comment']}}</td>
            </tr>
        @endforeach
            </tbody>
        </table>
    </div>
</section>
</body>

</html>
