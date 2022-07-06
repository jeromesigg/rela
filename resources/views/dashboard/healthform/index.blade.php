@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Gesundsheitsblätter</li>
            </ul>
        </div>
    </div>
    @if (Session::has('deleted_healthform'))
        <p class="bg-danger">{{session('deleted_healthform')}}</p>
    @endif
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Gesundsheitsblätter</h1>
            </header>
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{route('healthforms.create')}}" class="btn btn-primary" role="button">Gesundsheitsblatt erstellen</a>
                </div>
                @if (Auth::user()->isAdmin())
{{--                    <div class="col-lg-4">--}}
{{--                        <button id="showImport" class="btn btn-primary btn-sm">Gesundsheitsblätter aus Cevi-DB importieren</button>--}}
{{--                    </div>--}}
                    <div class="col-lg-4">
                        {!! Form::open(['action' => 'HealthFormController@uploadFile', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <div class="form-group">
                                {{ Form::file('file',)}}
                            </div>
                            {{ Form::submit('Teilnehmerliste hochladen', ['class' => 'btn btn-primary']) }}
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
            <br>
            <table class="table table-striped table-bordered" style="width:100%" id="datatable">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Ceviname</th>
                        <th scope="col">Vorname</th>
                        <th scope="col">Nachname</th>
                        <th scope="col" >Geburtsdatum</th>
                        <th scope="col">Abteilung</th>
                        <th scope="col">Ort</th>
                        <th scope="col">Ausgefüllt</th>
                        <th scope="col">Öffnen</th>
                    </tr>
                </thead>
            </table>
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{route('healthforms.create')}}" class="btn btn-primary" role="button">Gesundsheitsblatt erstellen</a>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="importModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Gesundsheitsblätter aus Cevi-DB importieren</h4>
                </div>
                <div class="modal-body">
                    <form id="modal-form" method="POST" action="javascript:void(0)">
                        <div class="form-group">
                            <button data-remote='{{route('healthforms.import')}}' id="importUsers" class="btn btn-primary btn-sm"><i class="fa fa-spinner fa-spin display-none" id="loading-spinner"></i> Gesundsheitsblätter importieren</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                ajax: "{!! route('healthforms.CreateDataTables') !!}",
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'nickname', name: 'nickname' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'birthday', name: 'birthday' },
                    { data: 'group', name: 'group' },
                    { data: 'city', name: 'city' },
                    { data: 'finish', name: 'finish' },
                    { data: 'Actions', name: 'Actions', orderable:false,serachable:false,sClass:'text-center'},

                ]
            });
        });
        $('#showImport').on('click', function () {
            $('#importModal').modal('show');
        });

        $('#importUsers').on('click', function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            var url = $(this).data('remote');
            // confirm then
            $.ajax({
                url: url,
                method: 'POST',
                beforeSend: function() { $('#loading-spinner').removeClass('display-none')},
                complete: function() {  $('#loading-spinner').addClass('display-none') },
                success:function(res)
                {
                    $('#modal-form').trigger('reset');
                    $('#importModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, errorType, exception) {
                    alert(exception + ': ' + xhr.responseJSON.message);
                }
            });
        });
    </script>
@endsection
