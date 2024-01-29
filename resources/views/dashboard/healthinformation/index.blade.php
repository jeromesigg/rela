@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <table class="table table-striped table-bordered" style="width:50%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%">Code</th>
                        <th scope="col" style="width: 10%">Beurteilung</th>
                        <th scope="col" style="width: 10%"># Interventionen Offen</th>
                        <th scope="col" style="width: 10%"># Interventionen Gesamt</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>

@endsection
@push('scripts')
    <script type="module">
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
                    { data: 'interventions_open', name: 'interventions_open' },
                    { data: 'interventions', name: 'interventions' },
                    ]
            });
        });
    </script>
@endpush
