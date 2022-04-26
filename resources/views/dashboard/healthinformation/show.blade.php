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
            <hr>
            <x-observation-table :observationclasses="$observation_classes" :healthinformation="$healthinformation"/>
        </div>
    </section>
@endsection

@section('scripts')
    <x-filter-buttons-javascript :healthinformation="$healthinformation"/>
@endsection

