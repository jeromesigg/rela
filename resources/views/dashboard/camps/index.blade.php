@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin/">Dashboard</a></li>
            <li class="breadcrumb-item active">Kurs</li>
          </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Kurs</h1>
            </header>
            <div class="row">
                @if (!$camps)
                <div class="col-sm-3">
                    {!! Form::open(['action'=>'AdminCampsController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Kurs erstellen', ['class' => 'btn btn-primary'])!!}
                        </div>
                    {!! Form::close()!!}
                </div>
                @endif
                <div class="col-sm-9">
                    @if ($camps)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Kursleiter</th>
                                    <th scope="col">End-Datum</th>
                                    <th scope="col">Abgeschlossen</th>
                                    <th>Abschliessen?</th>
                                </tr>
                            </thead>
                        @foreach ($camps as $camp)
                            <tbody>
                                <tr>
                                    <td><a href="{{route('dashboard.camps.edit',$camp->id)}}">{{$camp->name}}</a></td>
                                    <td>{{$camp->user ? $camp->user['username'] : ''}}</a></td>
                                    <td>{{$camp->end_date > 1 ? date('d.m.Y', strtotime($camp->end_date)) : ''}}</a></td>
                                    <td>{{$camp->finish ? 'Ja' : 'Nein'}}</td>
                                    <td>
                                        @if (!$camp->finish && Auth::user()->camp['id'] === $camp['id'])
                                            {!! Form::model($camp, ['method' => 'DELETE', 'action'=>['AdminCampController@destroy',$camp], 'id'=> "DeleteForm"]) !!}
                                            <div class="form-group">
                                                {!! Form::submit('Kurs abschliessen?', ['class' => 'btn btn-danger confirm'])!!}
                                            </div>
                                            {!! Form::close()!!}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.confirm').on('click', function(e){
                e.preventDefault(); //cancel default action

                swal({
                    title: 'Kurs löschen?',
                    text: 'Beim Kurs löschen werden alle Interventionen und hochgeladenen Dokumente gelöscht.',
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
@endsection

