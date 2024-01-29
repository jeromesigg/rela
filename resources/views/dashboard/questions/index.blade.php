@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
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
                            {!! Form::number('sortindex', null, ['class' => 'form-control', 'required']) !!}
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

@push('scripts')
    <script type="module">
        $(document).ready(function(){
            $('#datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                buttons: [],
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
@endpush
