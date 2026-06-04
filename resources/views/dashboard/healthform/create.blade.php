@extends('layouts.layout')

@section('page')
    <x-page-title :title="$title" :help="$help"/>
    <div class="wide" id="all">
        <x-forms.form :action="route('healthforms.store')" accept-charset="UTF-8" method="POST" fullWidth=true>
            <h4>1. Personalie</h4>
            <hr>
             <x-forms.row>
                <x-forms.container class="col-md-3">
                    <x-forms.text label="Vorname:" name="first_name" required=true/>
                </x-forms.container>
                <x-forms.container class="col-md-3">
                    <x-forms.text label="Nachname:" name="last_name" required=tru/>
                </x-forms.container>
                <x-forms.container class="col-md-2">
                    <x-forms.text label="v/o:" name="nickname" required=true/>
                </x-forms.container>
                <x-forms.container class="col-md-2">
                    <x-forms.text label="Geburtstag:" name="birthday" type="date"/>
                </x-forms.container>
                <x-forms.container class="col-md-2">
                    <x-forms.text label="Abteilung:" name="group_text" class="autocomplete_txt_group"/>
                </x-forms.container>
                <x-forms.hidden name="group_id" class="autocomplete_txt_group"/>
            </x-forms.row>
            <x-forms.row>
                <x-forms.container class="col-md-4">
                    <x-forms.text label="Strasse:" name="street"/>
                </x-forms.container>
                <x-forms.container class="col-md-2">
                    <x-forms.text label="Postleitzahl:" name="zip_code" class="autocomplete_txt_city"/>
                </x-forms.container>
                <x-forms.container class="col-md-2">
                    <x-forms.text label="Ortschaft:" name="city" class="autocomplete_txt_city"/>
                </x-forms.container>
                <x-forms.hidden name="city_id" class="autocomplete_txt_city"/>
                <x-forms.container class="col-md-2">
                    <x-forms.text label="Telefon:" name="phone_number"/>
                </x-forms.container>
                <x-forms.container class="col-md-2">
                    <x-forms.text label="AHV-Nummer:" name="ahv"/>
                </x-forms.container>
            </x-forms.row>
            <x-forms.container>
                <x-forms.button type="submit" class="btn btn-primary">
                    Gesundheitsblatt erstellen
                </x-forms.button>
            </x-forms.container> 
        </x-forms.form>
    </div>

@endsection



@push('scripts')
    <script type="module">
        $(document).ready(function(){
        //autocomplete script
            $(document).on('focus','.autocomplete_txt_city',function(){
                var type = $(this).attr('name');

                var autoType='name';
                if(type =='zip_code')autoType='plz';
                if(type =='city_id')autoType='id';

                $(this).autocomplete({
                    minLength: 2,
                    highlight: true,
                    source: function( request, response ) {
                        $.ajax({
                            url: "{{ route('searchajaxcity') }}",
                            dataType: "json",
                            data: {
                                term : request.term,
                                type : type,
                            },
                            success: function(data) {
                                var array = $.map(data, function (item) {
                                    return {
                                        label: item['plz'] + ' ' + item['name'],
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
                        $("[name='city']").val(data.name);
                        $("[name='zip_code']").val(data.plz);
                        $("[name='city_id']").val(data.id);
                    }
                });
            });
            $(document).on('focus','.autocomplete_txt_group',function(){
                var type = $(this).attr('name');

                var autoType='name';
                if(type =='group_id')autoType='id';

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

