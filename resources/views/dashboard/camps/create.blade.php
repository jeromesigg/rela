@extends('layouts.layout')
@section('page')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            @if ($errors->camps->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->camps->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
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
        </div>
    </section>
@endsection


@push('scripts')
    <script type="module">
        $(document).ready(function(){
            $(document).on('focus','.autocomplete_txt_group',function(){
                var type = $(this).attr('name');

                var autoType='name';
                if(type =='group_id') autoType='id';

                $(this).autocomplete({
                    minLength: 3,
                    highlight: true,
                    source: function( request, response ) {
                        $.ajax({
                            url: "{{ route('searchajaxgroups') }}",
                            dataType: "json",
                            data: {
                                term : request.term,
                                type : type,
                            },
                            success: function(data) {
                                var array = $.map(data, function (item) {
                                    return {
                                        label: item['short_name'] + ' ' + item['name'],
                                        value: item[autoType],
                                        data : item
                                    }
                                });
                                response(array)
                            }
                        });
                    },
                    select: function( event, ui ) {
                        var data = ui.item.data;
                        $("[name='group_text']").val(data.name);
                        $("[name='group_id']").val(data.id);
                    }
                });
            });

        });
    </script>
@endpush

