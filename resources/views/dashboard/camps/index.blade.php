@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <div class="row">
                @if (!$camps)
                <div class="col-sm-3">
                    {!! Form::open(['action'=>'AdminCampsController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Lager erstellen', ['class' => 'btn btn-primary'])!!}
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
                                    <th scope="col">Lagerleiter</th>
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
                                                {!! Form::submit('Lager abschliessen?', ['class' => 'btn btn-danger confirm'])!!}
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('.confirm').on('click', function(e){
                e.preventDefault(); //cancel default action

                swal({
                    title: 'Lager löschen?',
                    text: 'Beim Lager löschen werden alle Interventionen und hochgeladenen Dokumente gelöscht.',
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

