@extends('layouts.layout')

@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Kategorien</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Kategorien</h1>
            </header>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Kurzname</th>
                    <th scope="col">Parameter Name</th>
                    <th scope="col">Wert Name</th>
                    <th scope="col">Default Text</th>
                    <th scope="col">Bild</th>
                    <th scope="col">Mit Bildupload</th>
                    <th scope="col">Anzeigen</th>
                </tr>
                </thead>
                @foreach ($interventionClasses as $class)
                    <tbody>
                    <tr>
                        <td><a href="{{route('interventionclasses.edit',$class)}}">{{$class->name}}</a></td>
                        <td>{{$class->short_name}}</td>
                        <td>{{$class->parameter_name}}</td>
                        <td>{{$class->value_name}}</td>
                        <td>{{$class->default_text}}</td>
                        <td><img src="{{$class->file}}" alt="" width="100px"></td>
                        <td>{{$class->with_picture ? 'Ja' : 'Nein'}}</td>
                        <td>{{$class->show ? 'Ja' : 'Nein'}}</td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </section>
@endsection
