@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Lager</h1>
            </header>
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::model($camp, ['method' => 'Patch', 'action'=>['AdminCampController@update',$camp->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('user_id', 'Lagerleiter:') !!}
                        {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('end_date', 'Schlussdatum:') !!}
                        {!! Form::date('end_date', null,  ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Änderungen speichern', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}
                    {!! Form::model($camp, ['method' => 'DELETE', 'action'=>['AdminCampController@destroy',$camp->id], 'id'=> "DeleteForm"]) !!}
                    <div class="form-group">
                        {!! Form::submit('Lager löschen', ['class' => 'btn btn-danger confirm'])!!}
                    </div>
                    {!! Form::close()!!}
                 </div>cd <e></e>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('.confirm').on('click', function(e){
                e.preventDefault(); //cancel default action

                swal({
                    title: 'Lager löschen?',
                    text: 'Beim Lager löschen werden alle Qualifikationen und hochgeladenen Dokumente gelöscht.',
                    icon: 'warning',
                    buttons: ["Abbrechen", "Ja!"],
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById("DeleteForm").submit();
                    }
                });
            });
        });
    </script>
@endpush
