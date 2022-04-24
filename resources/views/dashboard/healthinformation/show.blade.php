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
                <h1 class="h3 display">J+S-Patientenprotokoll von {{$healthinformation['code']}}</h1>
            </header>
            <br>
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                    <h3>Allergien</h3>
                    <table>
                        <thead>
                        <tr>
                                <th scope="col" width="25%">Allergie</th>
                                <th scope="col" width="75%">Kommentar</th>
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
            <br>
            <div class="row">
                <div class="col-md-6">
                    <h3>Patientenüberwachung</h3>
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" width="10%">Datum</th>
                                <th scope="col" width="10%">Zeit</th>
                                <th scope="col" width="20%">Symptom</th>
                                <th scope="col" width="20%">Wert</th>
                                <th scope="col" width="30%">Kommentar</th>
                                <th scope="col" width="10%">Erfasst von</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($healthinformation->monitorings as $monitoring)
                            <tr>
                                <td>{{Carbon\Carbon::parse($monitoring['date'])->format('d.m.Y')}}</td>
                                <td>{{$monitoring['time']}}</td>
                                <td>{{$monitoring['symptom']}}</td>
                                <td>{{$monitoring['value']}}</td>
                                <td>{{$monitoring['comment']}}</td>
                                <td>{{$monitoring->user['username']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3>Verabreichte Medikation</h3>
                    <table>
                        <thead>
                        <tr>
                            <th scope="col" width="10%">Datum</th>
                            <th scope="col" width="10%">Zeit</th>
                            <th scope="col" width="20%">Medikament</th>
                            <th scope="col" width="20%">Dosis</th>
                            <th scope="col" width="30%">Kommentar</th>
                            <th scope="col" width="10%">Erfasst von</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($healthinformation->medications as $medication)
                            <tr>
                                <td>{{Carbon\Carbon::parse($medication['date'])->format('d.m.Y')}}</td>
                                <td>{{$medication['time']}}</td>
                                <td>{{$medication['drug']}}</td>
                                <td>{{$medication['dose']}}</td>
                                <td>{{$medication['comment']}}</td>
                                <td>{{$medication->user['username']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <h3>Durchgeführte Massnahmen</h3>
                    <table>
                        <thead>
                        <tr>
                            <th scope="col" width="10%">Datum</th>
                            <th scope="col" width="10%">Zeit</th>
                            <th scope="col" width="40%">Massnahme</th>
                            <th scope="col" width="30%">Kommentar</th>
                            <th scope="col" width="10%">Erfasst von</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($healthinformation->measures as $measure)
                            <tr>
                                <td>{{Carbon\Carbon::parse($measure['date'])->format('d.m.Y')}}</td>
                                <td>{{$measure['time']}}</td>
                                <td>{{$measure['action']}}</td>
                                <td>{{$measure['comment']}}</td>
                                <td>{{$measure->user['username']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3>Zustand des Patienten</h3>
                    <table>
                        <thead>
                        <tr>
                            <th scope="col" width="10%">Datum</th>
                            <th scope="col" width="10%">Zeit</th>
                            <th scope="col" width="20%">Messwert</th>
                            <th scope="col" width="20%">Wert</th>
                            <th scope="col" width="30%">Kommentar</th>
                            <th scope="col" width="10%">Erfasst von</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($healthinformation->surveillances as $surveillance)
                            <tr>
                                <td>{{Carbon\Carbon::parse($surveillance['date'])->format('d.m.Y')}}</td>
                                <td>{{$surveillance['time']}}</td>
                                <td>{{$surveillance['parameter']}}</td>
                                <td>{{$surveillance['value']}}</td>
                                <td>{{$surveillance['comment']}}</td>
                                <td>{{$surveillance->user['username']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <h3>Überwachung der Vitalfunktionen</h3>
                    <table>
                        <thead>
                        <tr>
                            <th scope="col" width="10%">Datum</th>
                            <th scope="col" width="10%">Zeit</th>
                            <th scope="col" width="20%">Symptom</th>
                            <th scope="col" width="20%">Wert</th>
                            <th scope="col" width="30%">Kommentar</th>
                            <th scope="col" width="10%">Erfasst von</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($healthinformation->healthinfos as $healthinfo)
                            <tr>
                                <td>{{Carbon\Carbon::parse($healthinfo['date'])->format('d.m.Y')}}</td>
                                <td>{{$healthinfo['time']}}</td>
                                <td>{{$healthinfo['symptom']}}</td>
                                <td>{{$healthinfo['value']}}</td>
                                <td>{{$healthinfo['comment']}}</td>
                                <td>{{$healthinfo->user['username']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3>Überwachung der Vitalfunktionen</h3>
                    <table>
                        <thead>
                        <tr>
                            <th scope="col" width="10%">Datum</th>
                            <th scope="col" width="10%">Zeit</th>
                            <th scope="col" width="40%">Massnahme</th>
                            <th scope="col" width="30%">Kommentar</th>
                            <th scope="col" width="10%">Erfasst von</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($healthinformation->measures as $measure)
                            <tr>
                                <td>{{Carbon\Carbon::parse($measure['date'])->format('d.m.Y')}}</td>
                                <td>{{$measure['time']}}</td>
                                <td>{{$measure['action']}}</td>
                                <td>{{$measure['comment']}}</td>
                                <td>{{$measure->user['username']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
@endsection
