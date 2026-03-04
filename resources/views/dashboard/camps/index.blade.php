@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <div class="row">
                @if (!$camps)
                <div class="col-sm-3">
                <x-forms.form :action="route('camps.store')" accept-charset="UTF-8" method="POST">
                    <x-forms.container>
                        <x-forms.text label="Name:" name="name" required=true/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.text label="Schlussdatum:" name="end_date" type="date" required=true/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.checkbox label="Teilnehmer füllen selber Gesundheitsblatt aus" name="independent_form_fill" required=true/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.checkbox label="Keine Änderungen möglich nach Abschluss des Gesundheitsblattes" name="closed_when_finished"  required=true/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.checkbox label="Die Namen der Teilnehmenden werden auch den Helfenden angezeigt" name="show_names" required=true/>
                    </x-forms.container>
                    <x-forms.container>
                        <x-forms.text label="Abteilung:" name="group_text" required=true class="autocomplete_txt_group"/>
                    </x-forms.container>
                    <x-forms.hidden name="group_id" class="autocomplete_txt"/>
                    <x-forms.container>
                        <x-forms.button type="submit" class="btn btn-primary">
                            Lager erstellen
                        </x-forms.button>
                    </x-forms.container> 
                </x-forms.form>
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

