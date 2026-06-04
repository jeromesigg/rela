@extends('layouts.layout')
@section('page')
    <x-page-title :title="$title" :help="$help"/>
<section>
    <div class="container-fluid">
        <!-- Page Header-->
        <div class="row">

            <div class="col-sm-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <x-forms.form :action="route('dashboard.users.update', $user)" accept-charset="UTF-8" method="PATCH" :model="$user">
                    <x-forms.container>
                        <x-forms.text label="Name:" name="username" required=true placeholder="name@abt.ch" autocomplete="username"/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.text label="E-Mail:" name="email" type="email" required=true placeholder="name@abt.ch" autocomplete="email"/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.select label="Rolle:" name="role_id" required=true :collection="$roles"/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.checkbox label="Aktiv" name="active" value="{{$user['active']}}"/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.text label="Passwort:" name="password" required=true type="password" autocomplete="new-password"/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.text label="Passwort bestätigen:" name="password_confirmation" required=true type="password" autocomplete="new-password"/>
                    </x-forms.container>
                    <x-forms.hidden name="user_id" class="autocomplete_txt"/>
                    <x-forms.container>
                        <x-forms.button type="submit" class="btn btn-primary">
                            Person aktualisieren
                        </x-forms.button>
                    </x-forms.container> 
                </x-forms.form>

                <x-forms.form :action="route('dashboard.users.destroy', $user)" accept-charset="UTF-8" method="DELETE">
                    <x-forms.container>
                        <x-forms.button type="submit" class="btn btn-danger">
                            Person löschen
                        </x-forms.button>
                    </x-forms.container> 
                </x-forms.form>
            </div>
        </div>
    </div>
</section>
@endsection
