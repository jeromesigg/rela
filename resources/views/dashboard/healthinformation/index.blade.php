@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">J+S-Patientenprotokoll</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">J+S-Patientenprotokoll</h1>
            </header>
            <br>
            <table class="table table-striped table-bordered" style="width:100%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col" width="9%">Code</th>
                        <th scope="col" width="13%"># Allergien</th>
                        <th scope="col" width="13%"># Patientenüberwachung</th>
                        <th scope="col" width="13%"># Verabreichte Medikationen</th>
                        <th scope="col" width="13%"># Durchgeführte Massnahmen</th>
                        <th scope="col" width="13%"># Zustand des Patienten</th>
                        <th scope="col" width="13%"># Überwachung der Vitalfunktionen</th>
                        <th scope="col" width="13%"># Allgemeine Geschehnisse</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                pageLength: 25,
                language: {
                    "url": "/lang/Datatables.json"
                },
                ajax: "{!! route('healthinformation.CreateDataTables') !!}",
                order: [[ 0, "asc" ]],
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'allergies', name: 'allergies' },
                    { data: 'monitorings', name: 'monitorings' },
                    { data: 'medications', name: 'medications' },
                    { data: 'measures', name: 'measures' },
                    { data: 'surveillances', name: 'surveillances' },
                    { data: 'healthstatus', name: 'healthstatus' },
                    { data: 'incidents', name: 'incidents' },

                    ]
            });
        });
    </script>
@endsection
