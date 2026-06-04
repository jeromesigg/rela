@extends('layouts.layout')

@section('page')
    <div class="wide" id="all">
        <section class="py-5">
            <div class="container py-4">
                <x-page-title :title="$title" :help="$help" :header="false"/>
                <x-forms.form :action="route('healthform.edit')" accept-charset="UTF-8" method="POST">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session()->has('success'))
                            <div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>
                                    {!! session()->get('success') !!}
                                </strong>
                            </div>
                        @endif
                        <x-forms.row>
                            <x-forms.container class="col-md-6">
                                <x-forms.text label="Persönliche Nummer:" name="code" type="number" required=true/>
                            </x-forms.container>
                            <x-forms.container class="col-md-6">
                                <x-forms.text label="Lager-Nummer:" name="camp_code" type="number" required=true/>
                            </x-forms.container>
                        </x-forms.row>
                    </div>
                    <div class="text-right">
                        <x-forms.button type="submit" class="btn btn-primary">
                            Suchen
                        </x-forms.button>
                    </div>
                </x-forms.form>
            </div>
        </section>
    </div>
@endsection
