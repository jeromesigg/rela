@extends('layouts.layout')

@section('page')
    <x-page-title :title="$title" :help="$help"/>
    <div class="wide" id="all">
        {!! Form::open(['method' => 'POST', 'action'=>'HealthFormController@store']) !!}
            <h4>1. Personalie</h4>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    {!! Form::label('first_name', 'Vorname:') !!}
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-3">
                    {!! Form::label('last_name', 'Name:') !!}
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('nickname', 'v/o:') !!}
                    {!! Form::text('nickname', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('birthday', 'Geburtstag:') !!}
                    {!! Form::date('birthday', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-md-2">
                    {!! Form::label('group_text', 'Abteilung:') !!}
                    {!! Form::text('group_text', null, ['class' => 'form-control autocomplete_txt_group', 'required']) !!}
                </div>
                {!! Form::hidden('group_id', null, ['class' => 'form-control autocomplete_txt_group']) !!}
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::label('street', 'Strasse:') !!}
                    {!! Form::text('street', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('zip_code', 'Postleitzahl:') !!}
                    {!! Form::number('zip_code', null, ['class' => 'form-control autocomplete_txt_city']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('city', 'Ortschaft:') !!}
                    {!! Form::text('city', null, ['class' => 'form-control autocomplete_txt_city']) !!}
                </div>
                {!! Form::hidden('city_id', null, ['class' => 'form-control autocomplete_txt_city']) !!}
                <div class="form-group col-md-2">
                    {!! Form::label('phone_number', 'Telefon:') !!}
                    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('auv', 'AHV-Nummer') !!}
                    {!! Form::text('ahv', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::submit('Gesundheitsblatt erstellen', ['class' => 'btn btn-primary'])!!}
            </div>
        {!! Form::close()!!}
    </div>

@endsection



@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
        //autocomplete script
            $(document).on('focus','.autocomplete_txt_city',function(){
                type = $(this).attr('name');

                if(type =='city')autoType='name';
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
                type = $(this).attr('name');

                if(type =='group_text')autoType='name';
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

