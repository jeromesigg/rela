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
                    <x-forms.form :action="route('helps.update', $help)" accept-charset="UTF-8" method="PATCH" :model="$help">
                        <x-forms.container>
                            <x-forms.text label="Titel:" name="title" required=true/>
                        </x-forms.container>
                        <x-forms.container>
                            <x-forms.text-area label="Inhalt:" name="content"  rows=10/>
                        </x-forms.container>
                        <x-forms.container>
                            <x-forms.button type="submit" class="btn btn-primary">
                                Artikel aktualisieren
                            </x-forms.button>
                        </x-forms.container> 
                    </x-forms.form>

                    <x-forms.form :action="route('helps.destroy', $help)" accept-charset="UTF-8" method="DELETE">
                        <x-forms.container>
                            <x-forms.button type="submit" class="btn btn-danger">
                                Artikel löschen
                            </x-forms.button>
                        </x-forms.container> 
                    </x-forms.form>
                </div>
            </div>
        </div>
    </section>
@endsection
