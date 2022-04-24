@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Verabreichte Medikation</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Verabreichte Medikation</h1>
            </header>
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{route('medications.create')}}" class="btn btn-primary" role="button">Medikation erfassen</a>
                </div>
            </div>
            <br>
            <table class="table table-striped table-bordered" style="width:100%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col" width="5%">Datum</th>
                        <th scope="col" width="5%">Zeit</th>
                        <th scope="col" width="5%">Code</th>
                        <th scope="col" width="25%">Medikament</th>
                        <th scope="col" width="25%">Dosis</th>
                        <th scope="col" width="25%">Kommentar</th>
                        <th scope="col" width="10%">Erfasst von</th>
                    </tr>
                </thead>
            </table>
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{route('medications.create')}}" class="btn btn-primary" role="button">Medikation erfassen</a>
                </div>
            </div>
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
                ajax: "{!! route('medications.CreateDataTables') !!}",
                order: [[ 0, "desc" ], [1, "desc" ]],
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'time', name: 'time' },
                    { data: 'code', name: 'code' },
                    { data: 'drug', name: 'drug' },
                    { data: 'dose', name: 'dose' },
                    { data: 'comment', name: 'comment' },
                    { data: 'user', name: 'user' },

                    ]
            });
        });
    </script>
@endsection
