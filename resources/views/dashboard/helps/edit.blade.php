@extends('layouts.layout')
@section('styles')
    <script src="https://cdn.tiny.cloud/1/dmco08revieu0ga6o07bfko0qaesvi9j7isjtjnjmg61gb4x/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="module">
        tinymce.init({
            selector: 'textarea#mytextarea'
        });
    </script>
@endsection
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/helps">Hilfe-Artikel</a></li>
                <li class="breadcrumb-item active">Bearbeiten</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Hilfe-Artikel</h1>
            </header>
            <div class="row">

                <div class="col-sm-6">

                    {!! Form::model($help, ['method' => 'PATCH', 'action'=>['HelpController@update' , $help]]) !!}
                    <div class="form-group">
                        {!! Form::label('title', 'Titel:') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('content', 'Inhalt:') !!}
                        {!! Form::textarea('content', null, ['class' => 'form-control','rows' => 10, 'id' => "mytextarea"]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Hilfe-Artikel aktualisieren', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}

                    {!! Form::open(['method' => 'DELETE', 'action'=>['HelpController@destroy',$help]]) !!}
                    <div class="form-group">
                        {!! Form::submit('Hilfe-Artikel löschen', ['class' => 'btn btn-danger'])!!}
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </section>
@endsection
