@extends('layouts.layout')
@section('page')
    <x-page-title :title="$title" :help="$help"/>
<section>
    <div class="container-fluid">
        <!-- Page Header-->
        <div class="row">
            <div class="col-sm-6">
                <x-forms.form :action="route('dashboard.questions.update', $question)" accept-charset="UTF-8" method="PATCH" :model="$question">
                    <x-forms.container>
                        <x-forms.text label="Name:" name="name" required=true/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.text label="Sort Index:" name="sortindex" type="number" required=true placeholder="0"/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.checkbox label="Aktiv" name="active" value="{{$question['active']}}"/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.button type="submit" class="btn btn-primary">
                            Individuelle Frage Aktualisieren
                        </x-forms.button>
                    </x-forms.container> 
                </x-forms.form>
            </div>
        </div>
    </div>
</section>
@endsection
