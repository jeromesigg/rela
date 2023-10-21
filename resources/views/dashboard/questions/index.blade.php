@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Individuelle Fragen</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Individuelle Fragen</h1>
            </header>
            <div class="row">
                <div class="col-6">
                    {!! Form::open(['action'=>'QuestionController@store']) !!}
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            {!! Form::label('name', 'Frage:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                        <div class="form-group col-md-2">
                            {!! Form::label('sortindex', 'Sort-Index:') !!}
                            {!! Form::number('sortindex', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Frage erstellen', ['class' => 'btn btn-primary', 'id' => 'submit_btn'])!!}
                    </div>
                    {!! Form::close()!!}
                </div>
                <div class="col-6">
                    <table class="table table-striped table-bordered" style="width:100%" id="datatable">
                        <thead>
                            <tr>
                                <th>Frage</th>
                                <th>Aktiv</th>
                                <th>Sort Index</th>
                                <th>Aktionen</th>
                            </tr>
                        </thead>
                    </table>
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
                language: {
                    "url": "/lang/Datatables.json"
                },
                ajax: "{!! route('questions.CreateDataTables') !!}",
                columns: [
                    {data: 'name', name: 'name' },
                    {data: 'active', name: 'active' },
                    {data: 'sortindex', name: 'sortindex'},
                    {data: 'Actions', name: 'Actions', orderable:false,serachable:false,sClass:'text-center'},
                ]
            });
        });
        $('#datatable').on('click', '.btn-danger[data-remote]', function (e) {
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
                data: {method: 'DELETE', submit: true}
            }).always(function (data) {
                $('#datatable').DataTable().draw(false);
            });
        });
    </script>
@endsection
