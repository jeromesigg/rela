@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <table class="table table-striped table-bordered" style="width:100%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col" width="9%">Code</th>
                        <th scope="col" width="13%">Beurteilung</th>
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
@push('scripts')
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
                buttons: [],
                ajax: "{!! route('healthinformation.CreateDataTables') !!}",
                order: [[ 0, "asc" ]],
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'status', name: 'status' },
                    // { data: 'allergy', name: 'allergy' },
                    // { data: 'recent_issues', name: 'recent_issues' },
                    { data: 'monitorings', name: 'monitorings' },
                    { data: 'medications', name: 'medications' },
                    { data: 'measures', name: 'measures' },
                    { data: 'surveillances', name: 'surveillances' },
                    { data: 'incidents', name: 'incidents' },

                    ]
            });
        });
    </script>
@endpush
