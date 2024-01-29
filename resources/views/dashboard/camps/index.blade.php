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
                                    <th scope="col">Code</th>
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
                                    <td>{{$camp['code']}}</a></td>
                                    <td>{{$camp->end_date > 1 ? date('d.m.Y', strtotime($camp->end_date)) : ''}}</a></td>
                                    <td>{{$camp->finish ? 'Ja' : 'Nein'}}</td>
                                    <td>
                                        @if (!$camp->finish && Auth::user()->camp['id'] === $camp['id'])
                                            <a href="{{ route('dashboard.camps.destroy', $camp) }}" class="btn btn-danger" data-confirm-delete="true">Lager abschliessen?</a>
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

