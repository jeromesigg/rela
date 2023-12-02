@extends('layouts.layout')
@section('styles')
    <script src="https://cdn.tiny.cloud/1/dmco08revieu0ga6o07bfko0qaesvi9j7isjtjnjmg61gb4x/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
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
                <li class="breadcrumb-item active">Hilfe-Artikel</li>
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
                <div class="col-sm-4">
                    <p>Artikel Erfassen:</p>
                    {!! Form::open(['method' => 'POST', 'action'=>'HelpController@store']) !!}
                    <div class="form-group">
                        {!! Form::label('title', 'Titel:') !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('content', 'Inhalt:') !!}
                        {!! Form::textarea('content', null, ['class' => 'form-control','rows' => 10, 'id' => "mytextarea"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Artikel Erfassen', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}
                </div>
                <div class="col-md-8">
                    <table class="table table-striped table-responsive" id="datatable">
                        <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>Titel</th>
                            <th>Inhalt</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($helps as $help)
                            <tr>
                                {{-- <th></th> --}}
                                <td><a href="{{route('helps.edit', $help)}}">{{$help['title']}}</a></td>
                                <td>{!! nl2br($help['content']) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
