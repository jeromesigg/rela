@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Interventionen</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Alle Interventionen</h1>
            </header>
            <br>
            <x-intervention-table :interventionclasses="$intervention_classes" />
        </div>
    </section>

@endsection
@section('scripts')
    <x-filter-buttons-javascript :healthinformation=null/>
@endsection
