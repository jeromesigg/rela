@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Teilnehmerübersicht</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Teilnehmerübersicht</h1>
            </header>
            <br>
            <table class="table table-striped table-bordered" style="width:100%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col" width="9%">Code</th>
                        <th scope="col" width="13%"># Patientenüberwachung</th>
                        <th scope="col" width="13%"># Verabreichte Medikationen</th>
                        <th scope="col" width="13%"># 1. Hilfe Leistungen</th>
                        <th scope="col" width="13%"># Krankheiten</th>
                        <th scope="col" width="13%"># Sicherheitsrelevante Ereignisse</th>
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
                    { data: 'monitorings', name: 'monitorings' },
                    { data: 'medications', name: 'medications' },
                    { data: 'measures', name: 'measures' },
                    { data: 'surveillances', name: 'surveillances' },
                    { data: 'incidents', name: 'incidents' },

                    ]
            });
        });
    </script>
@endsection
