@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <x-intervention-table :interventionclasses="$intervention_classes" />
        </div>
    </section>

@endsection
@push('scripts')
    <x-filter-buttons-javascript :healthinformation=null/>
@endpush
