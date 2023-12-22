@extends('layouts.layout')

@section('page')
    <x-page-title :title="$title" :help="$help"/>
    @if (Session::has('deleted_user'))
        <p class="bg-danger">{{session('deleted_user')}}</p>
    @endif
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Personen</h1>
            </header>
            <div class="row">
                <div class="col-lg-3">
                    <p>Person Suchen:</p>
                    {!! Form::open(['method' => 'POST', 'action'=>'AdminUsersController@add']) !!}
                    <div class="form-group">
                        {!! Form::label('username_add', 'Name:') !!}
                        {!! Form::text('username_add', null, ['class' => 'form-control autocomplete_txt', 'placeholder' => 'name@abt', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('role_id_add', 'Rolle:') !!}
                        {!! Form::select('role_id_add', [''=>'Wähle Rolle'] + $roles, null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    {!! Form::hidden('user_id', null, ['class' => 'form-control autocomplete_txt']) !!}
                    <div class="form-group">
                        {!! Form::submit('Person Hinzufügen', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}
                </div>
                <div class="col-lg-3">
                    @if (config('app.import_db'))
                        <div class="col-lg-4">
                            <button id="showImport" class="btn btn-primary btn-sm"
                                    title="{{$has_api_token ? '' : 'Deine Region hat den DB-Import nicht freigeschalten.' }}" {{$has_api_token ? '' : 'disabled'}}>
                                Personen aus Cevi-DB importieren
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <p>Person Erstellen:</p>
                    {!! Form::open(['method' => 'POST', 'action'=>'AdminUsersController@store',  'files' => true]) !!}
                    <div class="form-group">
                        {!! Form::label('username', 'Name:') !!}
                        {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'name@abt', 'autocomplete' => 'username',  'required']) !!}
                    </div>
                    <div id="user_information_form">
                        <div class="form-group">
                            {!! Form::label('email', 'E-Mail:') !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'name@abt.ch', 'autocomplete' => 'email', 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('role_id', 'Rolle:') !!}
                            {!! Form::select('role_id', [''=>'Wähle Rolle'] + $roles, null, ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'Passwort:') !!}
                            {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'autocomplete' => 'new-password', 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password_confirmation', __('Passwort bestätigen')) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm', 'autocomplete' => 'new-password', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Person Erstellen', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}

                </div>
    {{--                <div class="col-lg-4">--}}
    {{--                    {!! Html::link('files/vorlage.xlsx', 'Vorlage herunterladen') !!}--}}
    {{--                    {!! Form::open(['action' => 'AdminUsersController@uploadFile', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}--}}
    {{--                    <div class="form-group">--}}
    {{--                        {{ Form::file('csv_file',['class' => 'dropify'])}}--}}
    {{--                    </div>--}}
    {{--                    {{ Form::submit('Teilnehmerliste hochladen', ['class' => 'btn btn-primary']) }}--}}
    {{--                    {!! Form::close() !!}--}}
    {{--                </div>--}}

                <div class="col-lg-6">
                    <table class="table table-striped table-bordered hover" style="width:100%" id="datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Rolle</th>
                                <th scope="col">Letztes Login</th>
                                <th scope="col">Aktiv</th>
                                <th>Aktionen</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="importModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Personen aus Cevi-DB importieren</h4>
                </div>
                <div class="modal-body">
                    <p>Vorraussetzungen für DB-Import:</p>
                    <ul>
                        <li>Zugewiesene Gruppe für den Kurs.</li>
                        <li>Zugewiesene Kurs ID für den Kurs.</li>
                    </ul>
                    <p>Erstellte Personen können sich über die Cevi-DB anmelden.</p>
                    <form id="modal-form" method="POST" action="javascript:void(0)">
                        <div class="form-group">
{{--                            <button data-remote='{{route('users.import')}}' id="importUsers"--}}
{{--                                    class="btn btn-primary btn-sm"><i class="fa fa-spinner fa-spin display-none"--}}
{{--                                                                      id="loading-spinner"></i> Personen importieren--}}
{{--                            </button>--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    $(document).ready(function(){
        $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            buttons: [],
            language: {
            "url": "/lang/Datatables.json"
            },
            ajax: "{!! route('users.CreateDataTables') !!}",
            columns: [
                {data: 'username', name: 'username' },
                {
                    data: {
                        _: 'role.display',
                        sort: 'role.sort'
                    },
                    name: 'role',
                },
                {data: 'last_login_at', name: 'last_login_at'},
                {data: 'active', name: 'active' },
                {data: 'Actions', name: 'Actions', orderable:false,serachable:false,sClass:'text-center'},
            ]
            });
        });
        $(document).on('focus','.autocomplete_txt',function(){
            autoType = $(this).attr('name');

            if(autoType =='username_add')type='username';

            $(this).autocomplete({
                minLength: 3,
                highlight: true,
                source: function( request, response ) {
                    $.ajax({
                        url: "{{ route('searchajaxuser') }}",
                        dataType: "json",
                        data: {
                            term : request.term,
                            type : type,
                        },
                        success: function(data) {
                            var array = $.map(data, function (item) {
                                return {
                                    label: item['username'] + ' - ' +  item['email'],
                                    value: item[autoType],
                                    data : item
                                }
                            });
                            response(array)
                        }
                    });
                },
                select: function( event, ui ) {
                    var data = ui.item.data;
                    $("[name='username']").val(data.username);
                    $("[name='user_id']").val(data.id);
                }
            });
    });
    $('#datatable').on('click', '.link--delete[data-remote]', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        var url = $(this).data('remote');
        // confirm then
        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            data: {method: 'POST', submit: true}
        }).always(function (data) {
            $('#datatable').DataTable().draw(false);
        });
    });
    </script>
@endpush
